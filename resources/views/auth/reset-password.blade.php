<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réinitialisation - {{ config('app.name', 'RestoManager') }}</title>
    
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }
        
        .auth-header {
            background: linear-gradient(135deg, #1a2a3a 0%, #0f1a24 100%);
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(243,156,18,0.1) 0%, transparent 70%);
        }
        
        .auth-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .auth-logo i {
            color: #f39c12;
        }
        
        .auth-header h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .auth-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }
        
        .auth-body {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        
        .input-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .input-group input:focus {
            outline: none;
            border-color: #f39c12;
            box-shadow: 0 0 0 3px rgba(243,156,18,0.1);
        }
        
        .btn-reset {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(243,156,18,0.3);
        }
        
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e1e5e9;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s;
        }
        
        .password-strength-text {
            font-size: 0.7rem;
            margin-top: 5px;
        }
        
        .error-message {
            background: #fee;
            color: #e74c3c;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-utensils"></i>
                <span>RestoManager</span>
            </div>
            <h2>Nouveau mot de passe</h2>
            <p>Créez un nouveau mot de passe sécurisé</p>
        </div>
        
        <div class="auth-body">
            @if($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-group">
                    <label>Adresse email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Nouveau mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" required>
                        <i class="fas fa-eye" style="position: absolute; right: 15px; left: auto; cursor: pointer;" onclick="togglePassword('password')"></i>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="password-strength-text" id="strengthText"></div>
                </div>
                
                <div class="form-group">
                    <label>Confirmer le mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" required>
                        <i class="fas fa-eye" style="position: absolute; right: 15px; left: auto; cursor: pointer;" onclick="togglePassword('password_confirmation')"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-reset">
                    <i class="fas fa-key"></i> Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>
    
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
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
                    strengthText.textContent = 'Mot de passe faible';
                    strengthText.style.color = '#e74c3c';
                } else if (strength <= 4) {
                    strengthBar.style.background = '#f39c12';
                    strengthText.textContent = 'Mot de passe moyen';
                    strengthText.style.color = '#f39c12';
                } else {
                    strengthBar.style.background = '#27ae60';
                    strengthText.textContent = 'Mot de passe fort';
                    strengthText.style.color = '#27ae60';
                }
            });
        }
    </script>
</body>
</html>