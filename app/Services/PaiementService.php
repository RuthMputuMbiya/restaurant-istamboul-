<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaiementService
{
    // Paiement via Airtel Money
    public static function airtelMoney($telephone, $montant, $reference)
    {
        try {
            $response = Http::withHeaders([
                'X-Client-Id' => env('AIRTL_MONEY_CLIENT_ID'),
                'X-Client-Secret' => env('AIRTL_MONEY_CLIENT_SECRET'),
                'X-Api-Key' => env('AIRTL_MONEY_API_KEY'),
                'Content-Type' => 'application/json'
            ])->post(env('AIRTL_MONEY_API_URL'), [
                'reference' => $reference,
                'subscriber' => [
                    'country' => 'CD',
                    'currency' => 'CDF',
                    'msisdn' => '243' . ltrim($telephone, '0')
                ],
                'transaction' => [
                    'amount' => $montant,
                    'country' => 'CD',
                    'currency' => 'CDF',
                    'id' => $reference
                ],
                'payer' => [
                    'type' => 'customer',
                    'id' => $telephone
                ]
            ]);
            
            Log::info('Airtel Money Response', ['response' => $response->json()]);
            
            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }
            
            return ['success' => false, 'message' => $response->json()['message'] ?? 'Erreur Airtel Money'];
            
        } catch (\Exception $e) {
            Log::error('Airtel Money Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    // Paiement via Orange Money
    public static function orangeMoney($telephone, $montant, $reference)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => env('ORANGE_MONEY_AUTHORIZATION'),
                'Content-Type' => 'application/json'
            ])->post(env('ORANGE_MONEY_API_URL'), [
                'merchant_key' => env('ORANGE_MONEY_MERCHANT_KEY'),
                'currency' => 'CDF',
                'order_id' => $reference,
                'amount' => $montant,
                'phone_number' => '243' . ltrim($telephone, '0'),
                'return_url' => route('client.paiement.success'),
                'cancel_url' => route('client.paiement.cancel'),
                'notif_url' => env('PAIEMENT_CALLBACK_URL'),
                'lang' => 'fr'
            ]);
            
            Log::info('Orange Money Response', ['response' => $response->json()]);
            
            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }
            
            return ['success' => false, 'message' => $response->json()['description'] ?? 'Erreur Orange Money'];
            
        } catch (\Exception $e) {
            Log::error('Orange Money Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    // Paiement via Flutterwave (International)
    public static function flutterwave($telephone, $montant, $reference, $email, $nom)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('FLW_SECRET_KEY'),
                'Content-Type' => 'application/json'
            ])->post('https://api.flutterwave.com/v3/payments', [
                'tx_ref' => $reference,
                'amount' => $montant,
                'currency' => 'CDF',
                'redirect_url' => route('client.paiement.success'),
                'payment_options' => 'mobilemoney',
                'customer' => [
                    'email' => $email,
                    'phonenumber' => '243' . ltrim($telephone, '0'),
                    'name' => $nom
                ],
                'customizations' => [
                    'title' => 'Restaurant Istanbul',
                    'description' => 'Paiement commande restaurant'
                ]
            ]);
            
            Log::info('Flutterwave Response', ['response' => $response->json()]);
            
            if ($response->successful() && $response->json()['status'] == 'success') {
                return ['success' => true, 'payment_link' => $response->json()['data']['link']];
            }
            
            return ['success' => false, 'message' => $response->json()['message'] ?? 'Erreur Flutterwave'];
            
        } catch (\Exception $e) {
            Log::error('Flutterwave Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}