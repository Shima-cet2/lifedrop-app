<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeDrop | التبرع بالدم</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/donate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
</head>

<body>

<!-- ===== Header ===== -->
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
            <li><a href="{{ url('/donate') }}" class="active">تبرع</a></li>
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

<!-- ===== Main ===== -->
<main class="container DN-page">

    <!-- Eligibility Check -->
    <section class="DN-check">
        <h2>هل أنت مؤهل للتبرع؟</h2>

        <label>
            <input type="checkbox">
            عمري فوق 18 سنة
        </label>

        <label>
            <input type="checkbox">
            وزني أكثر من 50 كجم
        </label>

        <label>
            <input type="checkbox">
            لم أتبرع خلال 3 أشهر
        </label>

        <button id="verifyBtn" class="DN-btn DN-btn-secondary">
            تحقق الآن
        </button>

        <div id="checkResult" class="DN-check-result"></div>
    </section>

    <!-- رسائل النجاح / الخطأ (خارج الفورم) -->
    @if(session('success'))
        <div class="alert-message alert-success" style="animation: slideInDown 0.5s ease-out;">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.style.display='none';" style="background:none; border:none; color:inherit; cursor:pointer; font-size:1.2rem;">×</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert-message alert-error" style="animation: slideInDown 0.5s ease-out;">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.style.display='none';" style="background:none; border:none; color:inherit; cursor:pointer; font-size:1.2rem;">×</button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert-message alert-error" style="animation: slideInDown 0.5s ease-out;">
            <i class="fas fa-exclamation-triangle"></i>
            <div style="flex:1;">
                <strong>⚠️ حدثت أخطاء:</strong>
                <ul style="margin:8px 0 0; padding-right:18px; font-size:0.9rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" onclick="this.parentElement.style.display='none';" style="background:none; border:none; color:inherit; cursor:pointer; font-size:1.2rem;">×</button>
        </div>
    @endif

    <!-- Title -->
    <h1 class="DN-title">حجز موعد التبرع</h1>

    <!-- Donate Form -->
    <section class="DN-form-box">

        <form id="donationForm" action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="DN-form-group">
                <label>الاسم الكامل</label>
                <input type="text" value="{{ auth()->user()->name }}" readonly style="background:#f5f5f5; cursor:not-allowed;">
            </div>

            <div class="DN-form-row">
                <input type="tel" value="{{ auth()->user()->phone ?? 'غير محدد' }}" placeholder="رقم الهاتف" readonly style="background:#f5f5f5; cursor:not-allowed;">
                <input type="text" value="{{ auth()->user()->blood_type ?? 'غير محدد' }}" placeholder="فصيلة الدم" readonly dir="ltr" style="background:#f5f5f5; cursor:not-allowed;">
            </div>

            <div class="DN-form-group">
                <label>اختر مركز التبرع</label>
                <select name="donation_center_id" required style="padding:10px;">
                    <option value="">-- اختر المركز --</option>
                    @foreach($donationCenters as $center)
                        <option value="{{ $center->id }}" {{ old('donation_center_id') == $center->id ? 'selected' : '' }}>
                            {{ $center->name }} - {{ $center->city }}
                        </option>
                    @endforeach
                </select>
                @error('donation_center_id')
                    <span style="color:#e11d48; font-size:0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="DN-form-group">
                <label>تاريخ موعد التبرع</label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
                @error('appointment_date')
                    <span style="color:#e11d48; font-size:0.9rem;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="DN-btn DN-btn-primary DN-btn-full">
                تأكيد حجز الموعد
            </button>

        </form>
    </section>

</main>

<!-- ===== Footer ===== -->
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
