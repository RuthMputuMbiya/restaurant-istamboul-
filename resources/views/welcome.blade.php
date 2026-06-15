<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Restaurant Istamboul à Lubumbashi - La référence de la gastronomie à Lubumbashi. Cuisine raffinée, ambiance chaleureuse sur l'Avenue Mahenge. Réservez votre table en ligne.">
    <meta name="keywords" content="Restaurant Lubumbashi, Restaurant Istamboul, Avenue Mahenge, gastronomie Lubumbashi, réservation restaurant RDC">
    <meta name="geo.placename" content="Lubumbashi, RDC">
    <meta name="geo.position" content="-11.664444;27.482778">
    <meta name="ICBM" content="-11.664444, 27.482778">
    <title>Restaurant Istanbul| Gastronomie d'Exception à Lubumbashi</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            background: #0a0a0a;
        }
        
        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.5rem 5%;
            transition: all 0.4s ease;
            background: transparent;
        }
        
        .navbar.scrolled {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 5%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            text-decoration: none;
        }
        
        .logo i {
            font-size: 2rem;
            color: #f39c12;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .nav-links a:hover {
            color: #f39c12;
        }
        
        .btn-nav {
            background: #f39c12;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        
        .btn-nav:hover {
            background: #e67e22;
            transform: translateY(-2px);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 100%), url('https://images.unsplash.com/photo-1547573854-74d2a71d0826?w=1600');
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
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(243, 156, 18, 0.5);
        }
        
        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero h1 span {
            color: #f39c12;
        }
        
        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-primary {
            background: #f39c12;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-primary:hover {
            background: #e67e22;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(243, 156, 18, 0.3);
        }
        
        .btn-outline {
            border: 2px solid white;
            background: transparent;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        
        .btn-outline:hover {
            background: white;
            color: black;
            transform: translateY(-3px);
        }
        
        /* Sections */
        .section {
            padding: 80px 5%;
            background: #fff;
        }
        
        .section-dark {
            background: #f8f9fa;
        }
        
        .section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 50px;
        }
        
        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: #1a2a3a;
        }
        
        .section-header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .section-header span {
            color: #f39c12;
        }
        
        /* Plats grid */
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
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            cursor: pointer;
        }
        
        .dish-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        
        .dish-image {
            position: relative;
            height: 250px;
            overflow: hidden;
        }
        
        .dish-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .dish-card:hover .dish-image img {
            transform: scale(1.1);
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
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
        }
        
        .dish-info {
            padding: 20px;
        }
        
        .dish-info h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        
        .dish-info p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .dish-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #f39c12;
        }
        
        .rating {
            color: #f39c12;
        }
        
        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 20px;
            transition: 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
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
            margin-bottom: 10px;
        }
        
        /* About section */
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
            margin-bottom: 20px;
            color: #1a2a3a;
        }
        
        .about-text p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #f39c12;
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
        }
        
        /* Gallery */
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
        
        /* Testimonials */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .testimonial-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .author-info h4 {
            margin-bottom: 5px;
        }
        
        .author-info p {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Map */
        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .map-container iframe {
            width: 100%;
            height: 400px;
            border: 0;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #1a2a3a, #0f1a24);
            padding: 80px 5%;
            text-align: center;
            color: white;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .cta-section p {
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Footer */
        .footer {
            background: #0a0a0a;
            color: white;
            padding: 60px 5% 30px;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-col h3 {
            margin-bottom: 20px;
        }
        
        .footer-col p {
            opacity: 0.7;
            line-height: 1.6;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .social-links a:hover {
            background: #f39c12;
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            opacity: 0.7;
        }
        
        /* Mobile menu */
        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                height: 100vh;
                background: rgba(0,0,0,0.95);
                backdrop-filter: blur(10px);
                flex-direction: column;
                justify-content: center;
                transition: 0.3s;
                z-index: 1001;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .section-header h2 {
                font-size: 1.8rem;
            }
            
            .about-content {
                grid-template-columns: 1fr;
            }
        }
        
        /* Animations */
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
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="logo">
                <i class="fas fa-utensils"></i>
                <span>Restaurant Istanboul</span>
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star"></i> Lubumbashi's Finest Restaurant
            </div>
            <h1>Bienvenue au <span>Restaurant Istanboul</span></h1>
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

    <!-- Plats signatures - Spécialités Congolaises -->
    <section class="section" id="menu">
        <div class="section-header">
            <h2>Nos <span>spécialités</span></h2>
            <p>Découvrez les saveurs authentiques de la cuisine congolaise</p>
        </div>
        <div class="featured-grid">
            <div class="dish-card">
                <div class="dish-image">
                      <img src="https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=500" alt="Poulet Moambe">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Poulet à la Moambe</h3>
                    <p>Poulet mijoté dans une sauce aux noix de palme, servis avec fufu ou riz</p>
                    <div class="dish-price">
                        <span class="price">15 000 FC</span>
                        <span class="rating"><i class="fas fa-star"></i> 4.9</span>
                    </div>
                </div>
            </div>
            
            <div class="dish-card">
                <div class="dish-image">
                    <<img src="https://images.unsplash.com/photo-1506354666786-959d6d497f1a?w=500" alt="Pizza">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Pizza</h3>
                    <p>Brochette d'agneau épicée grillée au charbon, accompagnée de riz pilaf et légumes grillés</p>
                    <div class="dish-price">
                        <span class="price">18 500 FC</span>
                        <span class="rating"><i class="fas fa-star"></i> 4.8</span>
                    </div>
                </div>
            </div>
            
            <div class="dish-card">
                <div class="dish-image">
                    <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?w=500" alt="Liboké de Poisson">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Liboké de Poisson</h3>
                    <p>Poisson frais mariné aux épices, cuit à l'étouffée dans des feuilles de bananier</p>
                    <div class="dish-price">
                        <span class="price">18 000 FC</span>
                        <span class="rating"><i class="fas fa-star"></i> 5.0</span>
                    </div>
                </div>
            </div>
            
            <div class="dish-card">
                <div class="dish-image">
                    <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?w=500" alt="Pilipili">
                    <div class="dish-overlay">
                        <span><i class="fas fa-eye"></i> Voir détails</span>
                    </div>
                </div>
                <div class="dish-info">
                    <h3>Boeuf Pilipili</h3>
                    <p>Dés de boeuf tendres sauté aux piments frais, oignons et poivrons - Un délice épicé</p>
                    <div class="dish-price">
                        <span class="price">16 000 FC</span>
                        <span class="rating"><i class="fas fa-star"></i> 4.7</span>
                    </div>
                </div>
            </div>
            <!-- Samusa (Samosas) -->
    <div class="dish-card">
        <div class="dish-image">
            <img src="https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500" alt="Samusa">
            <div class="dish-overlay">
                <span><i class="fas fa-eye"></i> Voir détails</span>
            </div>
        </div>
        <div class="dish-info">
            <h3>Samusa</h3>
            <p>Beignets triangulaires croustillants farcis à la viande hachée ou au poulet, épices et oignons</p>
            <div class="dish-price">
                <span class="price">5 000 FC</span>
                <span class="rating"><i class="fas fa-star"></i> 4.9</span>
            </div>
        </div>
    </div>
    <!-- Brochettes Mixte -->
    <div class="dish-card">
        <div class="dish-image">
            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500" alt="Brochettes">
            <div class="dish-overlay">
                <span><i class="fas fa-eye"></i> Voir détails</span>
            </div>
        </div>
        <div class="dish-info">
            <h3>Brochettes Mixte</h3>
            <p>Assortiment de brochettes de boeuf, poulet et agneau marinées, grillées au feu de bois</p>
            <div class="dish-price">
                <span class="price">12 000 FC</span>
                <span class="rating"><i class="fas fa-star"></i> 4.7</span>
            </div>
        </div>
    </div>
    <!-- Oméburger Signature -->
<div class="dish-card">
    <div class="dish-image">
        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=500" alt="Oméburger Signature">
        <div class="dish-overlay">
            <span><i class="fas fa-eye"></i> Voir détails</span>
        </div>
    </div>
    <div class="dish-info">
        <h3>Oméburger Signature</h3>
        <p>Steak haché 200g, cheddar fondant, salade fraîche, tomates, oignons caramélisés, sauce spéciale maison, servi avec frites maison</p>
        <div class="dish-price">
            <span class="price">11$ /24500FC</span>
            <span class="rating"><i class="fas fa-star"></i> 4.9</span>
        </div>
    </div>
</div>
        </div>
    </section>

    <!-- À propos section -->
    <section class="section-dark" id="about">
        <div class="section-header">
            <h2>À <span>propos</span> de nous</h2>
            <p>Découvrez l'histoire du Restaurant Istamboul à Lubumbashi</p>
        </div>
        <div class="about-content">
            <div class="about-text">
                <h3>Restaurant Istamboul</h3>
                <p>Fondé en 2018, le Restaurant Istamboul est rapidement devenu une référence incontournable de la gastronomie à Lubumbashi. Situé sur l'emblématique Avenue Mahenge, notre établissement allie tradition culinaire congolaise et hospitalité légendaire.</p>
                <p>Notre chef passionné sélectionne chaque jour les meilleurs ingrédients frais auprès des producteurs locaux pour vous offrir une expérience gustative authentique. Chaque plat est préparé avec amour et respect des traditions culinaires de la RDC.</p>
                <p>Que ce soit pour un dîner romantique, un repas d'affaires ou une célébration familiale, notre équipe dévouée met tout en œuvre pour rendre votre visite inoubliable.</p>
                <div class="about-stats">
                    <div class="stat">
                        <div class="stat-number">6+</div>
                        <div>Années d'excellence</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">12+</div>
                        <div>Chefs passionnés</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">8000+</div>
                        <div>Clients satisfaits</div>
                    </div>
                </div>
            </div>
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600" alt="Intérieur Restaurant Istamboul Lubumbashi">
            </div>
        </div>
    </section>

    <!-- Pourquoi nous choisir -->
    <section class="section">
        <div class="section-header">
            <h2>Pourquoi <span>nous choisir ?</span></h2>
            <p>Ce qui fait du Restaurant Istamboul une adresse unique à Lubumbashi</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <h3>Cuisine Authentique</h3>
                <p>Des recettes traditionnelles congolaises préparées avec des produits frais et locaux</p>
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

    <!-- Galerie -->
    <section class="section-dark" id="gallery">
        <div class="section-header">
            <h2>Notre <span>galerie</span></h2>
            <p>Découvrez l'ambiance unique de notre établissement sur l'Avenue Mahenge</p>
        </div>
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=500" alt="Salle principale Restaurant Istamboul">
                <div class="gallery-overlay">
                    <h4>Salle principale</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?w=500" alt="Nos plats signatures">
                <div class="gallery-overlay">
                    <h4>Nos spécialités</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=500" alt="Notre cuisine">
                <div class="gallery-overlay">
                    <h4>Cuisine ouverte</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=500" alt="Bar et cocktails">
                <div class="gallery-overlay">
                    <h4>Bar à cocktails</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Témoignages -->
    <section class="section">
        <div class="section-header">
            <h2>Ce que disent <span>nos clients</span></h2>
            <p>Ils ont vécu l'expérience Restaurant Istamboul</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <i class="fas fa-quote-left" style="color: #f39c12; font-size: 2rem; opacity: 0.3;"></i>
                    <p>Le meilleur restaurant de Lubumbashi ! Le Poulet Moambe est exceptionnel, et le cadre est magnifique. Je recommande vivement.</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Client" class="author-avatar">
                    <div class="author-info">
                        <h4>Michel K.</h4>
                        <p>Client fidèle</p>
                        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <i class="fas fa-quote-left" style="color: #f39c12; font-size: 2rem; opacity: 0.3;"></i>
                    <p>Une adresse incontournable sur l'Avenue Mahenge. Service impeccable, plats délicieux et ambiance chaleureuse.</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Client" class="author-avatar">
                    <div class="author-info">
                        <h4>Grace M.</h4>
                        <p>Gastronome</p>
                        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-text">
                    <i class="fas fa-quote-left" style="color: #f39c12; font-size: 2rem; opacity: 0.3;"></i>
                    <p>Le Liboké de poisson est à tomber ! Un vrai voyage culinaire au cœur du Congo. Je reviens chaque semaine.</p>
                </div>
                <div class="testimonial-author">
                    <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Client" class="author-avatar">
                    <div class="author-info">
                        <h4>Christian L.</h4>
                        <p>Foodie</p>
                        <div class="rating"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Plan d'accès Google Maps -->
    <section class="section-dark">
        <div class="section-header">
            <h2>Nous <span>trouver</span></h2>
            <p>Restaurant Istamboul - Avenue Mahenge, Lubumbashi</p>
        </div>
        <div class="map-container" style="max-width: 1400px; margin: 0 auto;">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.123456789012!2d27.482778!3d-11.664444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x197c0e8c8c8c8c8d%3A0x123456789abcdef!2sAvenue%20Mahenge%2C%20Lubumbashi%2C%20R%C3%A9publique%20d%C3%A9mocratique%20du%20Congo!5e0!3m2!1sfr!2sfr!4v1700000000000!5m2!1sfr!2sfr" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="https://maps.google.com/?q=Avenue+Mahenge+Lubumbashi" target="_blank" class="btn-primary" style="display: inline-flex; align-items: center; gap: 10px;">
                <i class="fas fa-directions"></i> Ouvrir dans Google Maps
            </a>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Prêt à vivre une expérience unique ?</h2>
        <p>Réservez votre table maintenant et découvrez le meilleur de la cuisine congolaise</p>
        <a href="{{ route('register') }}" class="btn-primary" style="background: white; color: #1a2a3a;">
            <i class="fas fa-calendar-check"></i> Réserver maintenant
        </a>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-content">
            <div class="footer-col">
                <h3><i class="fas fa-utensils"></i> Restaurant Istamboul</h3>
                <p>La référence de la gastronomie à Lubumbashi. Une cuisine authentique et un service d'exception sur l'Avenue Mahenge.</p>
                <div class="social-links">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Horaires d'ouverture</h3>
                <p><strong>Lundi - Jeudi:</strong><br>11:00 - 15:00 | 18:00 - 22:30</p>
                <p><strong>Vendredi - Samedi:</strong><br>11:00 - 15:00 | 18:00 - 23:00</p>
                <p><strong>Dimanche:</strong><br>12:00 - 16:00 | 18:00 - 22:00</p>
                <p><em>Dernière commande 30min avant fermeture</em></p>
            </div>
            <div class="footer-col">
                <h3>Contact & Adresse</h3>
                <p><i class="fas fa-map-marker-alt"></i> <strong>Adresse:</strong><br>Avenue Mahenge<br>Lubumbashi, République Démocratique du Congo</p>
                <p><i class="fas fa-phone"></i> <strong>Téléphone:</strong><br>+243 81 234 5678<br>+243 82 987 6543</p>
                <p><i class="fas fa-envelope"></i> <strong>Email:</strong><br>contact@istamboul-resto.com<br>reservation@istamboul-resto.com</p>
            </div>
            <div class="footer-col">
                <h3>Newsletter</h3>
                <p>Recevez nos offres spéciales et événements</p>
                <form style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
                    <input type="email" placeholder="Votre adresse email" style="padding: 12px; border-radius: 8px; border: none; background: rgba(255,255,255,0.1); color: white; outline: none;">
                    <button type="submit" style="background: #f39c12; border: none; padding: 12px; border-radius: 8px; color: white; cursor: pointer; font-weight: 600; transition: 0.3s;">
                        <i class="fas fa-paper-plane"></i> S'abonner
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Restaurant Istamboul - Lubumbashi | Tous droits réservés | Créé avec <i class="fas fa-heart" style="color: #f39c12;"></i> pour nos clients</p>
        </div>
    </footer>

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
        
        // Mobile menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.getElementById('navLinks');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                navLinks.classList.toggle('active');
            });
        }
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>