<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeDrop | مواقع التبرع القريبة منك</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="description" content="LifeDrop - منصة للتبرع بالدم وإنقاذ الأرواح. ساهم في إنقاذ حياة اليوم.">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <!-- استخدام ملف التنسيق الشامل الذي أضفناه سابقاً لاحتوائه على التنسيقات العامة -->
    <link rel="stylesheet" href="{{ asset('css/blood-types.css') }}">
    <link rel="stylesheet" href="{{ asset('css/locations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-tint blood-icon"></i>
            <span class="logo-text">Life<span>Drop</span></span>
        </div>
        
        <div class="theme-toggle" title="تبديل الوضع الليلي">
            <i class="fas fa-moon"></i>
        </div>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}">الرئيسية</a></li>
            <li><a href="{{ url('/blood-types') }}">فصائل الدم</a></li>
            <li><a href="{{ url('/donate') }}">تبرع</a></li>
            <li><a href="{{ url('/request') }}">طلب دم</a></li>
            <li><a href="{{ url('/locations') }}" class="active">أماكن التبرع</a></li>
            <li><a href="{{ url('/contact') }}">تواصل معنا</a></li>
        </ul>

        <div class="nav-buttons">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ url('/admin') }}">
                        <button class="btn-login" style="background:#2e7d32; color:white; border-color:#2e7d32;" type="button">لوحة الإدارة</button>
                    </a>
                @else
                    <a href="{{ url('/dashboard') }}">
                        <button class="btn-login" style="background:#2e7d32; color:white; border-color:#2e7d32;" type="button">حسابي (Dashboard)</button>
                    </a>
                @endif
            @else
                <a href="{{ url('/login') }}">
                    <button class="btn-login" type="button">تسجيل الدخول</button>
                </a>
            @endauth
            <div class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>
</header>

<div class="container" style="padding: 4rem 0;">
    <h1 class="section-title">مراكز التبرع القريبة منك</h1>

    <div class="filter-container">
        <label style="font-weight: bold; font-size: 1.1rem;"><i class="fa-solid fa-filter"></i> تصفية حسب المدينة:</label>
        <select id="city-select">
            <option value="all">عرض الكل</option>
            <option value="Tripoli">طرابلس</option>
            <option value="Benghazi">بنغازي</option>
            <option value="Misrata">مصراتة</option>
            <option value="Khums">الخمس</option>
        </select>
    </div>

    <div id="locations-list">
        @forelse($donationCenters as $center)
        <div class="location-card fade-in" data-city="{{ $center->city }}">
            <div>
                <h3>{{ $center->name }}</h3>
                <p><i class="fa-solid fa-location-dot"></i> {{ $center->city }} - {{ $center->address }}</p>
                <p><i class="fa-solid fa-phone"></i> {{ $center->phone }}</p>
            </div>
            <div>
                <a href="#" class="btn btn-secondary">عرض على الخريطة</a>
            </div>
        </div>
        @empty
        <div style="text-align:center; padding: 40px;">
            <p>لا توجد مراكز تبرع مسجلة حالياً.</p>
        </div>
        @endforelse
    </div>
</div>

<footer class="main-footer">
    <div class="footer-top">
        <div class="footer-logo">
            <span class="logo-text">Life<span>Drop</span></span>
        </div>
        
        <ul class="footer-links">
            <li><a href="#">سياسة الخصوصية</a></li>
            <li><a href="#">الشروط والأحكام</a></li>
            <li><a href="#">الأسئلة الشائعة</a></li>
        </ul>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 211100 LifeDrop. جميع الحقوق محفوظة.</p>
    </div>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>
