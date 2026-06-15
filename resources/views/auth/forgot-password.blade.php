<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Réinitialisez votre mot de passe Restaurant Istamboul à Lubumbashi. Recevez un lien de réinitialisation par email.">
    <title>Mot de passe oublié | Restaurant Istamboul - Lubumbashi</title>
    
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
            max-width: 550px;
            width: 100%;
            background: rgba(255,255,255,0.98);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .auth-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 70px rgba(0,0,0,0.4);
        }
        
        /* Header Section */
        .auth-header {
            background: linear-gradient(135deg, #1a2a3a 0%, #0f1a24 100%);
            padding: 45px 35px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
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
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 25px;
            position: relative;
            z-index: 1;
        }
        
        .auth-logo i {
            font-size: 2.2rem;
            color: #f39c12;
            filter: drop-shadow(0 0 10px rgba(243,156,18,0.3));
        }
        
        .auth-logo span {
            background: linear-gradient(135deg, #fff, #f39c12);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .auth-header h2 {
            font-size: 1.8rem;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
            font-weight: 700;
        }
        
        .auth-header p {
            opacity: 0.85;
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }
        
        /* Body Section */
        .auth-body {
            padding: 45px 40px;
            background: white;
        }
        
        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            color: #7f8c8d;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
            padding: 8px 18px;
            border-radius: 30px;
            background: #f8f9fa;
        }
        
        .back-home:hover {
            color: #f39c12;
            background: #fff3e0;
            transform: translateX(-5px);
        }
        
        .info-message {
            background: linear-gradient(135deg, #e3f2fd, #bbdef5);
            color: #1565c0;
            padding: 16px 18px;
            border-radius: 20px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 0.9rem;
            border-left: 4px solid #1976d2;
        }
        
        .info-message i {
            font-size: 1.3rem;
        }
        
        .form-group {
            margin-bottom: 30px;
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
            padding: 16px 16px 16px 48px;
            border: 2px solid #e9ecef;
            border-radius: 20px;
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
        
        .btn-send {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            border: none;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        
        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(243,156,18,0.4);
        }
        
        .btn-send:active {
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
            font-size: 0.9rem;
            margin-bottom: 10px;
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
        
        .success-message {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            color: #2e7d32;
            padding: 14px 18px;
            border-radius: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #4caf50;
            font-size: 0.9rem;
        }
        
        .error-message {
            background: linear-gradient(135deg, #ffebee, #ffcdd2);
            color: #c62828;
            padding: 14px 18px;
            border-radius: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #f44336;
            font-size: 0.9rem;
        }
        
        /* Help section */
        .help-section {
            margin-top: 30px;
            background: #f8f9fa;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
        }
        
        .help-section h4 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        
        .help-section p {
            color: #7f8c8d;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }
        
        .contact-support {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #f39c12;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .contact-support:hover {
            gap: 12px;
            color: #e67e22;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            .auth-header {
                padding: 35px 25px;
            }
            
            .auth-header h2 {
                font-size: 1.5rem;
            }
            
            .auth-body {
                padding: 35px 25px;
            }
            
            .auth-logo {
                font-size: 1.5rem;
            }
            
            .auth-logo i {
                font-size: 1.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .auth-body {
                padding: 25px 20px;
            }
            
            .info-message {
                font-size: 0.8rem;
                padding: 12px 15px;
            }
            
            .btn-send {
                padding: 14px;
            }
        }
        
        /* Loading state */
        .btn-send.loading {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .btn-send.loading i {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Animation on load */
        .auth-container {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }
        
        /* Input validation styles */
        .input-group.valid input {
            border-color: #27ae60;
        }
        
        .input-group.invalid input {
            border-color: #e74c3c;
        }
        
        .validation-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
        }
        
        .validation-icon.valid {
            color: #27ae60;
        }
        
        .validation-icon.invalid {
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="auth-container" id="authContainer">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-utensils"></i>
                <span>Restaurant Istamboul</span>
            </div>
            <h2>Mot de passe oublié ?</h2>
            <p>Ne vous inquiétez pas, nous sommes là pour vous aider</p>
        </div>
        
        <div class="auth-body">
            <a href="{{ url('/') }}" class="back-home">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à l'accueil</span>
            </a>
            
            <div class="info-message">
                <i class="fas fa-shield-alt"></i>
                <div>
                    <strong>Réinitialisation sécurisée</strong><br>
                    Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </div>
            </div>
            
            @if(session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Email envoyé !</strong><br>
                        {{ session('status') }}
                    </div>
                </div>
            @endif
            
            @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Erreur</strong><br>
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                @csrf
                
                <div class="form-group">
                    <label>Adresse email</label>
                    <div class="input-group" id="emailGroup">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                               placeholder="exemple@email.com" required autofocus>
                        <div class="validation-icon" id="emailValidation"></div>
                    </div>
                    <small style="color: #7f8c8d; font-size: 0.7rem; display: block; margin-top: 8px;">
                        <i class="fas fa-info-circle"></i> Nous enverrons le lien à cette adresse
                    </small>
                </div>
                
                <button type="submit" class="btn-send" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Envoyer le lien de réinitialisation</span>
                </button>
            </form>
        
            
            <div class="auth-footer">
                <p>
                    <i class="fas fa-chevron-left"></i> 
                    <a href="{{ route('login') }}">Retour à la connexion</a>
                </p>
                <p>Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte gratuitement</a></p>
                <p style="margin-top: 15px; font-size: 0.75rem;">
                    <i class="fas fa-map-marker-alt"></i> Avenue Mahenge, Lubumbashi | 
                    <i class="fas fa-phone"></i> +243 81 234 5678
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Animation on load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('authContainer');
            setTimeout(() => {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
        
        // Email validation
        const emailInput = document.getElementById('email');
        const emailGroup = document.getElementById('emailGroup');
        const emailValidation = document.getElementById('emailValidation');
        
        function validateEmail(email) {
            const re = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
            return re.test(email);
        }
        
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const email = this.value;
                if (email.length > 0) {
                    if (validateEmail(email)) {
                        emailGroup.classList.remove('invalid');
                        emailGroup.classList.add('valid');
                        emailValidation.innerHTML = '<i class="fas fa-check-circle"></i>';
                        emailValidation.className = 'validation-icon valid';
                    } else {
                        emailGroup.classList.remove('valid');
                        emailGroup.classList.add('invalid');
                        emailValidation.innerHTML = '<i class="fas fa-times-circle"></i>';
                        emailValidation.className = 'validation-icon invalid';
                    }
                } else {
                    emailGroup.classList.remove('valid', 'invalid');
                    emailValidation.innerHTML = '';
                }
            });
        }
        
        // Form submission loading state
        const resetForm = document.getElementById('resetForm');
        const sendBtn = document.getElementById('sendBtn');
        
        if (resetForm) {
            resetForm.addEventListener('submit', function(e) {
                const email = emailInput.value;
                if (!validateEmail(email)) {
                    e.preventDefault();
                    emailGroup.classList.add('invalid');
                    emailValidation.innerHTML = '<i class="fas fa-times-circle"></i>';
                    emailValidation.className = 'validation-icon invalid';
                    
                    // Show error message
                    let errorDiv = document.querySelector('.error-message');
                    if (!errorDiv) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message';
                        errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i><div><strong>Erreur</strong><br>Veuillez entrer une adresse email valide.</div>';
                        resetForm.insertBefore(errorDiv, resetForm.firstChild);
                    }
                    return;
                }
                
                sendBtn.classList.add('loading');
                sendBtn.innerHTML = '<i class="fas fa-spinner"></i> <span>Envoi en cours...</span>';
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
        
        // Auto-hide messages after 5 seconds
        setTimeout(() => {
            const successMsg = document.querySelector('.success-message');
            const errorMsg = document.querySelector('.error-message');
            if (successMsg) {
                successMsg.style.transition = 'opacity 0.5s';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 500);
            }
            if (errorMsg && !errorMsg.innerHTML.includes('Veuillez entrer')) {
                errorMsg.style.transition = 'opacity 0.5s';
                errorMsg.style.opacity = '0';
                setTimeout(() => errorMsg.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>