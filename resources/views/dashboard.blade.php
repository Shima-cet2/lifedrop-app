<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة المستخدم | LifeDrop</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">

    <style>
        :root {
            --primary-red: #cc1b1b;
            --dark-red: #9b1515;
            --light-bg: #fcfcfc;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #636e72;
            --shadow-md: 0 10px 20px rgba(0,0,0,0.08);
            --shadow-lg: 0 15px 30px rgba(211, 47, 47, 0.2);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: var(--light-bg);
            color: var(--text-dark);
            direction: rtl;
        }

        .navbar {
            background: rgba(255,255,255,0.9);
            padding: 1.2rem 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            border-radius: 0 0 18px 18px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 26px;
            font-weight: 800;
            color: var(--primary-red);
        }

        .logo span span {
            color: #333;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 18px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
        }

        .nav-links a:hover {
            color: var(--primary-red);
        }

        .logout-btn {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 10px 22px;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 700;
        }

        .dashboard-hero {
            background: linear-gradient(135deg, rgba(204,27,27,0.95), rgba(155,21,21,0.95));
            color: white;
            margin: 35px 7%;
            border-radius: 25px;
            padding: 45px;
            box-shadow: var(--shadow-lg);
        }

        .dashboard-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .dashboard-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .dashboard-container {
            padding: 0 7% 60px;
        }

        .profile-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }

        .summary-card {
            background: var(--white);
            padding: 28px;
            border-radius: 22px;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .summary-card:hover {
            transform: translateY(-8px);
        }

        .summary-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            margin-bottom: 16px;
        }

        .red { background: #fff1f2; color: #cc1b1b; }
        .blue { background: #e0f2ff; color: #1e88e5; }
        .green { background: #e6f4ea; color: #43a047; }
        .purple { background: #f3e5f5; color: #8e24aa; }

        .summary-card h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .summary-card p {
            color: var(--text-gray);
            font-weight: 600;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
        }

        .panel {
            background: var(--white);
            padding: 30px;
            border-radius: 22px;
            box-shadow: var(--shadow-md);
            margin-bottom: 30px;
        }

        .panel h2 {
            color: var(--primary-red);
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .eligibility-box {
            background: #fff1f2;
            border: 2px solid #ffe4e6;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 22px;
        }

        .eligibility-box strong {
            color: var(--primary-red);
            font-size: 1.2rem;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .action-btn {
            display: block;
            background: var(--primary-red);
            color: white;
            text-decoration: none;
            padding: 15px;
            border-radius: 14px;
            text-align: center;
            font-weight: 700;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--dark-red);
            transform: translateY(-5px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fff1f2;
            color: var(--primary-red);
            padding: 14px;
            text-align: right;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #eee;
        }

        .status {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .pending {
            background: #fff7e6;
            color: #d97706;
        }

        .done {
            background: #e6f4ea;
            color: #43a047;
        }

        .notification {
            padding: 15px;
            border-radius: 14px;
            background: #f9fafb;
            margin-bottom: 12px;
            border-right: 4px solid var(--primary-red);
        }

        .notification p {
            color: var(--text-gray);
            font-size: 0.95rem;
        }

        @media (max-width: 900px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }

            .dashboard-hero {
                margin: 25px 5%;
                padding: 30px;
            }

            .dashboard-container {
                padding: 0 5% 50px;
            }
        }
    </style>
</head>

<body>

<header>
    <nav class="navbar">
        <div class="logo">
            <i class="fas fa-tint"></i>
            <span>Life<span>Drop</span></span>
        </div>

        <ul class="nav-links">
            <li><a href="/" title="العودة للصفحة الرئيسية">الرئيسية</a></li>
            <li><a href="/blood-types" title="معلومات حول فصائل الدم والتوافق">فصائل الدم</a></li>
            <li><a href="/donate" title="حجز موعد أو إعلان استعدادك للتبرع">تبرع</a></li>
            <li><a href="/request" title="إنشاء طلب عاجل للحصول على دم">طلب دم</a></li>
            <li><a href="/locations" title="خريطة ومواقع بنوك الدم والمستشفيات">أماكن التبرع</a></li>
        </ul>

        <form method="POST" action="/logout">
            @csrf
            <button class="logout-btn" type="submit" title="تسجيل الخروج من الحساب">تسجيل خروج</button>
        </form>
    </nav>
</header>

<section class="dashboard-hero">
    <h1>مرحباً، {{ auth()->user()->name ?? 'مستخدم' }} 👋</h1>
    <p>هذه لوحتك الشخصية لمتابعة تبرعاتك، طلبات الدم، وحالة أهليتك للتبرع.</p>
</section>

<main class="dashboard-container">

    <section class="profile-summary">
        <div class="summary-card">
            <div class="summary-icon red"><i class="fas fa-droplet"></i></div>
            <h3>{{ auth()->user()->blood_type ?? 'غير محدد' }}</h3>
            <p>فصيلة الدم</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon blue"><i class="fas fa-location-dot"></i></div>
            <h3>{{ auth()->user()->city ?? 'غير محدد' }}</h3>
            <p>المدينة</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon {{ auth()->user()->isEligibleToDonate() ? 'green' : 'red' }}"><i class="fas fa-calendar-check"></i></div>
            <h3 style="color: {{ auth()->user()->isEligibleToDonate() ? '#43a047' : '#cc1b1b' }}">{{ auth()->user()->isEligibleToDonate() ? 'مؤهل' : 'غير مؤهل' }}</h3>
            <p>حالة التبرع</p>
        </div>

        <div class="summary-card">
            <div class="summary-icon purple"><i class="fas fa-bell"></i></div>
            <h3>{{ auth()->user()->unreadNotifications->count() }}</h3>
            <p>إشعارات جديدة</p>
        </div>
    </section>

    <section class="dashboard-grid">

        <div>
            <div class="panel">
                <h2>حالة الأهلية للتبرع</h2>

                <div class="eligibility-box" style="background: {{ auth()->user()->isEligibleToDonate() ? '#fff1f2' : '#fee2e2' }}; border-color: {{ auth()->user()->isEligibleToDonate() ? '#ffe4e6' : '#fecaca' }};">
                    @if(auth()->user()->isEligibleToDonate())
                        <strong style="color: var(--primary-red);">أنت مؤهل للتبرع الآن ✅</strong>
                        <p>يمكنك حجز موعد تبرع جديد من خلال زر الحجز.</p>
                    @else
                        <strong style="color: #ef4444;">لست مؤهلاً للتبرع حالياً ❌</strong>
                        <p>يجب أن تنتظر <strong>{{ auth()->user()->daysUntilEligible() }} يوماً</strong> حتى تتمكن من التبرع مجدداً حفاظاً على صحتك.</p>
                    @endif
                </div>

                <div class="quick-actions">
                    <a href="/request" class="action-btn" title="إنشاء طلب استغاثة لدم">طلب دم جديد</a>
                    @if(auth()->user()->isEligibleToDonate())
                        <a href="/donate" class="action-btn" title="حجز موعد لتبرع جديد">حجز موعد تبرع</a>
                    @else
                        <a href="#" class="action-btn" style="background:#ccc; cursor:not-allowed;" onclick="alert('يجب انتظار المدة القانونية للتبرع (90 يوم)'); return false;" title="غير مؤهل حالياً لحجز موعد">حجز موعد تبرع</a>
                    @endif
                    <a href="/locations" class="action-btn" title="تصفح المراكز المتاحة للتبرع">أماكن التبرع</a>
                </div>
            </div>

            <div class="panel">
                <h2>آخر طلباتي</h2>

                <table>
                    <thead>
                        <tr>
                            <th>الفصيلة</th>
                            <th>المستشفى</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myRequests as $req)
                        <tr>
                            <td dir="ltr"><strong>{{ $req->required_type }}</strong></td>
                            <td>{{ $req->hospital }}</td>
                            <td>
                                @if($req->status == 'pending')
                                    <span class="status pending">قيد المعالجة</span>
                                @elseif($req->status == 'provided')
                                    <span class="status done">تم التوفير</span>
                                @else
                                    <span class="status" style="background:#fee2e2; color:#ef4444;">ملغي</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">لم تقم بتقديم أي طلبات دم بعد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <h2>مواعيد التبرع</h2>

                <table>
                    <thead>
                        <tr>
                            <th>المركز</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($myAppointments ?? []) as $appt)
                        <tr>
                            <td>{{ $appt->donationCenter->name ?? 'غير محدد' }}</td>
                            <td>{{ \Carbon\Carbon::parse($appt->appointment_date)->format('Y-m-d H:i') }}</td>
                            <td>
                                @if($appt->status == 'pending')
                                    <span class="status pending">قيد الانتظار</span>
                                @elseif($appt->status == 'completed')
                                    <span class="status done">تم التبرع</span>
                                @else
                                    <span class="status" style="background:#fee2e2; color:#ef4444;">ملغي</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center;">لا توجد مواعيد تبرع محجوزة بعد. <a href="/donate" style="color:var(--primary-red); font-weight:bold;">احجز موعداً الآن</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <aside>
            <div class="panel">
                <h2>الإشعارات</h2>

                @forelse(auth()->user()->notifications->take(5) as $notification)
                <div class="notification" style="{{ $notification->read_at ? 'opacity: 0.7;' : 'border-right: 4px solid var(--primary-red);' }}">
                    <strong>{{ $notification->data['message'] ?? 'إشعار جديد' }}</strong>
                    <p style="font-size: 0.85rem; color: #777; margin-top: 5px;">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @empty
                <div class="notification" style="text-align: center; color: #888;">
                    <p>لا توجد إشعارات حالياً.</p>
                </div>
                @endforelse

                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="/notifications/mark-all-read" method="POST" style="margin-top: 15px; text-align: center;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: var(--primary-red); font-weight: bold; cursor: pointer; text-decoration: underline;">تحديد الكل كمقروء</button>
                    </form>
                @endif
            </div>
        </aside>

    </section>

</main>

<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>