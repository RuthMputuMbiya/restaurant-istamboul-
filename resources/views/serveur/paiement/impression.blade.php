<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Impression - Commande #{{ $commande->numero_commande ?? $commande->id }}</title>
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', 'Segoe UI', monospace;
            font-size: 11px;
            width: 80mm;
            margin: 0 auto;
            padding: 8px;
            background: #f5f5f5;
        }
        .ticket {
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        /* Header */
        .header {
            text-align: center;
            background: linear-gradient(135deg, #1a472a 0%, #0d2818 100%);
            color: white;
            padding: 15px 10px;
        }
        .header h2 {
            font-size: 18px;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 9px;
            margin: 2px 0;
            opacity: 0.9;
        }
        .header .divider {
            width: 40px;
            height: 2px;
            background: #f59e0b;
            margin: 8px auto 0;
        }
        /* Body */
        .ticket-body {
            padding: 15px 12px;
        }
        /* Info lines */
        .info-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 10px;
            padding-bottom: 4px;
            border-bottom: 1px dotted #e2e8f0;
        }
        .info-label {
            font-weight: 600;
            color: #475569;
        }
        .info-value {
            font-weight: 600;
            color: #1e293b;
        }
        /* Client info special */
        .client-info {
            background: #fef3c7;
            padding: 8px 10px;
            border-radius: 8px;
            margin: 10px 0;
            border-left: 3px solid #f59e0b;
        }
        .client-info .info-line {
            border-bottom: none;
            margin-bottom: 3px;
        }
        /* Separator */
        .separator {
            border-top: 1px dashed #cbd5e1;
            margin: 10px 0;
        }
        .separator-double {
            border-top: 2px solid #1a472a;
            margin: 10px 0;
        }
        /* Items table */
        .items-table {
            width: 100%;
            margin: 10px 0;
            border-collapse: collapse;
        }
        .items-table th {
            text-align: left;
            font-size: 9px;
            padding: 6px 0;
            border-bottom: 1px solid #cbd5e1;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 5px 0;
            font-size: 10px;
            border-bottom: 1px dotted #e2e8f0;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        /* Total */
        .total-line {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-top: 10px;
            padding: 10px 0;
            border-top: 2px solid #1a472a;
            font-size: 13px;
        }
        .total-line span:last-child {
            color: #d97706;
            font-size: 14px;
        }
        /* Payment info */
        .payment-info {
            margin: 12px 0;
            padding: 10px;
            background: #f0fdf4;
            border-radius: 8px;
            border-left: 3px solid #10b981;
        }
        .payment-info .info-line {
            border-bottom: none;
            margin-bottom: 5px;
        }
        /* Footer */
        .thankyou {
            text-align: center;
            margin: 15px 0 10px;
        }
        .thankyou p {
            font-size: 11px;
            font-weight: bold;
            color: #1a472a;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            background: #f8fafc;
            font-size: 8px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            .ticket {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <!-- En-tête -->
        <div class="header">
            <h2>🍽️ ISTAMBOUL</h2>
            <p>Restaurant - Lounge - Bar</p>
            <p>Avenue Mahenge, Lubumbashi</p>
            <p>Tél: +243 97 000 0000</p>
            <div class="divider"></div>
        </div>
        
        <div class="ticket-body">
            <!-- Informations commande -->
            <div class="info-line">
                <span class="info-label">📋 Commande</span>
                <span class="info-value"><strong>{{ $commande->numero_commande ?? 'CMD-'.$commande->id }}</strong></span>
            </div>
            <div class="info-line">
                <span class="info-label">📅 Date</span>
                <span class="info-value">{{ now()->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-line">
                <span class="info-label">🪑 Table</span>
                <span class="info-value">{{ $commande->table->numero ?? '🚪 Emporter' }}</span>
            </div>
            <div class="info-line">
                <span class="info-label">👨‍🍳 Serveur</span>
                <span class="info-value">{{ Auth::user()->name }}</span>
            </div>
            
            <div class="separator"></div>
            
            <!-- Informations client et téléphone -->
            <div class="client-info">
                <div class="info-line">
                    <span class="info-label">👤 Client</span>
                    <span class="info-value">{{ $commande->client->name ?? 'Anonyme' }}</span>
                </div>
                @if($commande->paiement && $commande->paiement->numero_telephone)
                <div class="info-line">
                    <span class="info-label">📱 Téléphone</span>
                    <span class="info-value">+243 {{ $commande->paiement->numero_telephone }}</span>
                </div>
                @endif
            </div>
            
            <!-- Détails des plats -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Article</th>
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
                        <td style="text-align: right">{{ number_format($ligne->prix_unitaire, 0, ',', ' ') }}</td>
                        <td style="text-align: right">{{ number_format($sousTotal, 0, ',', ' ') }}</td>
                    </tr>
                    @if($ligne->instructions)
                    <tr>
                        <td colspan="4" style="font-size: 8px; color: #d97706; padding-top: 0;">
                            📝 Note: {{ $ligne->instructions }}
                        </td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
            
            <div class="separator-double"></div>
            
            <!-- Total -->
            <div class="total-line">
                <span>💰 TOTAL</span>
                <span>{{ number_format($total, 0, ',', ' ') }} FC</span>
            </div>
            
            <!-- Informations paiement -->
            <div class="payment-info">
                <div class="info-line">
                    <span class="info-label">💳 Mode de paiement</span>
                    <span class="info-value">
                        @if($commande->paiement->mode_paiement == 'especes')
                            💵 ESPÈCES
                        @elseif($commande->paiement->mode_paiement == 'airtel_money')
                            📱 AIRTEL MONEY
                        @elseif($commande->paiement->mode_paiement == 'orange_money')
                            📱 ORANGE MONEY
                        @else
                            💳 CARTE BANCAIRE
                        @endif
                    </span>
                </div>
                @if($commande->paiement->reference)
                <div class="info-line">
                    <span class="info-label">🔖 Référence</span>
                    <span class="info-value">{{ $commande->paiement->reference }}</span>
                </div>
                @endif
                <div class="info-line">
                    <span class="info-label">✅ Montant payé</span>
                    <span class="info-value">{{ number_format($commande->paiement->montant, 0, ',', ' ') }} FC</span>
                </div>
                @if(session('monnaie') && session('monnaie') > 0)
                <div class="info-line">
                    <span class="info-label">🔄 Monnaie rendue</span>
                    <span class="info-value" style="color: #059669;">{{ number_format(session('monnaie'), 0, ',', ' ') }} FC</span>
                </div>
                @endif
            </div>
            
            <!-- Remerciements -->
            <div class="thankyou">
                <p>🍽️ MERCI DE VOTRE VISITE ! 🍽️</p>
                <p style="font-size: 9px; margin-top: 5px;">À bientôt chez ISTAMBOUL</p>
            </div>
        </div>
        
        <div class="footer">
            <p>Ticket généré le {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>Ce document fait office de garantie</p>
            <p>⭐ Suivez-nous sur Instagram @istamboul_resto ⭐</p>
        </div>
    </div>
    
    <script>
        // Impression automatique
        window.print();
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>
</html>