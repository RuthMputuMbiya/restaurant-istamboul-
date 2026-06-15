<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Créez votre compte Restaurant Istanbul à Lubumbashi. Réservez en ligne, gérez vos commandes et profitez d'offres exclusives.">
    <title>Inscription | Restaurant Istanbul - Lubumbashi</title>
    
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
            opacity: 0.08;
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
            transition: transform 0.3s ease;
        }
        
        .auth-container:hover {
            transform: translateY(-5px);
        }
        
        /* Left Panel */
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
            margin-bottom: 50px;
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
            margin-bottom: 18px;
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
        
        .feature-item span {
            font-size: 0.95rem;
        }
        
        .offer-card {
            background: linear-gradient(135deg, rgba(243,156,18,0.15), rgba(230,126,34,0.1));
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(243,156,18,0.2);
            position: relative;
            z-index: 1;
        }
        
        .offer-card i {
            font-size: 2rem;
            color: #f39c12;
            margin-bottom: 10px;
        }
        
        .offer-card h4 {
            margin-bottom: 8px;
        }
        
        .offer-card p {
            margin-bottom: 0;
            font-size: 0.85rem;
            opacity: 0.8;
        }
        
        /* Right Panel */
        .auth-right {
            flex: 1;
            padding: 50px 45px;
            background: white;
        }
        
        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
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
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.9rem;
        }
        
        .form-group label .required {
            color: #e74c3c;
            margin-left: 3px;
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
        
        .input-group input,
        .input-group select {
            width: 100%;
            padding: 15px 16px 15px 48px;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        
        .input-group input:focus,
        .input-group select:focus {
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
        
        .password-strength {
            margin-top: 10px;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s, background 0.3s;
            border-radius: 3px;
        }
        
        .password-strength-text {
            font-size: 0.7rem;
            margin-top: 6px;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 0.8rem;
            margin-top: 6px;
            display: block;
        }
        
        .terms-group {
            margin: 25px 0;
        }
        
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            font-size: 0.85rem;
            color: #555;
        }
        
        .checkbox-label input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #f39c12;
        }
        
        .checkbox-label a {
            color: #f39c12;
            text-decoration: none;
            font-weight: 600;
        }
        
        .checkbox-label a:hover {
            text-decoration: underline;
        }
        
        .btn-register {
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
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(243,156,18,0.4);
        }
        
        .btn-register:active {
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
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .auth-left {
                padding: 40px 30px;
            }
            .auth-right {
                padding: 40px 30px;
            }
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
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
        }
        
        .btn-register.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .btn-register.loading i {
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
        <!-- Left Panel -->
        <div class="auth-left">
            <div class="auth-logo">
                <i class="fas fa-utensils"></i>
                <span>Restaurant Istanbul</span>
            </div>
            <h2>Créez votre compte <span>Lubumbashi</span></h2>
            <p>Rejoignez notre communauté et profitez d'une expérience culinaire exceptionnelle au cœur de l'Avenue Mahenge.</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Réservation en ligne 24h/24</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Commandez vos plats préférés</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Programme de fidélité exclusif</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Offres spéciales membres</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Livraison à domicile</span>
                </div>
            </div>
            
            <div class="offer-card">
                <i class="fas fa-gift"></i>
                <h4>-10% sur votre première commande</h4>
                <p>Offre spéciale nouveaux membres</p>
            </div>
        </div>
        
        <!-- Right Panel -->
        <div class="auth-right">
            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à l'accueil</span>
            </a>
            
            <h3>Inscription</h3>
            <p class="subtitle">Créez votre compte en quelques secondes</p>
            
            @if($errors->any())
                <div class="error-message" style="background: #fee; padding: 12px 15px; border-radius: 12px; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Nom complet <span class="required">*</span></label>
                        <div class="input-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Eunice ekeneshi" required autofocus>
                        </div>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Téléphone <span class="required">*</span></label>
                        <div class="input-group">
                            <i class="fas fa-phone"></i>
                            <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="+243 81 234 5678" required>
                        </div>
                        @error('telephone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Format: +243 81 234 5678 ou 0812345678</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@email.com" required>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Mot de passe <span class="required">*</span></label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="••••••••" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('password')"></i>
                        </div>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="strengthBar"></div>
                        </div>
                        <div class="password-strength-text" id="strengthText"></div>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Confirmer <span class="required">*</span></label>
                        <div class="input-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" id="passwordConfirmation" placeholder="••••••••" required>
                            <i class="fas fa-eye password-toggle" onclick="togglePassword('passwordConfirmation')"></i>
                        </div>
                    </div>
                </div>
               
                
                <button type="submit" class="btn-register" id="registerBtn">
                    <i class="fas fa-user-plus"></i>
                    <span>Créer mon compte</span>
                </button>
            </form>
            
            <div class="auth-footer">
                <p>Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
                <p style="margin-top: 12px; font-size: 0.8rem;">
                    <i class="fas fa-map-marker-alt"></i> Avenue Mahenge, Lubumbashi | 
                    <i class="fas fa-phone"></i> +243 81 234 5678
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const toggleIcon = event.target;
            
            if (field.getAttribute('type') === 'password') {
                field.setAttribute('type', 'text');
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                field.setAttribute('type', 'password');
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]+/)) strength++;
                if (password.match(/[A-Z]+/)) strength++;
                if (password.match(/[0-9]+/)) strength++;
                if (password.match(/[$@#&!]+/)) strength++;
                
                const width = (strength / 5) * 100;
                strengthBar.style.width = width + '%';
                
                if (strength <= 2) {
                    strengthBar.style.background = '#e74c3c';
                    strengthText.textContent = '🔒 Mot de passe faible - Utilisez au moins 8 caractères, majuscules et chiffres';
                    strengthText.style.color = '#e74c3c';
                } else if (strength <= 4) {
                    strengthBar.style.background = '#f39c12';
                    strengthText.textContent = '⚠️ Mot de passe moyen - Ajoutez des caractères spéciaux';
                    strengthText.style.color = '#f39c12';
                } else {
                    strengthBar.style.background = '#27ae60';
                    strengthText.textContent = '✅ Mot de passe fort - Excellent !';
                    strengthText.style.color = '#27ae60';
                }
            });
        }
        
        // Form submission loading state
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            const btn = document.getElementById('registerBtn');
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner"></i> <span>Création du compte...</span>';
        });
        
        // Password confirmation validation
        const passwordConfirmation = document.getElementById('passwordConfirmation');
        if (passwordConfirmation) {
            passwordConfirmation.addEventListener('input', function() {
                const password = document.getElementById('password').value;
                if (this.value !== password && this.value.length > 0) {
                    this.style.borderColor = '#e74c3c';
                } else {
                    this.style.borderColor = '#27ae60';
                }
            });
        }
        
        // Input focus effects
        document.querySelectorAll('.input-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('i:first-child')?.style.setProperty('color', '#f39c12');
            });
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('i:first-child')?.style.setProperty('color', '#bdc3c7');
            });
        });
        
        // Animation on load
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