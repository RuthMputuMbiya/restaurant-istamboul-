<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu - Commande #{{ $commande->numero_commande ?? $commande->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', 'Courier New', monospace;
            background: #e8ecf1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .receipt {
            max-width: 400px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        
        /* Header */
        .receipt-header {
            background: #1a1a2e;
            color: white;
            text-align: center;
            padding: 25px 20px;
            border-bottom: 3px solid #f59e0b;
        }
        .receipt-header h2 {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .receipt-header p {
            font-size: 11px;
            opacity: 0.7;
            margin: 3px 0;
        }
        .receipt-header .separator {
            width: 50px;
            height: 2px;
            background: #f59e0b;
            margin: 12px auto 0;
        }
        
        /* Body */
        .receipt-body {
            padding: 20px;
        }
        
        /* Info rows */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 12px;
        }
        .info-label {
            font-weight: 600;
            color: #64748b;
        }
        .info-value {
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Client section */
        .client-section {
            background: #fffbeb;
            padding: 12px 15px;
            border-radius: 12px;
            margin: 15px 0;
            border-left: 3px solid #f59e0b;
        }
        .client-section .info-row {
            border-bottom: none;
            margin-bottom: 5px;
            padding-bottom: 0;
        }
        
        /* Items table */
        .items-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }
        .items-table th {
            text-align: left;
            font-size: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 6px 0;
            font-size: 11px;
            border-bottom: 1px dotted #e2e8f0;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Total */
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            margin-top: 10px;
            border-top: 2px solid #1a1a2e;
            font-weight: 800;
            font-size: 16px;
        }
        .total-row span:last-child {
            color: #d97706;
            font-size: 18px;
        }
        
        /* Payment info */
        .payment-info {
            background: #f0fdf4;
            padding: 12px 15px;
            border-radius: 12px;
            margin: 15px 0;
            border-left: 3px solid #10b981;
        }
        .payment-info .info-row {
            border-bottom: none;
            margin-bottom: 5px;
            padding-bottom: 0;
        }
        
        /* Thank you */
        .thankyou {
            text-align: center;
            margin: 20px 0 10px;
            padding: 12px;
            background: #fef2f2;
            border-radius: 12px;
        }
        .thankyou p {
            font-size: 13px;
            font-weight: 700;
            color: #dc2626;
        }
        .thankyou small {
            font-size: 10px;
            color: #64748b;
            display: block;
            margin-top: 5px;
        }
        
        /* Footer */
        .receipt-footer {
            text-align: center;
            padding: 15px;
            background: #f8fafc;
            font-size: 9px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        
        /* Print button */
        .print-btn {
            display: block;
            width: calc(100% - 40px);
            margin: 20px;
            padding: 12px;
            background: #1a1a2e;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .print-btn:hover {
            background: #f59e0b;
            transform: translateY(-2px);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .print-btn {
                display: none;
            }
            .receipt {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h2>ISTANBOUL</h2>
            <p>Restaurant /istanboul </p>
            <p>Avenue Mahenge, Lubumbashi</p>
            <p>Tél: +243 99 718 5648</p>
            <div class="separator"></div>
        </div>
        
        <div class="receipt-body">
            <!-- Infos commande -->
            <div class="info-row">
                <span class="info-label">N° Commande</span>
                <span class="info-value"><strong>{{ $commande->numero_commande ?? 'CMD-'.$commande->id }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Date</span>
                <span class="info-value">{{ now()->format('d/m/Y H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Table</span>
                <span class="info-value">{{ $commande->table->numero ?? 'À emporter' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Serveur</span>
                <span class="info-value">{{ Auth::user()->name }}</span>
            </div>
            
            <!-- Client -->
            <div class="client-section">
                <div class="info-row">
                    <span class="info-label">Client</span>
                    <span class="info-value">{{ $commande->client->name ?? 'Anonyme' }}</span>
                </div>
                @php
                    $telephone = $commande->paiement->numero_telephone ?? null;
                @endphp
                @if($telephone)
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-value">+243 {{ $telephone }}</span>
                </div>
                @endif
            </div>
            
            <!-- Produits -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th style="text-align: center">Qté</th>
                        <th style="text-align: right">Prix</th>
                        <th style="text-align: right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($commande->ligneCommandes as $ligne)
                    @php $sousTotal = $ligne->quantite * $ligne->prix_unitaire; $total += $sousTotal; @endphp
                    <tr>
                        <td>{{ $ligne->menu->nom }}</td>
                        <td style="text-align: center">{{ $ligne->quantite }}</td>
                        <td style="text-align: right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }} FC</span>
                        <td style="text-align: right">{{ number_format($sousTotal, 0, ',', ' ') }} FC</span>
                    </tr>
                    @if($ligne->instructions)
                    <tr style="background: #fffbeb;">
                        <td colspan="4" style="font-size: 9px; color: #d97706; padding-top: 0;">
                            📝 Note: {{ $ligne->instructions }}
                        </span>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            
            <!-- Total -->
            <div class="total-row">
                <span>TOTAL</span>
                <span>{{ number_format($total, 0, ',', ' ') }} FC</span>
            </div>
            
            <!-- Paiement -->
            <div class="payment-info">
                <div class="info-row">
                    <span class="info-label">Mode de paiement</span>
                    <span class="info-value">
                        @if($commande->paiement->mode_paiement == 'airtel_money') 📱 Airtel Money
                        @elseif($commande->paiement->mode_paiement == 'orange_money') 📱 Orange Money
                        @else 💳 {{ ucfirst($commande->paiement->mode_paiement) }}
                        @endif
                    </span>
                </div>
                @if($commande->paiement->reference)
                <div class="info-row">
                    <span class="info-label">Référence</span>
                    <span class="info-value">{{ $commande->paiement->reference }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Montant payé</span>
                    <span class="info-value">{{ number_format($commande->paiement->montant, 0, ',', ' ') }} FC</span>
                </div>
                @if(session('monnaie') && session('monnaie') > 0)
                <div class="info-row">
                    <span class="info-label">Monnaie rendue</span>
                    <span class="info-value" style="color: #059669;">{{ number_format(session('monnaie'), 0, ',', ' ') }} FC</span>
                </div>
                @endif
            </div>
            
            <!-- Remerciements -->
            <div class="thankyou">
                <p>MERCI DE VOTRE VISITE !</p>
                <small>À bientôt chez ISTAMBOUL</small>
            </div>
        </div>
        
        <div class="receipt-footer">
            <p>Reçu généré le {{ now()->format('d/m/Y à H:i:s') }}</p>
            <p>Ce document fait office de garantie</p>
        </div>
    </div>
    
    <button class="print-btn" onclick="window.print()">
        🖨️ Imprimer le reçu
    </button>
</body>
</html>