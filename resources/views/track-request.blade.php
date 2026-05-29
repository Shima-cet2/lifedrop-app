<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeDrop | تتبع طلب الدم</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
    <style>
        .timeline {
            display: flex;
            justify-content: space-between;
            margin: 4rem 1rem 3rem;
            position: relative;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: #eee;
            z-index: 1;
            transform: translateY(-50%);
        }
        .step {
            position: relative;
            z-index: 2;
            background: white;
            padding: 10px;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #eee;
            font-size: 24px;
            color: #999;
            transition: all 0.3s;
        }
        .step.active {
            border-color: #d97706; /* orange */
            color: #d97706;
        }
        .step.done {
            background: #cc1b1b;
            border-color: #cc1b1b;
            color: white;
        }
        .step-label {
            position: absolute;
            top: 70px;
            white-space: nowrap;
            font-weight: bold;
            font-size: 15px;
            color: #555;
        }
        .result-card {
            background: #fff;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-top: 2.5rem;
            text-align: center;
            border-top: 5px solid #cc1b1b;
        }
        .result-card h3 { margin-bottom: 20px; color: #cc1b1b; font-size: 1.5rem; }
    </style>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-tint blood-icon"></i>
            <span class="logo-text">Life<span>Drop</span></span>
        </div>
        
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">الرئيسية</a></li>
            <li><a href="{{ url('/blood-types') }}">فصائل الدم</a></li>
            <li><a href="{{ url('/donate') }}">تبرع</a></li>
            <li><a href="{{ url('/request') }}">طلب دم</a></li>
            <li><a href="{{ url('/locations') }}">أماكن التبرع</a></li>
            <li><a href="{{ url('/track') }}" class="active">تتبع الطلب</a></li>
        </ul>
        <div class="nav-buttons">
            <a href="{{ url('/dashboard') }}">
                <button class="btn-login" style="background:#2e7d32; color:white; border-color:#2e7d32;" type="button">لوحة التحكم</button>
            </a>
        </div>
    </nav>
</header>

<div class="container-LC" style="padding: 4rem 0;">
    <h1 class="section-title-LC">تتبع حالة طلب الدم</h1>
    
    <div style="max-width: 700px; margin: 0 auto;">
        @if(session('error'))
            <div style="background: #fee2e2; color: #ef4444; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align:center; font-weight:bold;">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="card-LC">
            <form method="POST" action="{{ route('track.process') }}">
                @csrf
                <div class="form-group-LC">
                    <label>أدخل رقم التتبع الخاص بك (مثال: RQ-A1B2C3)</label>
                    <input type="text" name="tracking_id" required placeholder="RQ-XXXXXX" style="text-align: left; direction: ltr;" value="{{ old('tracking_id') ?? (isset($bloodRequest) ? $bloodRequest->tracking_id : '') }}">
                </div>
                <button type="submit" class="btn-LC btn-primary-LC" style="width: 100%;">تتبع الآن <i class="fas fa-search"></i></button>
            </form>
        </div>
        
        @if(isset($bloodRequest))
        <div class="result-card">
            <h3>تفاصيل الطلب: <span dir="ltr" style="color:#333;">{{ $bloodRequest->tracking_id }}</span></h3>
            <div style="display:flex; justify-content:space-around; margin-bottom:20px;">
                <p><strong>الفصيلة المطلوبة:</strong> <span dir="ltr" style="color:#cc1b1b; font-weight:bold; font-size:1.2rem;">{{ $bloodRequest->required_type }}</span></p>
                <p><strong>المستشفى:</strong> {{ $bloodRequest->hospital }}</p>
                <p><strong>المدينة:</strong> {{ $bloodRequest->city }}</p>
            </div>
            
            <div class="timeline">
                <!-- خطوة الاستلام -->
                <div class="step {{ in_array($bloodRequest->status, ['pending', 'provided']) ? 'done' : '' }}">
                    <i class="fas fa-file-signature"></i>
                    <div class="step-label">تم الاستلام</div>
                </div>
                
                <!-- خطوة قيد المعالجة -->
                <div class="step {{ $bloodRequest->status == 'provided' ? 'done' : ($bloodRequest->status == 'pending' ? 'active' : '') }}">
                    <i class="fas fa-spinner {{ $bloodRequest->status == 'pending' ? 'fa-spin' : '' }}"></i>
                    <div class="step-label">قيد المعالجة</div>
                </div>
                
                <!-- خطوة تم التوفير -->
                <div class="step {{ $bloodRequest->status == 'provided' ? 'done' : '' }}">
                    <i class="fas fa-check"></i>
                    <div class="step-label">تم التوفير</div>
                </div>
            </div>
            
            @if($bloodRequest->status == 'cancelled')
                <div style="margin-top:40px; padding: 15px; background: #fee2e2; color: #ef4444; font-weight: bold; border-radius: 8px;">
                    <i class="fas fa-times-circle"></i> نأسف، تم إلغاء هذا الطلب من قبل الإدارة. يرجى التواصل للمزيد من التفاصيل.
                </div>
            @endif
        </div>
        @endif
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>
