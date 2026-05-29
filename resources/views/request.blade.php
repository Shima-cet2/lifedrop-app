<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeDrop | الطلب</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="description" content="LifeDrop - منصة للتبرع بالدم وإنقاذ الأرواح. ساهم في إنقاذ حياة اليوم.">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request.css') }}">
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
            <li><a href="{{ url('/request') }}" class="active">طلب دم</a></li>
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

<div class="container-RQ">
    <h1 class="section-title-RQ">طلب وحدات دم للطوارئ</h1>
    <div class="card-RQ">
        <div style="text-align:center; margin-bottom:2rem;">
            <i class="fa-solid fa-truck-medical" style="font-size:3rem; color:#cc1b1b;"></i>
            <p style="margin-top:1rem;">نساعدك في الوصول إلى المتبرعين في أسرع وقت. يرجى توخي الدقة في البيانات.</p>
        </div>

        <form action="{{ route('request.store') }}" method="POST">
            @csrf
            
            @if(session('success'))
                <div class="modal-success-RQ" style="display: flex;">
                    <div class="modal-content-success-RQ" style="opacity: 1; transform: scale(1);">
                        <div class="success-icon-RQ">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h2>تم استلام طلب الطوارئ!</h2>
                        <p>{{ session('success') }}</p>
                        <p class="instruction-RQ">يرجى البقاء بالقرب من الهاتف، سيقوم النظام بتنبيه المتبرعين في منطقتك فوراً.</p>
                        <button type="button" onclick="window.location.href='{{ url('/dashboard') }}'" class="btn-close-RQ">فهمت ذلك</button>
                    </div>
                </div>
            @endif

            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <div class="form-group-RQ" style="flex:1;">
                    <label>اسم المريض / مقدم الطلب</label>
                    <input type="text" required placeholder="الاسم الثلاثي">
                </div>
                <div class="form-group-RQ" style="flex:1;">
                    <label>رقم الهاتف</label>
                    <input type="tel" pattern="09[0-9]{8}" required placeholder="09xxxxxxxx">
                </div>
            </div>

            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <div class="form-group-RQ" style="flex:1;">
                    <label>المدينة</label>
                    <select name="city" required>
                        <option value="">اختر المدينة</option>
                        <option value="Tripoli">طرابلس</option>
                        <option value="Benghazi">بنغازي</option>
                        <option value="Misrata">مصراتة</option>
                        <option value="Khums">الخمس</option>
                    </select>
                </div>
                <div class="form-group-RQ" style="flex:1;">
                    <label>اسم المستشفى</label>
                    <input type="text" name="hospital" required placeholder="مثال: مركز طرابلس الطبي">
                </div>
            </div>

            <div class="blood-details-RQ">
                <label>تفاصيل الدم المطلوبة</label>
                <div style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
                    <div class="form-group-RQ" style="flex:1; margin-bottom:0;">
                        <label>الفصيلة</label>
                        <select name="required_type" required>
                            <option value="">اختر الفصيلة</option>
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
                    <div class="form-group-RQ" style="flex:1; margin-bottom:0;">
                        <label>عدد الأكياس</label>
                        <input type="number" min="1" max="10" value="1" required>
                    </div>
                </div>

                <div class="urgency-options-RQ">
                    <label>مستوى الحالة:</label>
                    <label><input type="radio" name="urgency" value="normal" checked> عادي</label>
                    <label class="urgent-RQ"><input type="checkbox" name="is_urgent" value="1" style="width: auto;"> طارئة / حرجة </label>
                </div>
            </div>

            <div class="form-group-RQ">
                <label>ملاحظات إضافية</label>
                <textarea name="notes" rows="3" placeholder="أي تفاصيل أخرى..."></textarea>
            </div>

            <button type="submit" class="btn-primary-RQ" style="width:100%;">إرسال طلب طوارئ </button>
        </form>
    </div>
</div>

<div id="successModal-RQ" class="modal-success-RQ">
    <div class="modal-content-success-RQ">
        <div class="success-icon-RQ">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <h2>تم استلام طلب الطوارئ!</h2>
        <p>رقم تتبع الطلب الخاص بك هو:</p>
        <div class="tracking-number-RQ" id="tracking-id-RQ">#RQ-8821</div>
        <p class="instruction-RQ">يرجى البقاء بالقرب من الهاتف، سيقوم النظام بتنبيه المتبرعين في منطقتك فوراً.</p>
        <button id="closeSuccessBtn-RQ" class="btn-close-RQ" onclick="window.location.href='{{ url('/dashboard') }}'">فهمت ذلك</button>
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
