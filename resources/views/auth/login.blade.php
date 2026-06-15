<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Connectez-vous à votre espace client Restaurant Istanbul à Lubumbashi. Gérez vos réservations et commandes.">
    <title>Connexion | Restaurant Istanbul - Lubumbashi</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated background effect */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1547573854-74d2a71d0826?w=1600');
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            z-index: 0;
        }
        
        .auth-container {
            max-width: 1300px;
            width: 100%;
            background: rgba(255,255,255,0.98);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            display: flex;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(0px);
            transition: transform 0.3s ease;
        }
        
        .auth-container:hover {
            transform: translateY(-5px);
        }
        
        /* Left Panel - Restaurant Branding */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1a2a3a 0%, #0f1a24 100%);
            padding: 50px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .auth-left::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -30%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(243,156,18,0.15) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }
        
        .auth-logo i {
            font-size: 2.5rem;
            color: #f39c12;
            filter: drop-shadow(0 0 10px rgba(243,156,18,0.3));
        }
        
        .auth-logo span {
            background: linear-gradient(135deg, #fff, #f39c12);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .auth-left h2 {
            font-size: 2.2rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
            line-height: 1.3;
        }
        
        .auth-left h2 span {
            color: #f39c12;
            display: block;
            font-size: 1.8rem;
            margin-top: 10px;
        }
        
        .auth-left p {
            opacity: 0.85;
            line-height: 1.7;
            margin-bottom: 35px;
            position: relative;
            z-index: 1;
            font-size: 1rem;
        }
        
        .features-list {
            position: relative;
            z-index: 1;
            margin-bottom: 35px;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            padding: 10px 15px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .feature-item:hover {
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .feature-item i {
            width: 30px;
            color: #f39c12;
            font-size: 1.2rem;
        }
        
        .quote {
            font-style: italic;
            padding: 25px;
            background: rgba(243,156,18,0.1);
            border-radius: 20px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(243,156,18,0.2);
        }
        
        .quote i {
            color: #f39c12;
            font-size: 2rem;
            opacity: 0.6;
        }
        
        .quote p {
            margin-bottom: 0;
            font-size: 0.95rem;
        }
        
        /* Right Panel - Login Form */
        .auth-right {
            flex: 1;
            padding: 50px 45px;
            background: white;
        }
        
        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 15px;
            border-radius: 30px;
            background: #f8f9fa;
        }
        
        .back-home:hover {
            color: #f39c12;
            background: #fff3e0;
            transform: translateX(-3px);
        }
        
        .auth-right h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #1a2a3a;
            font-weight: 700;
        }
        
        .auth-right .subtitle {
            color: #7f8c8d;
            margin-bottom: 35px;
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group i:first-child {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #bdc3c7;
            font-size: 1.1rem;
            transition: color 0.3s;
        }
        
        .input-group input {
            width: 100%;
            padding: 15px 16px 15px 48px;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #f39c12;
            background: white;
            box-shadow: 0 0 0 4px rgba(243,156,18,0.1);
        }
        
        .input-group input.error {
            border-color: #e74c3c;
        }
        
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #bdc3c7;
            transition: color 0.3s;
            z-index: 2;
        }
        
        .password-toggle:hover {
            color: #f39c12;
        }
        
        .checkbox-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 0.9rem;
            color: #555;
        }
        
        .checkbox-label input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #f39c12;
        }
        
        .forgot-link {
            color: #f39c12;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
            color: #e67e22;
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(243,156,18,0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e9ecef;
        }
        
        .auth-footer p {
            color: #7f8c8d;
            font-size: 0.95rem;
        }
        
        .auth-footer a {
            color: #f39c12;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s;
        }
        
        .auth-footer a:hover {
            text-decoration: underline;
            color: #e67e22;
        }
        
        .error-message {
            background: linear-gradient(135deg, #fee, #fdd);
            color: #c0392b;
            padding: 14px 18px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #e74c3c;
            font-size: 0.9rem;
        }
        
        .success-message {
            background: linear-gradient(135deg, #efe, #dfd);
            color: #27ae60;
            padding: 14px 18px;
            border-radius: 16px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #27ae60;
            font-size: 0.9rem;
        }
        
        .social-login {
            margin-top: 30px;
            text-align: center;
        }
        
        .social-login p {
            color: #7f8c8d;
            margin-bottom: 20px;
            position: relative;
            font-size: 0.85rem;
        }
        
        .social-login p::before,
        .social-login p::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e9ecef, transparent);
        }
        
        .social-login p::before {
            left: 0;
        }
        
        .social-login p::after {
            right: 0;
        }
        
        .social-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            border: 2px solid #e9ecef;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .social-btn:hover {
            border-color: #f39c12;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .social-btn i {
            font-size: 1.3rem;
        }
        
        .social-btn.google i {
            color: #db4437;
        }
        
        .social-btn.facebook i {
            color: #4267b2;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .auth-left {
                padding: 40px 30px;
            }
            
            .auth-right {
                padding: 40px 30px;
            }
            
            .auth-left h2 {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }
            
            .auth-right {
                padding: 35px 25px;
            }
            
            .auth-right h3 {
                font-size: 1.6rem;
            }
        }
        
        @media (max-width: 480px) {
            .auth-right {
                padding: 25px 20px;
            }
            
            .checkbox-group {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .social-buttons {
                gap: 10px;
            }
        }
        
        /* Loading animation */
        .btn-login.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .btn-login.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Left Panel - Restaurant Branding -->
        <div class="auth-left">
            <div class="auth-logo">
                <i class="fas fa-utensils"></i>
                <span>Restaurant Istanbul</span>
            </div>
            <h2>Bienvenue à <span>Lubumbashi</span></h2>
            <p>Le meilleur de la cuisine congolaise et internationale vous attend. Connectez-vous pour découvrir une expérience culinaire unique.</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Réservation en ligne 24h/24</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Gestion de vos commandes</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Programme de fidélité exclusif</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Offres et événements privés</span>
                </div>
            </div>
            
            <div class="quote">
                <i class="fas fa-quote-left"></i>
                <p style="margin-top: 12px;">"La cuisine est un art, et chaque plat est une œuvre d'art que nous créons avec passion pour vous."</p>
                <p style="margin-top: 12px; font-size: 0.85rem; opacity: 0.8;">- Chef du Restaurant Istamboul</p>
            </div>
        </div>
        
        <!-- Right Panel - Login Form -->
        <div class="auth-right">
            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left"></i> 
                <span>Retour à l'accueil</span>
            </a>
            
            <h3>Connexion</h3>
            <p class="subtitle">Accédez à votre espace client Restaurant Istamboul</p>
            
            @if(session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf
                
                <div class="form-group">
                    <label>Adresse email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@email.com" required autofocus>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                    </div>
                </div>
                
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">
                        <i class="fas fa-question-circle"></i> Mot de passe oublié ?
                    </a>
                </div>
                
                <button type="submit" class="btn-login" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> 
                    <span>Se connecter</span>
                </button>
            </form>
            
            
            
            <div class="auth-footer">
                <p>Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte gratuitement</a></p>
                <p style="margin-top: 10px; font-size: 0.8rem;">
                    <i class="fas fa-map-marker-alt"></i> Avenue Mahenge, Lubumbashi | 
                    <i class="fas fa-phone"></i> +243 81 234 5678
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordField.getAttribute('type') === 'password') {
                passwordField.setAttribute('type', 'text');
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.setAttribute('type', 'password');
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Social login placeholder
        function socialLogin(provider) {
            alert('Connexion via ' + provider.toUpperCase() + ' - Fonctionnalité à venir prochainement !');
        }
        
        // Form submission loading state
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner"></i> <span>Connexion en cours...</span>';
        });
        
        // Input focus effects
        document.querySelectorAll('.input-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('i:first-child')?.style.setProperty('color', '#f39c12');
            });
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('i:first-child')?.style.setProperty('color', '#bdc3c7');
            });
        });
        
        // Animate on load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.auth-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            setTimeout(() => {
                container.style.transition = 'all 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>