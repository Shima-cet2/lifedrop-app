<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول - بنك الدم</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)),
                        url('{{ asset("images/hero.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .error-message {
            background-color: rgba(255, 0, 0, 0.2);
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(255, 0, 0, 0.4);
        }
        
        .success-message {
            background-color: rgba(40, 167, 69, 0.2);
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid rgba(40, 167, 69, 0.4);
        }
    </style>
</head>
<body>

<div class="glass-card">
    <form method="POST" action="/login" autocomplete="off">
        @csrf

        <h2 class="form-title">تسجـيــــل دخــــــول</h2>

        @if(session('success'))
            <div class="alert-message alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-message alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-message alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <ul style="margin:0;padding-right:18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button">&times;</button>
            </div>
        @endif
        
        <div class="input-container">
            <input type="email" name="email" value="{{ request()->cookie('remembered_email') ?? old('email') }}" placeholder="البريد الإلكتروني" required autocomplete="off">
        </div>

        <div class="input-container">
            <input type="password" name="password" placeholder="كلمة المرور" required autocomplete="new-password">
        </div>

        <div class="input-container" style="display: flex; align-items: center; gap: 10px; color: white; margin-bottom: 20px;">
            <input type="checkbox" name="remember" id="remember" style="width: auto; margin:0;" {{ request()->hasCookie('remembered_email') ? 'checked' : '' }}>
            <label for="remember" style="font-size: 0.9rem; cursor: pointer;">تذكرني (Remember Me)</label>
        </div>

        <button type="submit" class="submit-btn">تسجيل الدخول</button>
        
        <p class="signup-link">
            جديد هنا؟ <a href="/register">أنشئ حساباً</a>
        </p>
    </form>
</div>

<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>