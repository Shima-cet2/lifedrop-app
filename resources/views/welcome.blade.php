<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول - بنك الدم</title>

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
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
        
    </style>
</head>
<body>

<div class="glass-card">
    <form method="POST" action="/login">
        @csrf

        <h2 class="form-title">تسجـيــــل دخــــــول</h2>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="input-container">
            <input type="email" name="email" placeholder="البريد الإلكتروني" required>
        </div>

        <div class="input-container">
            <input type="password" name="password" placeholder="كلمة المرور" required>
        </div>

        <button type="submit" class="submit-btn">تسجيل الدخول</button>
        
        <p class="signup-link">
            جديد هنا؟ <a href="/register">أنشئ حساباً</a>
        </p>
    </form>
</div>
<!-- إضافة خيار تذكرني (Cookies) -->
<div class="remember-me-container" style="margin-bottom: 15px; color: white; font-size: 0.9rem;">
    <input type="checkbox" name="remember" id="remember">
    <label for="remember">تذكرني</label>
</div>

<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>