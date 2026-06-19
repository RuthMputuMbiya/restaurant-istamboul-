<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Paiement;
use App\Services\PaiementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Shwary\Enums\Country;
use Shwary\Exceptions\ShwaryException;
use Shwary\Shwary;

class PaiementController extends Controller
{
    public function index()
    {
        $commandes = Commande::where('client_id', Auth::id())
            ->whereIn('statut', ['en_attente', 'validee'])
            ->with(['ligneCommandes.menu', 'table'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.paiement.index', compact('commandes'));
    }

    public function payer(Commande $commande)
    {
        if ($commande->client_id != Auth::id()) {
            abort(403);
        }

        return view('client.paiement.payer', compact('commande'));
    }

    public function process(Request $request, Commande $commande)
    {
        $request->validate([
            'mode_paiement' => 'required|in:airtel_money,orange_money,especes,carte,flutterwave',
            'numero_telephone' => 'required_if:mode_paiement,airtel_money,orange_money,flutterwave|nullable|string|min:9|max:10'
        ]);

        $reference = 'CMD-' . $commande->id . '-' . time();
        $telephone = $request->numero_telephone;
        $montant = $commande->montant_total;

        DB::beginTransaction();

        try {
            $paiement = Paiement::create([
                'commande_id' => $commande->id,
                'client_id' => Auth::id(),
                'montant' => $montant,
                'mode_paiement' => $request->mode_paiement,
                'numero_telephone' => $telephone,
                'reference' => $reference,
                'statut' => 'en_cours',
                'date_paiement' => null
            ]);

            DB::commit();

            switch ($request->mode_paiement) {
                case 'airtel_money':
                    $result = PaiementService::airtelMoney($telephone, $montant, $reference);
                    if ($result['success']) {
                        $paiement->update([
                            'statut' => 'valide',
                            'transaction_id' => $result['data']['transaction_id'] ?? null,
                            'date_paiement' => now()
                        ]);
                        $commande->update(['statut' => 'paye']);
                        return redirect()->route('client.paiement.success', $commande)
                            ->with('success', 'Paiement Airtel Money effectué avec succès!');
                    }
                    return back()->with('error', $result['message']);
                    break;

                case 'orange_money':
                    $result = PaiementService::orangeMoney($telephone, $montant, $reference);
                    if ($result['success']) {
                        $paiement->update([
                            'statut' => 'valide',
                            'transaction_id' => $result['data']['transaction_id'] ?? null,
                            'date_paiement' => now()
                        ]);
                        $commande->update(['statut' => 'paye']);
                        return redirect()->route('client.paiement.success', $commande)
                            ->with('success', 'Paiement Orange Money effectué avec succès!');
                    }
                    return back()->with('error', $result['message']);
                    break;

                case 'flutterwave':
                    $result = PaiementService::flutterwave(
                        $telephone,
                        $montant,
                        $reference,
                        Auth::user()->email,
                        Auth::user()->name
                    );
                    if ($result['success']) {
                        return redirect($result['payment_link']);
                    }
                    return back()->with('error', $result['message']);
                    break;

                case 'especes':
                case 'carte':
                    $paiement->update([
                        'statut' => 'valide',
                        'date_paiement' => now()
                    ]);
                    $commande->update(['statut' => 'paye']);
                    return redirect()->route('client.paiement.success', $commande)
                        ->with('success', 'Commande confirmée. Paiement à effectuer à la livraison.');
                    break;

                default:
                    return back()->with('error', 'Mode de paiement non supporté');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur paiement: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors du paiement: ' . $e->getMessage());
        }
    }

    public function success(Commande $commande)
    {
        $paiement = Paiement::where('commande_id', $commande->id)
            ->where('statut', 'valide')
            ->first();

        return view('client.paiement.success', compact('commande', 'paiement'));
    }

    public function cancel(Commande $commande)
    {
        return view('client.paiement.cancel', compact('commande'));
    }

    public function historique()
    {
        $paiements = Paiement::where('client_id', Auth::id())
            ->with('commande.table')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('client.paiement.historique', compact('paiements'));
    }

    public function callback(Request $request)
    {
        Log::info('Callback paiement reçu', $request->all());

        $reference = $request->reference ?? $request->tx_ref;
        $status = $request->status ?? $request->transaction_status;

        $paiement = Paiement::where('reference', $reference)->first();

        if ($paiement && $status == 'success') {
            $paiement->update([
                'statut' => 'valide',
                'transaction_id' => $request->transaction_id ?? $request->id,
                'date_paiement' => now()
            ]);
            $paiement->commande->update(['statut' => 'paye']);
        }

        return response()->json(['status' => 'ok']);
    }

    // CORRIGÉ - Récupère la commande complète
    public function form_payement($idcommande)
    {
        // Récupérer la commande complète avec ses lignes
        $commande = Commande::with(['ligneCommandes.menu', 'client', 'table'])
            ->findOrFail($idcommande);

        // Récupérer la première ligne de commande (pour l'affichage)
        $ligne = $commande->ligneCommandes->first();

        return view('client.paiement.form_payement', compact('commande', 'ligne'));
    }

    // CORRIGÉ - Utilise le bon ID de commande
    public function payercom(Request $request)
    {
        $payData = $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'montant' => 'required|numeric|min:0',
            'numero_telephone' => 'nullable|string|min:9|max:10'
        ]);

        // Récupérer la commande complète
        $commande = Commande::with(['ligneCommandes.menu'])->findOrFail($payData['commande_id']);

        // Vérifier que le montant correspond
        if ($payData['montant'] != $commande->montant_total) {
            return back()->withErrors('Le montant ne correspond pas à la commande.');
        }

        Shwary::initFromArray([
            'merchant_id' => env('SHWARY_MERCHANT_ID', 'f471e6bf-e4fd-4221-9f8c-5c2d00728aa3'),
            'merchant_key' => env('SHWARY_MERCHANT_KEY', 'shwary_a1a64404-b91e-433a-b288-e393cefb5fe1'),
            'sandbox' => env('SHWARY_SANDBOX', false),
            'timeout' => 60,
        ]);

        $country = Country::DRC;
        $amount = (int)$payData['montant'];
        $phone = '+243' . ltrim($payData['numero_telephone'], '+243');
        $user = Auth::user();

        try {
            $transaction = Shwary::pay(
                country: $country,
                amount: $amount,
                phone: $phone,
                callbackUrl: route('api.paiement.callback'),
            );

            if ($transaction) {
                Paiement::create([
                    'commande_id' => $commande->id,
                    'client_id' => $user->id,
                    'montant' => $payData['montant'],
                    'mode_paiement' => 'Mobile Money',
                    'numero_telephone' => $phone,
                    'reference' => 'REF-' . uniqid(),
                    'transaction_id' => $transaction->id ?? null,
                    'statut' => 'en_attente',
                    'date_paiement' => now(),
                    'response_data' => json_encode($transaction->toArray() ?? [])
                ]);

                return redirect()->route('client.paiement.success', $commande->id)
                    ->with('success', 'Paiement initié avec succès. En attente de confirmation.');
            }

            return back()->withErrors('Échec du paiement: Transaction non aboutie');
        } catch (ShwaryException $e) {
            Log::error('ShwaryException: ' . $e->getMessage());
            return back()->withErrors('Erreur lors du paiement: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Paiement error: ' . $e->getMessage());
            return back()->withErrors('Erreur: ' . $e->getMessage());
        }
    }
}
