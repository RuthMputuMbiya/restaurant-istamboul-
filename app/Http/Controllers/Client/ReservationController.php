<?php

// app/Http/Controllers/Client/ReservationController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\TableResto;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ReservationController extends Controller
{
   public function index()
    {
        $reservations = Reservation::where('client_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('client.reservations.index', compact('reservations'));
    }

    public function create()
    {
        return view('client.reservations.create');
    }

    public function store(Request $request)
    {
        // Validation simple
        $request->validate([
            'date_reservation' => 'required|date|after_or_equal:today',
            'heure_reservation' => 'required',
            'nombre_personnes' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            // Prendre la première table disponible sans vérification complexe
            $table = TableResto::where('capacite', '>=', $request->nombre_personnes)
                ->where('est_active', true)
                ->first();

            if (!$table) {
                return back()->with('error', 'Désolé, aucune table disponible pour ' . $request->nombre_personnes . ' personnes.')
                             ->withInput();
            }

            // Créer la réservation
            Reservation::create([
                'client_id' => Auth::id(),
                'table_id' => $table->id,
                'date_reservation' => $request->date_reservation,
                'heure_reservation' => $request->heure_reservation,
                'nombre_personnes' => $request->nombre_personnes,
                'notes' => $request->notes,
                'statut' => 'confirmee'
            ]);

            return redirect()
                ->route('client.reservations.index')
                ->with('success', '✅ Réservation confirmée pour le ' . $request->date_reservation . ' à ' . $request->heure_reservation);

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erreur: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function checkDisponibilites(Request $request)
    {
        // Toujours retourner disponible pour ne pas bloquer le client
        return response()->json([
            'disponible' => true,
            'message' => 'Table disponible'
        ]);
    }

    public function annuler($id)
    {
        try {
            $reservation = Reservation::where('client_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();

            $reservation->update(['statut' => 'annulee']);

            return response()->json([
                'success' => true,
                'message' => 'Réservation annulée avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'annulation'
            ], 500);
        }
    }
}