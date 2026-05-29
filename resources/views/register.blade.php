<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>إنشاء حساب - بنك الدم</title>
    <style>
        :root {
            --primary-red: #cc1b1b;
            --white: #ffffff;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)),
                        url('{{ asset("images/hero.jpg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .alert-danger {
            background-color: rgba(255, 0, 0, 0.2);
            color: white;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: right;
            border: 1px solid rgba(255, 0, 0, 0.4);
        }
        .alert-danger ul {
            margin: 0;
            padding-right: 20px;
        }
    </style>
</head>

<body>
    @if(session('error'))
        <div class="alert-message alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-message alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <ul style="margin:0;padding-right:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button">&times;</button>
        </div>
    @endif
    <div class="glass-card">
        <form method="POST" action="/register" autocomplete="off">
            @csrf

            <h2 class="form-title">إنشـــاء حســـاب</h2>

            <div class="input-container">
                <input type="text" name="name" placeholder="الاسم الكامل" required autocomplete="off">
            </div>

            <div class="input-container">
                <input type="email" name="email" placeholder="البريد الإلكتروني" required autocomplete="off">
            </div>

            <div class="input-container">
                <input type="password" name="password" placeholder="كلمة المرور" required autocomplete="new-password">
            </div>

            <div class="input-container">
                <input type="text" name="phone" placeholder="رقم الهاتف" required autocomplete="off">
            </div>

            <div class="input-container">
                <input type="text" name="city" placeholder="المدينة" required autocomplete="off">
            </div>

            <!-- قائمة اختيار فصيلة الدم -->
<div class="input-container">
    <select name="blood_type" required class="custom-select">
        <option value="" disabled selected>اختر فصيلة الدم</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
    </select>
</div>

            <button type="submit" class="submit-btn">إنشاء الحساب</button>

            <p class="signup-link">
                عندك حساب؟ <a href="/login">تسجيل دخول</a>
            </p>
        </form>
    </div>

<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>