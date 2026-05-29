<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeDrop | فصائل الدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="description" content="LifeDrop - منصة للتبرع بالدم وإنقاذ الأرواح. ساهم في إنقاذ حياة اليوم.">
    <link rel="stylesheet" href="{{ asset('css/blood-types.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
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
            <li><a href="{{ url('/blood-types') }}" class="active">فصائل الدم</a></li>
            <li><a href="{{ url('/donate') }}">تبرع</a></li>
            <li><a href="{{ url('/request') }}">طلب دم</a></li>
            <li><a href="{{ url('/locations') }}">أماكن التبرع</a></li>
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

<!-- ===== HERO ===== -->
<section class="BT-hero">
    <div class="BT-hero-container">
        <!-- الصورة -->
        <div class="BT-hero-image">
            <img src="{{ asset('images/تصميم بدون عنوان.jpg') }}" alt="تبرع بالدم">
        </div>

        <!-- النص -->
        <div class="BT-hero-content">
            <h1>فصائل الدم:<br><span>كل قطرة تهم</span></h1>
            <p>تعرف على فصيلة دمك ومن يمكنك مساعدتهم، فالتوافق بين الفصائل هو الخطوة الأولى لإنقاذ حياة.</p>
            <div class="BT-hero-buttons">
                <a class="BT-btn-outline">تعرف أكثر</a>
                <a href="{{ url('/donate') }}" class="BT-btn-main">احجز موعد للتبرع</a>
            </div>
        </div>
    </div>
</section>

<!-- ===== BLOOD GUIDE ===== -->
<section class="BT-guide">
    <h2>دليل فصائل الدم</h2>
    <p class="BT-subtitle">اختر فصيلة دمك لتعرف من يمكنك مساعدته ومن يمكنه مساعدتك في حالات الطوارئ</p>

    <div class="BT-cards">
        <!-- بطاقة -O -->
        <div class="BT-blood-card">
            <span class="BT-badge danger">المتبرع العام</span>
            <h3>-O</h3>
            <p class="BT-type">O سالب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: الجميع</div>
                <div class="BT-receive">يستقبل من: -O فقط</div>
            </div>
        </div>

        <!-- بطاقة +O -->
        <div class="BT-blood-card">
            <h3>+O</h3>
            <p class="BT-type">O موجب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: +O, +A, +B, +AB</div>
                <div class="BT-receive">يستقبل من: +O, -O</div>
            </div>
        </div>

        <!-- بطاقة +A -->
        <div class="BT-blood-card">
            <h3>+A</h3>
            <p class="BT-type">A موجب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: +A, +AB</div>
                <div class="BT-receive">يستقبل من: +A, -A, +O, -O</div>
            </div>
        </div>

        <!-- بطاقة -A -->
        <div class="BT-blood-card">
            <h3>-A</h3>
            <p class="BT-type">A سالب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: -A, +A, -AB, +AB</div>
                <div class="BT-receive">يستقبل من: -A, -O</div>
            </div>
        </div>

        <!-- بطاقة +B -->
        <div class="BT-blood-card">
            <h3>+B</h3>
            <p class="BT-type">B موجب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: +B, +AB</div>
                <div class="BT-receive">يستقبل من: +B, -B, +O, -O</div>
            </div>
        </div>

        <!-- بطاقة -B -->
        <div class="BT-blood-card">
            <h3>-B</h3>
            <p class="BT-type">B سالب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: -B, +B, -AB, +AB</div>
                <div class="BT-receive">يستقبل من: -B, -O</div>
            </div>
        </div>

        <!-- بطاقة +AB -->
        <div class="BT-blood-card">
            <h3>+AB</h3>
            <p class="BT-type">AB موجب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: +AB فقط</div>
                <div class="BT-receive">يستقبل من: الجميع</div>
            </div>
        </div>

        <!-- بطاقة -AB -->
        <div class="BT-blood-card">
            <h3>-AB</h3>
            <p class="BT-type">AB سالب</p>
            <div class="BT-blood-details">
                <div class="BT-give">يعطي لـ: -AB, +AB</div>
                <div class="BT-receive">يستقبل من: جميع السالب</div>
            </div>
        </div>
    </div>
</section>

<!-- ===== جدول التوافق + فيديو ===== -->
<section class="BT-compatibility-section">
    <div class="BT-compatibility-container">
        <!-- الجدول -->
        <div class="BT-table-wrapper">
            <h2 class="BT-section-title">جـــــــــــــــــدول التوافـــــــــــــــــق</h2>
            <div class="BT-table-scroll">
                <table class="BT-compatibility-table">
                    <thead>
                        <tr>
                            <th>الفصيلة</th>
                            <th>تعطي الدم لـ</th>
                            <th>تستقبل الدم من</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>A+</td>
                            <td>A+, AB+</td>
                            <td>A+, A-, O+, O-</td>
                        </tr>
                        <tr>
                            <td>O+</td>
                            <td>O+, A+, B+, AB+</td>
                            <td>O+, O-</td>
                        </tr>
                        <tr>
                            <td>B+</td>
                            <td>B+, AB+</td>
                            <td>B+, B-, O+, O-</td>
                        </tr>
                        <tr>
                            <td>AB+</td>
                            <td>AB+</td>
                            <td>الجميع</td>
                        </tr>
                        <tr>
                            <td>A-</td>
                            <td>A+, A-, AB+, AB-</td>
                            <td>A-, O-</td>
                        </tr>
                        <tr>
                            <td>O-</td>
                            <td>الجميع</td>
                            <td>O-</td>
                        </tr>
                        <tr>
                            <td>B-</td>
                            <td>B+, B-, AB+, AB-</td>
                            <td>B-, O-</td>
                        </tr>
                        <tr>
                            <td>AB-</td>
                            <td>AB+, AB-</td>
                            <td>AB-, A-, B-, O-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- الفيديو -->
        <div class="BT-video-wrapper">
            <video autoplay muted loop width="100%">
                <source src="{{ asset('video/owTQWEBfNwoACSkZOTikBizERBKB0gRUsIfLvl.mp4') }}" type="video/mp4">
                متصفحك لا يدعم الفيديو.
            </video>
        </div>
    </div>
</section>

<!-- ===== CTA ===== -->
<section class="BT-cta">
    <h2>هل أنت مستعد لإنقاذ حياة؟</h2>
    <p>تبرعك بالدم عملية آمنة وسريعة وتحدث فرقًا كبيرًا في حياة المحتاجين.</p>
    <a href="{{ url('/donate') }}" class="BT-btn-white">احجز موعد الآن</a>
</section>

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
