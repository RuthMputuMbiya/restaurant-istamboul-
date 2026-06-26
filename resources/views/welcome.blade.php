<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Restaurant Istanbul à Lubumbashi - La référence de la gastronomie à Lubumbashi. Cuisine raffinée, ambiance chaleureuse sur l'Avenue Mahenge. Réservez votre table en ligne.">
    <meta name="keywords" content="Restaurant Lubumbashi, Restaurant Istanbul, Avenue Mahenge, gastronomie Lubumbashi, réservation restaurant RDC">
    <meta name="geo.placename" content="Lubumbashi, RDC">
    <meta name="geo.position" content="-11.664444;27.482778">
    <meta name="ICBM" content="-11.664444, 27.482778">
    <title>Restaurant Istanbul | Gastronomie d'Exception à Lubumbashi</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: #0a0a0a;
            color: #333;
        }
        
        a {
            text-decoration: none;
        }
        
        img {
            max-width: 100%;
            display: block;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 5%;
        }
        
        /* ===== NAVIGATION ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.2rem 5%;
            transition: all 0.4s ease;
            background: transparent;
        }
        
        .navbar.scrolled {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.8rem 5%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
        }
        
        .logo i {
            font-size: 1.8rem;
            color: #f39c12;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            font-weight: 500;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        
        .nav-links a:hover {
            color: #f39c12;
        }
        
        .btn-nav {
            background: #f39c12;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }
        
        .btn-nav:hover {
            background: #e67e22;
            transform: translateY(-2px);
            color: white;
        }
        
        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }
        
        /* ===== HERO ===== */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.45) 100%), 
                        url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTyZiYAzyVBPQCPiWdYdG-L6j3klllbwTuCzb_tdrIGiA&s');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 5%;
            color: white;
        }
        
        .hero-badge {
            display: inline-block;
            background: rgba(243, 156, 18, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(243, 156, 18, 0.4);
            letter-spacing: 0.5px;
        }
        
        .hero-badge i {
            color: #f39c12;
            margin-right: 6px;
        }
        
        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.15;
        }
        
        .hero h1 span {
            color: #f39c12;
        }
        
        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            line-height: 1.7;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        /* ===== BUTTONS ===== */
        .btn-primary {
            background: #f39c12;
            color: white;
            padding: 1rem 2.2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: #e67e22;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(243, 156, 18, 0.35);
            color: white;
        }
        
        .btn-outline {
            border: 2px solid white;
            background: transparent;
            color: white;
            padding: 1rem 2.2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-outline:hover {
            background: white;
            color: #1a2a3a;
            transform: translateY(-3px);
        }
        
        /* ===== SECTIONS ===== */
        .section {
            padding: 80px 5%;
        }
        
        .section-light {
            background: #ffffff;
        }
        
        .section-dark {
            background: #f8f9fa;
        }
        
        .section-header {
            text-align: center;
            max-width: 750px;
            margin: 0 auto 50px;
        }
        
        .section-header h2 {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 0.8rem;
            color: #1a2a3a;
        }
        
        .section-header h2 span {
            color: #f39c12;
        }
        
        .section-header p {
            color: #777;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        /* ===== MENU / DISH CARDS ===== */
        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .dish-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            cursor: pointer;
        }
        
        .dish-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 45px rgba(0,0,0,0.15);
        }
        
        .dish-image {
            position: relative;
            height: 240px;
            overflow: hidden;
        }
        
        .dish-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .dish-card:hover .dish-image img {
            transform: scale(1.08);
        }
        
        .dish-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: 0.3s;
        }
        
        .dish-card:hover .dish-overlay {
            opacity: 1;
        }
        
        .dish-overlay span {
            background: #f39c12;
            color: white;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .dish-overlay span i {
            margin-right: 6px;
        }
        
        .dish-info {
            padding: 22px 20px;
        }
        
        .dish-info h3 {
            font-size: 1.25rem;
            margin-bottom: 8px;
            color: #1a2a3a;
        }
        
        .dish-info p {
            color: #777;
            margin-bottom: 12px;
            line-height: 1.5;
            font-size: 0.95rem;
        }
        
        .dish-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #f39c12;
        }
        
        .rating {
            color: #f39c12;
            font-size: 0.9rem;
        }
        
        .rating i {
            margin-right: 2px;
        }
        
        /* ===== FEATURES ===== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .feature-card {
            text-align: center;
            padding: 35px 25px;
            background: white;
            border-radius: 20px;
            transition: 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 75px;
            height: 75px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }
        
        .feature-icon i {
            font-size: 1.8rem;
            color: white;
        }
        
        .feature-card h3 {
            font-size: 1.2rem;
            margin-bottom: 8px;
            color: #1a2a3a;
        }
        
        .feature-card p {
            color: #777;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        /* ===== ABOUT ===== */
        .about-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }
        
        .about-text h3 {
            font-size: 1.8rem;
            margin-bottom: 18px;
            color: #1a2a3a;
        }
        
        .about-text p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 18px;
        }
        
        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 25px;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #f39c12;
        }
        
        .stat-label {
            color: #777;
            font-size: 0.9rem;
            margin-top: 4px;
        }
        
        .about-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            min-height: 350px;
        }
        
        /* ===== GALLERY ===== */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .gallery-item {
            position: relative;
            height: 250px;
            border-radius: 15px;
            overflow: hidden;
            cursor: pointer;
        }
        
        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            padding: 20px;
            color: white;
            transform: translateY(100%);
            transition: 0.3s;
        }
        
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-overlay h4 {
            font-size: 1rem;
            font-weight: 600;
        }
        
        /* ===== MAP ===== */
        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }
        
        .map-actions {
            text-align: center;
            margin-top: 20px;
        }
        
        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, #1a2a3a, #0f1a24);
            padding: 80px 5%;
            text-align: center;
            color: white;
        }
        
        .cta-section h2 {
            font-size: 2.6rem;
            margin-bottom: 1rem;
        }
        
        .cta-section p {
            margin-bottom: 2rem;
            opacity: 0.85;
            font-size: 1.1rem;
        }
        
        .cta-section .btn-primary {
            background: white;
            color: #1a2a3a;
        }
        
        .cta-section .btn-primary:hover {
            background: #f39c12;
            color: white;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: #0a0a0a;
            color: white;
            padding: 60px 5% 30px;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col h3 {
            font-size: 1.1rem;
            margin-bottom: 18px;
            color: #f39c12;
        }
        
        .footer-col h3 i {
            margin-right: 8px;
        }
        
        .footer-col p {
            opacity: 0.7;
            line-height: 1.7;
            font-size: 0.95rem;
        }
        
        .footer-col p i {
            width: 20px;
            color: #f39c12;
        }
        
        .footer-col strong {
            color: rgba(255,255,255,0.9);
        }
        
        .social-links {
            display: flex;
            gap: 12px;
            margin-top: 18px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: 0.3s;
        }
        
        .social-links a:hover {
            background: #f39c12;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.08);
            opacity: 0.6;
            font-size: 0.9rem;
        }
        
        .footer-bottom i {
            color: #f39c12;
        }
        
        /* ===== NEWSLETTER FORM ===== */
        .newsletter-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }
        
        .newsletter-form input {
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.08);
            color: white;
            outline: none;
            transition: 0.3s;
        }
        
        .newsletter-form input:focus {
            border-color: #f39c12;
            background: rgba(255,255,255,0.12);
        }
        
        .newsletter-form input::placeholder {
            color: rgba(255,255,255,0.5);
        }
        
        .newsletter-form button {
            background: #f39c12;
            border: none;
            padding: 12px;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        
        .newsletter-form button:hover {
            background: #e67e22;
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .about-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 75%;
                height: 100vh;
                background: rgba(0,0,0,0.97);
                backdrop-filter: blur(10px);
                flex-direction: column;
                justify-content: center;
                padding: 2rem;
                transition: 0.4s ease;
                z-index: 1001;
                gap: 1.5rem;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .hero h1 {
                font-size: 2.4rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .section-header h2 {
                font-size: 2rem;
            }
            
            .section {
                padding: 60px 5%;
            }
            
            .about-stats {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
        
        @media (max-width: 480px) {
            .hero h1 {
                font-size: 1.8rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .hero-buttons .btn-primary,
            .hero-buttons .btn-outline {
                width: 100%;
                justify-content: center;
            }
            
            .section-header h2 {
                font-size: 1.6rem;
            }
            
            .featured-grid {
                grid-template-columns: 1fr;
            }
            
            .gallery-grid {
                grid-template-columns: 1fr 1fr;
            }
            
            .gallery-item {
                height: 180px;
            }
        }
        
        /* ===== ANIMATIONS ===== */
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
        
        .animate {
            animation: fadeInUp 0.8s ease forwards;
        }
    </style>
</head>
<body>
    <!-- ===== NAVIGATION ===== -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-utensils"></i>
                <span>Restaurant Istanbul</span>
            </a>
            <div class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </div>
            <div class="nav-links" id="navLinks">
                <a href="#home">Accueil</a>
                <a href="#menu">Menu</a>
                <a href="#about">À propos</a>
                <a href="#gallery">Galerie</a>
                <a href="#contact">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-nav">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Connexion</a>
                    <a href="{{ route('register') }}">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- ===== HERO ===== -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i> Lubumbashi's Finest Restaurant
            </div>
            <h1>Bienvenue au <span>Restaurant Istanbul</span></h1>
            <p>Une expérience culinaire exceptionnelle au cœur de Lubumbashi. Découvrez une cuisine raffinée dans un cadre chaleureux sur l'Avenue Mahenge.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn-primary">
                    <i class="fas fa-calendar-alt"></i> Réserver une table
                </a>
                <a href="#menu" class="btn-outline">
                    <i class="fas fa-arrow-down"></i> Découvrir notre carte
                </a>
            </div>
        </div>
    </section>

    <!-- ===== MENU ===== -->
    <section class="section section-light" id="menu">
        <div class="section-header">
            <h2>Nos <span>spécialités</span></h2>
            <p>Découvrez les saveurs authentiques de la cuisine Turque et méditerranéenne</p>
        </div>
        <div class="featured-grid">
            <!-- Plat 1 -->
            <div class="dish-card">
                <div class="dish-image">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTB2KrIAWQBVIf5y9D3H8G-RFWFDOvP456rseahUkvBlRQ5-pZZ2CKNdYvC&s=10" alt="Poisson et fruits">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Poisson aux Fruits</h3>
                    <p>Poisson frais accompagné d'une sélection de fruits exotiques et légumes de saison</p>
                    <div class="dish-price">
                        <span class="price">15 000 FC</span>
                        <span class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>
            
            <!-- Plat 2 -->
            <div class="dish-card">
                <div class="dish-image">
                    <img src="https://images.unsplash.com/photo-1506354666786-959d6d497f1a?w=500" alt="Pizza">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Pizza </h3>
                    <p>Pizza delicieux </p>
                    <div class="dish-price">
                        <span class="price">18 500 FC</span>
                        <span class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 4.8</span>
                    </div>
                </div>
            </div>
            
            <!-- Plat 3 -->
            <div class="dish-card">
                <div class="dish-image">
                    <img src="https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500" alt="Samusa">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Samusa</h3>
                    <p>Beignets triangulaires croustillants farcis à la viande hachée, épices et oignons</p>
                    <div class="dish-price">
                        <span class="price">5 000 FC</span>
                        <span class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>
    
            
            <!-- Plat 5 -->
            <div class="dish-card">
                <div class="dish-image">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500" alt="Oméburger">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Oméburger Signature</h3>
                    <p>Steak haché 200g, cheddar fondant, salade, tomates, oignons caramélisés, sauce maison</p>
                    <div class="dish-price">
                        <span class="price">24 500 FC</span>
                        <span class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>
            
    </section>

    <!-- ===== ABOUT ===== -->
    <section class="section section-dark" id="about">
        <div class="section-header">
            <h2>À <span>propos</span> de nous</h2>
            <p>Découvrez l'histoire du Restaurant Istanbul à Lubumbashi</p>
        </div>
        <div class="about-content">
            <div class="about-text">
                <h3>Restaurant Istanbul</h3>
                <p>Fondé en 2018, le Restaurant Istanbul est rapidement devenu une référence incontournable de la gastronomie à Lubumbashi. Situé sur l'emblématique Avenue Mahenge, notre établissement allie tradition culinaire turque et hospitalité légendaire.</p>
                <p>Notre chef passionné sélectionne chaque jour les meilleurs ingrédients frais auprès des producteurs locaux pour vous offrir une expérience gustative authentique.</p>
                <p>Que ce soit pour un dîner romantique, un repas d'affaires ou une célébration familiale, notre équipe dévouée met tout en œuvre pour rendre votre visite inoubliable.</p>
                <div class="about-stats">
                    <div class="stat">
                        <div class="stat-number">8+</div>
                        <div class="stat-label">Années d'excellence</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Chefs passionnés</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">300+</div>
                        <div class="stat-label">Clients satisfaits</div>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ95TVkf3VEifOk_9AWNtKdL5W2oQPNkov0QDgf5G5tMQ&s=10" alt="Intérieur Restaurant Istanbul Lubumbashi">
            </div>
        </div>
    </section>

    <!-- ===== FEATURES ===== -->
    <section class="section section-light">
        <div class="section-header">
            <h2>Pourquoi <span>nous choisir ?</span></h2>
            <p>Ce qui fait du Restaurant Istanbul une adresse unique à Lubumbashi</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Cuisine Authentique</h3>
                <p>Des recettes traditionnelles préparées avec des produits frais et locaux</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Emplacement Premium</h3>
                <p>Situé sur l'Avenue Mahenge, au cœur de Lubumbashi, facilement accessible</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-moon"></i>
                </div>
                <h3>Ambiance Élégante</h3>
                <p>Un cadre raffiné et chaleureux pour vos repas d'affaires et moments en famille</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-concierge-bell"></i>
                </div>
                <h3>Service Exceptionnel</h3>
                <p>Une équipe professionnelle et attentionnée à votre service</p>
            </div>
        </div>
    </section>

    <!-- ===== GALLERY ===== -->
    <section class="section section-dark" id="gallery">
        <div class="section-header">
            <h2>Notre <span>galerie</span></h2>
            <p>Découvrez l'ambiance unique de notre établissement sur l'Avenue Mahenge</p>
        </div>
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSxNijN9FgWhIezNbmpo9pOL9bS5BkLWcWH2f0bG-yiRw&s=10" alt="Salle principale">
                <div class="gallery-overlay">
                    <h4>Salle principale</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ95TVkf3VEifOk_9AWNtKdL5W2oQPNkov0QDgf5G5tMQ&s=10" alt="Nos plats">
                <div class="gallery-overlay">
                    <h4>Nos spécialités</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNhLJN5XX9_2lYuScQ6-aWMx7BMErIesS2pTudlwX0GA&s" alt="Cuisine ouverte">
                <div class="gallery-overlay">
                    <h4>Cuisine ouverte</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQ6_NUwSPrrK3TRmkFiNLfO8xeCZKz3gN62LhqnDfb4Q&s=10" alt="Bar à cocktails">
                <div class="gallery-overlay">
                    <h4>Bar à cocktails</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSahnBO7EaLUCQrw-EhiAkDr2O71i8hPctrLob1RaObGA&s=10 " alt="Ambiance">
                <div class="gallery-overlay">
                    <h4>Ambiance chaleureuse</h4>
                </div>
            </div>
            
        </div>
    </section>

    <!-- ===== MAP ===== -->
   <!-- Plan d'accès Google Maps - VERSION CORRIGÉE -->
<!-- ===== PLAN D'ACCÈS GOOGLE MAPS - VERSION CORRIGÉE ===== -->
<section class="section section-dark">
    <div class="section-header">
        <h2>Nous <span>trouver</span></h2>
        <p>Restaurant Istanbul - Avenue Mahenge, Lubumbashi</p>
    </div>
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.515185584141!2d27.482778!3d-11.664444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x197c0da744edea9f%3A0x3f6f8a07c89dd87c!2sAvenue%20Mahenge%2C%20Lubumbashi%2C%20R%C3%A9publique%20d%C3%A9mocratique%20du%20Congo!5e0!3m2!1sfr!2sfr!4v1700000000000!5m2!1sfr!2sfr" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            style="width:100%; height:400px; border:0; border-radius:20px;">
        </iframe>
    </div>
    <div class="map-actions" style="text-align: center; margin-top: 20px;">
        <a href="https://www.google.com/maps/dir//Avenue+Mahenge,+Lubumbashi,+R%C3%A9publique+d%C3%A9mocratique+du+Congo/@-11.664444,27.482778,17z" 
           target="_blank" 
           class="btn-primary" 
           style="display: inline-flex; align-items: center; gap: 10px;">
            <i class="fas fa-directions"></i> Ouvrir dans Google Maps
        </a>
    </div>
</section>

    <!-- ===== CTA ===== -->
    <section class="cta-section">
        <h2>Prêt à vivre une expérience unique ?</h2>
        <p>Réservez votre table maintenant et découvrez le meilleur de la cuisine turque</p>
        <a href="{{ route('register') }}" class="btn-primary">
            <i class="fas fa-calendar-check"></i> Réserver maintenant
        </a>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-col">
                <h3><i class="fas fa-utensils"></i> Restaurant Istanbul</h3>
                <p>La référence de la gastronomie à Lubumbashi. Une cuisine authentique et un service d'exception sur l'Avenue Mahenge.</p>
                <div class="social-links">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3><i class="far fa-clock"></i> Horaires</h3>
                <p><strong>Lundi - Jeudi:</strong><br>11:00 - 15:00 | 18:00 - 22:30</p>
                <p><strong>Vendredi - Samedi:</strong><br>11:00 - 15:00 | 18:00 - 23:00</p>
                <p><strong>Dimanche:</strong><br>12:00 - 16:00 | 18:00 - 22:00</p>
                <p style="font-size:0.8rem; opacity:0.5; margin-top:6px;"><em>Dernière commande 30min avant fermeture</em></p>
            </div>
            <div class="footer-col">
                <h3><i class="fas fa-map-marker-alt"></i> Contact</h3>
                <p><i class="fas fa-map-marker-alt"></i> Avenue Mahenge/Industrielle<br>Lubumbashi, Haut-Katanga</p>
                <p><i class="fas fa-phone"></i> +243 812533444<br>+243 901111112</p>
               
            </div>
            <div class="footer-col">
                <h3><i class="fas fa-envelope"></i> Newsletter</h3>
                <p>Recevez nos offres spéciales et événements</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Votre adresse email">
                    <button type="submit"><i class="fas fa-paper-plane"></i> S'abonner</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Restaurant Istanbul - Lubumbashi | Tous droits réservés | Créé avec <i class="fas fa-heart"></i> pour nos clients</p>
        </div>
    </footer>

    <!-- ===== SCRIPTS ===== -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.getElementById('navLinks');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');
                this.querySelector('i').classList.toggle('fa-bars');
                this.querySelector('i').classList.toggle('fa-times');
            });
        }
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                const icon = mobileMenuBtn.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>