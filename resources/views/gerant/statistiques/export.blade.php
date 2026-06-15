{{-- resources/views/gerant/statistiques/export.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rapport de ventes - ISTAMBOUL</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 24px;
        }
        .header h2 {
            margin: 5px 0;
            color: #27ae60;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
            font-size: 12px;
        }
        .summary {
            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
        }
        .summary td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .summary .label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 30%;
        }
        .summary .value {
            font-weight: bold;
            color: #27ae60;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding: 8px;
            background-color: #3498db;
            color: white;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background-color: #2c3e50;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table.data td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        table.data .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #7f8c8d;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        .badge-success {
            background-color: #27ae60;
            color: white;
        }
        .badge-warning {
            background-color: #f39c12;
            color: white;
        }
        .badge-info {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ISTAMBOUL RESTAURANT</h1>
        <h2>Rapport de ventes</h2>
        <p>{{ $titre }}</p>
        <p>Généré le {{ now()->format('d/m/Y à H:i:s') }}</p>
    </div>

    <table class="summary">
        <tr>
            <td class="label">Chiffre d'affaires</td>
            <td class="value">{{ number_format($ca, 0, ',', ' ') }} FC</td>
        </tr>
        <tr>
            <td class="label">Nombre de commandes</td>
            <td class="value">{{ $nbCommandes }}</td>
        </tr>
        <tr>
            <td class="label">Panier moyen</td>
            <td class="value">{{ number_format($panierMoyen, 0, ',', ' ') }} FC</td>
        </tr>
    </table>

    <div class="section-title">📊 Top 10 des plats les plus vendus</div>
    <table class="data">
        <thead>
            <tr>
                <th>#</th>
                <th>Plat</th>
                <th class="text-right">Quantité vendue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topPlats as $index => $plat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $plat->nom }}</td>
                <td class="text-right">{{ $plat->total_ventes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">💰 Modes de paiement</div>
    <table class="data">
        <thead>
            <tr>
                <th>Mode de paiement</th>
                <th class="text-right">Nombre de transactions</th>
                <th class="text-right">Montant total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modesPaiement as $mode)
            <tr>
                <td>
                    @if($mode->mode_paiement == 'especes')
                        💵 Espèces
                    @elseif($mode->mode_paiement == 'airtel_money')
                        📱 Airtel Money
                    @elseif($mode->mode_paiement == 'orange_money')
                        📱 Orange Money
                    @else
                        💳 Carte bancaire
                    @endif
                </td>
                <td class="text-right">{{ $mode->total }}</td>
                <td class="text-right">{{ number_format($mode->montant, 0, ',', ' ') }} FC</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">📋 Détail des commandes</div>
    <table class="data">
        <thead>
            <tr>
                <th>N° Commande</th>
                <th>Date</th>
                <th>Table</th>
                <th>Plats</th>
                <th class="text-right">Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commandes as $commande)
            <tr>
                <td>#{{ $commande->id }}</td>
                <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                <td>Table {{ $commande->table->numero ?? 'Emporter' }}</td>
                <td>
                    @foreach($commande->ligneCommandes as $ligne)
                        {{ $ligne->quantite }}x {{ $ligne->menu->nom }}<br>
                    @endforeach
                </td>
                <td class="text-right">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>{{ number_format($ca, 0, ',', ' ') }} FC</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>ISTAMBOUL Restaurant - Avenue Mahenge, Lubumbashi</p>
        <p>Ce rapport est généré automatiquement par le système de gestion</p>
    </div>
</body>
</html>