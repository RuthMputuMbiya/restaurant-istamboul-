@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Bienvenue chez <span class="highlight">RestoManager</span></h1>
            <p class="hero-subtitle">Découvrez une expérience culinaire unique dans un cadre exceptionnel</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus"></i> S'inscrire
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </a>
            </div>
        </div>
    </div>
</div>

<div class="features-section">
    <div class="container">
        <div class="section-header">
            <h2>Pourquoi nous choisir ?</h2>
            <p>Découvrez nos atouts qui font notre différence</p>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h3>Cuisine raffinée</h3>
                    <p>Des plats préparés avec des ingrédients frais et de qualité</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3>Service rapide</h3>
                    <p>Une équipe dédiée pour vous servir rapidement et efficacement</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-smile"></i>
                    </div>
                    <h3>Ambiance chaleureuse</h3>
                    <p>Un cadre agréable pour passer un moment inoubliable</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="menu-preview">
    <div class="container">
        <div class="section-header">
            <h2>Nos spécialités</h2>
            <p>Découvrez nos plats les plus populaires</p>
        </div>
        <div class="row">
            @foreach($featuredProducts ?? [] as $product)
            <div class="col-md-3 mb-4">
                <div class="menu-item">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/250' }}" alt="{{ $product->name }}">
                    <div class="menu-item-info">
                        <h4>{{ $product->name }}</h4>
                        <p>{{ number_format($product->price, 0, ',', ' ') }} CFA</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary">
                Voir toute la carte
            </a>
        </div>
    </div>
</div>

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 80vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
        background-size: cover;
        opacity: 0.3;
    }
    
    .hero-content {
        text-align: center;
        color: white;
        position: relative;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        animation: fadeInUp 0.8s ease;
    }
    
    .highlight {
        color: var(--accent);
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 30px;
        animation: fadeInUp 0.8s ease 0.2s both;
    }
    
    .hero-buttons {
        animation: fadeInUp 0.8s ease 0.4s both;
    }
    
    .hero-buttons .btn {
        margin: 0 10px;
    }
    
    .features-section,
    .menu-preview {
        padding: 80px 0;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--primary);
    }
    
    .section-header p {
        font-size: 1.1rem;
        color: var(--gray-600);
    }
    
    .feature-card {
        text-align: center;
        padding: 30px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .feature-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .feature-card h3 {
        font-size: 1.3rem;
        margin-bottom: 15px;
    }
    
    .menu-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .menu-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .menu-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .menu-item-info {
        padding: 15px;
        text-align: center;
    }
    
    .menu-item-info h4 {
        font-size: 1rem;
        margin-bottom: 5px;
    }
    
    .menu-item-info p {
        color: var(--primary);
        font-weight: 700;
        margin: 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .hero-buttons .btn {
            margin: 10px;
        }
    }
</style>
@endsection