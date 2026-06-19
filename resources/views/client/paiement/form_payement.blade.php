<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paiement - ISTAMBOUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .card-paiement {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #1a472a, #0d2818);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .card-header-custom h1 {
            font-size: 20px;
            font-weight: 700;
        }
        .card-body-custom {
            padding: 30px;
            background: white;
        }
        .produit-info {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .produit-info img {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 12px;
        }
        .price-display {
            font-size: 28px;
            font-weight: 800;
            color: #10b981;
        }
        .btn-payer {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            border-radius: 50px;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        .btn-payer:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16,185,129,0.4);
            color: white;
        }
        .btn-retour {
            background: #6c757d;
            border: none;
            padding: 12px;
            font-weight: 500;
            border-radius: 50px;
            width: 100%;
            color: white;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: all 0.3s;
        }
        .btn-retour:hover {
            background: #5a6268;
            color: white;
        }
        .input-group-text-custom {
            background: #10b981;
            color: white;
            border: none;
        }
        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 0.2rem rgba(16,185,129,0.25);
        }
        label {
            font-weight: 600;
            color: #1e293b;
        }
        @media (max-width: 768px) {
            .card-paiement {
                margin: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 rounded-3">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3 rounded-3">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-paiement">
            <div class="card-header-custom">
                <h1><i class="fas fa-credit-card me-2"></i>Paiement</h1>
                <p class="mb-0 opacity-75">Commande #{{ $commande->id }}</p>
            </div>

            <div class="card-body-custom">
                <!-- Produit -->
                <div class="produit-info">
                    <div class="row align-items-center">
                        <div class="col-4">
                            @if($ligne && $ligne->menu && $ligne->menu->image)
                                <img src="{{ Storage::url($ligne->menu->image) }}" alt="{{ $ligne->menu->nom ?? 'Plat' }}">
                            @else
                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                                    <i class="fas fa-utensils fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-8">
                            <h5 class="fw-bold mb-1">{{ $ligne->menu->nom ?? 'Plat' }}</h5>
                            <p class="text-muted small mb-2">Quantité: {{ $ligne->quantite ?? 1 }}</p>
                            <p class="text-muted small mb-0">Prix unitaire: {{ number_format($ligne->menu->prix ?? 0, 0, ',', ' ') }} FC</p>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="text-center mb-4">
                    <p class="text-muted">Total à payer</p>
                    <h2 class="price-display">{{ number_format($commande->montant_total, 0, ',', ' ') }} FC</h2>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('client.payercom') }}" method="POST">
                    @csrf

                    <!-- ID Commande - READONLY avec le bon ID -->
                    <div class="mb-3">
                        <label for="commande_id" class="form-label">ID Commande</label>
                        <input type="text" class="form-control" id="commande_id" name="commande_id" 
                               value="{{ $commande->id }}" readonly>
                    </div>

                    <!-- Montant - READONLY avec le bon montant -->
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" 
                               value="{{ $commande->montant_total }}" readonly>
                    </div>

                    <!-- Numéro de téléphone -->
                    <div class="mb-4">
                        <label for="numero_telephone" class="form-label">Numéro de téléphone Mobile Money</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-custom">+243</span>
                            <input type="tel" class="form-control" id="numero_telephone" name="numero_telephone" 
                                   pattern="[0-9]{9}" maxlength="9" placeholder="812345678" required>
                        </div>
                        <small class="text-muted">Entrez votre numéro Airtel Money ou Orange Money</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn-payer">
                            <i class="fas fa-check-circle me-2"></i>Confirmer le paiement
                        </button>
                        <a href="{{ route('client.paiement.index') }}" class="btn-retour">
                            <i class="fas fa-arrow-left me-2"></i>Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>