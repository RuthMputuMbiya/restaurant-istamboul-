<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ISTAMBOUL</title>
        <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        label {
            color:blue;
            font-family: 'Goudy Old Style', sans-serif;
        }
        @media(min-width: 700px) {
            .corps {
                max-width: 500px;
            }
        }
        @media(max-width: 700px) {
           .corps {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="card p-3">
        <h1>Payement de votre commande ID: {{ $commande->id }}</h1>
    </div>
    <div class="container p-5 corps">
        
        <div class="mb-3 row">
            <div class="img col">
               <img src="{{ Storage::url($commande->menu->image) }}" alt="{{ $commande->menu->nom ?? '--' }}" class="img-fluid">
            </div>
            <div class="card col mb-3">
                 <div>
                    <p><b class="fs-2">{{ $commande->menu->nom ?? '--' }}</b></p>
                 </div>
                    <hr>
                 <div>
                    <p><b>P.U:</b>{{ $commande->quantite ?? '--' }}</p>
                 </div>
                 <div>
                    <p><b>P.U:</b>{{ $commande->menu->prix ?? '--' }}</p>
                 </div>
                 <div>
                    <p><b>P.T:</b>{{ ($commande->menu->prix ?? 0)*($commande->quantite ?? 0) }}</p>
                 </div>
            </div>
        </div>
        <div class="container shadow-lg rounded-3 p-4">
            <div class="m-4">
                <form action="{{ route('client.payercom') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="commande_id" class="form-label">ID de la commande</label>
                        <input type="text" class="form-control" id="commande_id" name="commande_id" value="{{ $commande->id }}" readonly="readonly" required="required">
                    </div>

                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant</label>
                        <input type="number" class="form-control" id="montant" name="montant" value="{{ ($commande->menu->prix ?? 0)*($commande->quantite ?? 1) }}" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="numero_telephone" class="form-label">Numéro de téléphone</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-primary text-white">+243</span>
                            <input type="tel" class="form-control" id="numero_telephone" name="numero_telephone" pattern="[0-9]{9}" maxlength="9" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Procéder au paiement</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>