<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeDrop | الرئيسية</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="description" content="LifeDrop - منصة للتبرع بالدم وإنقاذ الأرواح. ساهم في إنقاذ حياة اليوم.">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
            <li><a href="{{ url('/') }}" class="active">الرئيسية</a></li>
            <li><a href="{{ url('/blood-types') }}">فصائل الدم</a></li>
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

<section class="hero-overlay">
    <div class="hero-content">
        <h1>تبرع بالدم، <span>أنقذ حياة</span></h1>
        <p>انضم إلى مجتمع الأبطال. بضع دقائق من وقتك يمكن أن تمنح سنوات من الحياة لشخص آخر.</p>
        <div class="hero-btns">
            <a href="{{ url('/donate') }}" class="btn-white">تبرع الآن</a>
            <a href="{{ url('/request') }}" class="btn-outline">اطلب دم</a>
        </div>
    </div>
</section>

<div class="alert-banner">
    <div class="alert-content">
        <span class="alert-icon">⚠️</span>
        <p>تنبيه عاجل: هناك حاجة ماسة لمتبرعين من فصيلة <strong>O-</strong> و <strong>A+</strong> في المراكز القريبة منك.</p>
        <a href="{{ url('/locations') }}" class="alert-link">ابحث عن مركز تبرع</a>
    </div>
</div>

<section class="urgent-needs" style="margin-bottom: 1rem;">
    <div class="urgent-header">
        <h2><i class="fas fa-tint"></i>  فصائل الدم المطلوبة عاجلاً</h2>
    </div>
    
    <div class="needs-container" id="urgent-needs-container">
        @forelse($urgentRequests as $request)
        <div class="need-card">
            <div class="status-label critical">حرج جداً</div>
            <div class="blood-info">
                <span class="blood-type" dir="ltr">{{ $request->required_type }}</span>
                <span class="blood-text">فصيلة</span>
            </div>
            <div style="margin-top: 15px;">
                <p><strong>المدينة:</strong> {{ $request->city }}</p>
                <p><strong>المستشفى:</strong> {{ $request->hospital }}</p>
            </div>
            <div class="progress-bar" style="margin-top: 15px;">
                <div class="progress" style="width: 8%;"></div>
                <div class="progress" data-width="85%" style="width: 0;"></div>
            </div>
        </div>
        @empty
        <div class="need-card" style="width:100%; text-align:center;">
            <p>لا توجد طلبات عاجلة في الوقت الحالي. الحمد لله!</p>
        </div>
        @endforelse
    </div>
</section>

<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">💧</div>
            <h3 data-target="+{{ $stats['donations'] }}">+0</h3>
            <p>وحدة تم جمعها</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">❤️</div>
            <h3 data-target="+{{ $stats['lives'] }}">+0</h3>
            <p>حياة تم إنقاذها</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">🏥</div>
            <h3 data-target="+{{ $stats['centers'] }}">+0</h3>
            <p>مستشفى شريك</p>
        </div>
    </div>
</section>

<section class="why-donate">
    <div class="why-content">
        <span class="section-tag">فوائد التبرع</span>
        <h2>لماذا تتبرع بالدم؟</h2>
        <p>فوائد صحية وإنسانية تعود عليك وعلى مجتمعك. التبرع بالدم ليس مجرد عمل خيري، بل هو استثمار في صحتك وصحة الآخرين.</p>
        <a href="#" class="read-more">اقرأ المزيد ←</a>
    </div>

    <div class="features-cards">
        <div class="feature-item">
            <div class="feature-icon">🩺</div>
            <h4>فحص طبي مجاني</h4>
            <p>اطمئن على صحتك العامة مع كل تبرع من خلال الفحوصات الدورية.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">😊</div>
            <h4>راحة نفسية</h4>
            <p>شعور بالإنجاز والمساهمة الفعالة في إنقاذ الأرواح يمنحك السعادة.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🤝</div>
            <h4>تضامن مجتمعي</h4>
            <p>كن جزءاً فعالاً في مساعدة مجتمعك وتعزيز روابط التكافل الاجتماعي.</p>
        </div>
    </div>
</section>

<section class="final-cta">
    <div class="cta-content-side">
        <h2>هل أنت مستعد لتكون بطلاً؟</h2> 
        <p>تبرعك اليوم قد يكون السبب في شفاء مريض غداً. لا تتردد، فالعملية آمنة وسهلة وسريعة.</p>
        <div class="cta-buttons">
            <a href="{{ url('/donate') }}" class="btn-main-red">احجز موعد تبرع</a>
            <a href="#" class="btn-outline-white">تعرف على المزيد</a>
        </div>
    </div>

    <div class="cta-video-side">
        <video autoplay controls class="side-video">
            <source src="{{ asset('video/oceDIgZeUCl9yDxPdgCVEbfcgQL2CRJuH5GSNI.mp4') }}" type="video/mp4">
            متصفحك لا يدعم الفيديو
        </video>
    </div>
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
<script>
    // Polling لجلب الطلبات العاجلة كل 10 ثواني بدون إعادة تحميل
    setInterval(() => {
        fetch('/api/urgent-requests')
            .then(res => res.json())
            .then(data => {
                const container = document.getElementById('urgent-needs-container');
                if (!container) return;

                if (data.length === 0) {
                    container.innerHTML = `
                        <div class="need-card" style="width:100%; text-align:center;">
                            <p>لا توجد طلبات عاجلة في الوقت الحالي. الحمد لله!</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                data.forEach(req => {
                    html += `
                    <div class="need-card">
                        <div class="status-label critical">حرج جداً</div>
                        <div class="blood-info">
                            <span class="blood-type" dir="ltr">${req.required_type}</span>
                            <span class="blood-text">فصيلة</span>
                        </div>
                        <div style="margin-top: 15px;">
                            <p><strong>المدينة:</strong> ${req.city}</p>
                            <p><strong>المستشفى:</strong> ${req.hospital}</p>
                        </div>
                        <div class="progress-bar" style="margin-top: 15px;">
                            <div class="progress" style="width: 8%;"></div>
                        </div>
                    </div>
                    `;
                });
                container.innerHTML = html;
            })
            .catch(err => console.error('Error fetching urgent requests:', err));
    }, 10000); // 10 ثواني
</script>
<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>
