<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم | LifeDrop</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/alerts.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        /* ===== لوحة الرسوم البيانية ===== */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }
        .chart-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
            border: 1px solid #f0f0f0;
        }
        .chart-card h3 {
            font-size: 1.05rem;
            color: #1f2937;
            margin: 0 0 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .chart-card h3 i { color: #cc1b1b; }
        .chart-wrapper {
            position: relative;
            height: 260px;
        }
        .chart-wrapper.tall { height: 300px; }
        .tables-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }
        @media (max-width: 1024px) {
            .tables-grid { grid-template-columns: 1fr; }
        }
        .urgent-banner {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fca5a5;
            border-radius: 14px;
            padding: 18px 22px;
            margin-bottom: 26px;
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .urgent-banner .pulse {
            font-size: 1.8rem;
            color: #dc2626;
            animation: pulseBeat 1.2s infinite;
        }
        @keyframes pulseBeat {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.18); opacity: 0.7; }
        }
        .urgent-banner-text strong { color: #991b1b; font-size: 1.15rem; }
        .urgent-banner-text p { margin: 2px 0 0; color: #7f1d1d; font-size: 0.9rem; }
        .mini-empty {
            text-align: center;
            padding: 30px;
            color: #9ca3af;
        }
        .mini-empty i { font-size: 1.8rem; display: block; margin-bottom: 8px; }
    </style>
</head>
<body>

@if($errors->any())
    <div class="admin-alert alert-error" style="margin: 20px 40px; animation: slideInDown 0.5s ease-out;">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>⚠️ حدثت أخطاء:</strong>
            <ul style="margin: 8px 0 0; padding-right: 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" onclick="this.parentElement.style.display='none';" style="background:none; border:none; color:inherit; cursor:pointer; font-size:1.3rem;">×</button>
    </div>
@endif

<div class="admin-layout">
    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="logo">
            <i class="fas fa-droplet"></i>
            <span>LifeDrop</span>
        </div>
        <nav>
            <a href="/admin" class="active" title="لوحة التحكم الرئيسية">
                <i class="fas fa-chart-pie"></i>
                لوحة التحكم
            </a>
            <a href="/admin/appointments" title="إدارة مواعيد التبرع">
                <i class="fas fa-calendar"></i>
                المواعيد
            </a>
            <a href="/admin/users" title="إدارة حسابات المستخدمين">
                <i class="fas fa-users"></i>
                المستخدمون
            </a>
            <a href="/admin/requests" title="إدارة طلبات الدم">
                <i class="fas fa-blood-droplet"></i>
                الطلبات
            </a>
            <a href="/admin/centers" title="إدارة مراكز التبرع">
                <i class="fas fa-hospital"></i>
                المراكز
            </a>
        </nav>
        <form action="/logout" method="POST" class="logout-form">
            @csrf
            <button type="submit" title="خروج آمن من النظام">
                <i class="fas fa-sign-out-alt"></i>
                تسجيل خروج
            </button>
        </form>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        <!-- Top Bar -->
        <header class="topbar">
            <div>
                <h1>🏥 لوحة التحكم</h1>
            </div>
            <div class="admin-info">
                👤 مرحباً بك، <strong>{{ Auth::user()->name }}</strong>
            </div>
        </header>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #10b981; font-weight: 500;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- ===== URGENT BANNER ===== -->
        @if(($stats['urgent_count'] ?? 0) > 0)
        <div class="urgent-banner">
            <i class="fas fa-triangle-exclamation pulse"></i>
            <div class="urgent-banner-text">
                <strong>{{ $stats['urgent_count'] }} طلب دم عاجل بانتظار المعالجة!</strong>
                <p>توجد طلبات عاجلة قيد الانتظار تحتاج إلى متابعة فورية. <a href="/admin/requests" style="color:#991b1b; font-weight:700;">عرض الطلبات ←</a></p>
            </div>
        </div>
        @endif

        <!-- ===== STATS CARDS ===== -->
        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-exclamation-circle"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['urgent_count'] ?? 0 }}</h2>
                    <p>طلبات عاجلة</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-droplet"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['requests_count'] ?? 0 }}</h2>
                    <p>إجمالي طلبات الدم</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['appointments_count'] ?? 0 }}</h2>
                    <p>إجمالي المواعيد</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['users_count'] ?? 0 }}</h2>
                    <p>إجمالي المستخدمين</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['donors_count'] ?? 0 }}</h2>
                    <p>المتبرعون النشطون</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hospital"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['centers_count'] ?? 0 }}</h2>
                    <p>مراكز التبرع</p>
                </div>
            </div>
        </section>

        <!-- ===== CHARTS ===== -->
        <section class="charts-grid">
            <div class="chart-card">
                <h3><i class="fas fa-chart-line"></i> طلبات الدم خلال آخر 6 أشهر</h3>
                <div class="chart-wrapper tall">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3><i class="fas fa-droplet"></i> توزيع الفصائل المطلوبة</h3>
                <div class="chart-wrapper tall">
                    <canvas id="bloodTypeChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3><i class="fas fa-clipboard-list"></i> حالة طلبات الدم</h3>
                <div class="chart-wrapper">
                    <canvas id="requestStatusChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3><i class="fas fa-calendar-check"></i> حالة المواعيد</h3>
                <div class="chart-wrapper">
                    <canvas id="appointmentStatusChart"></canvas>
                </div>
            </div>

            <div class="chart-card">
                <h3><i class="fas fa-city"></i> أكثر المدن طلباً للدم</h3>
                <div class="chart-wrapper">
                    <canvas id="citiesChart"></canvas>
                </div>
            </div>
        </section>

        <!-- ===== TABLES ===== -->
        <div class="tables-grid">
            <!-- RECENT REQUESTS -->
            <section class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-receipt"></i> آخر الطلبات</h2>
                    <a href="/admin/requests" style="color: #cc1b1b; text-decoration: none; font-weight: 600;">
                        عرض الكل <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>المستخدم</th>
                                <th>الفصيلة</th>
                                <th>الحالة</th>
                                <th>الأهمية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bloodRequests as $req)
                            <tr>
                                <td><strong>{{ $req->user->name ?? 'غير معروف' }}</strong></td>
                                <td dir="ltr" style="font-weight: bold;">{{ $req->required_type }}</td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="status pending">⏳ قيد المعالجة</span>
                                    @elseif($req->status == 'provided')
                                        <span class="status done">✅ تم التوفير</span>
                                    @else
                                        <span class="status" style="background: #fee2e2; color: #991b1b;">❌ ملغي</span>
                                    @endif
                                </td>
                                <td>
                                    @if($req->is_urgent)
                                        <span class="status urgent">🚨 عاجل</span>
                                    @else
                                        <span style="color: #718096; font-size: 0.9rem;">عادي</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="mini-empty">
                                    <i class="fas fa-inbox"></i>
                                    لا توجد طلبات دم حالياً
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- LATEST APPOINTMENTS -->
            <section class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-calendar-check"></i> آخر المواعيد</h2>
                    <a href="/admin/appointments" style="color: #cc1b1b; text-decoration: none; font-weight: 600;">
                        عرض الكل <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>المتبرع</th>
                                <th>المركز</th>
                                <th>التاريخ</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestAppointments as $apt)
                            <tr>
                                <td><strong>{{ $apt->user->name ?? 'غير معروف' }}</strong></td>
                                <td>{{ $apt->donationCenter->name ?? 'غير محدد' }}</td>
                                <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('Y-m-d') }}</td>
                                <td>
                                    @if($apt->status == 'pending')
                                        <span class="status pending">⏳ قيد الانتظار</span>
                                    @elseif($apt->status == 'completed')
                                        <span class="status done">✅ تم التبرع</span>
                                    @else
                                        <span class="status" style="background: #fee2e2; color: #991b1b;">❌ ملغي</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="mini-empty">
                                    <i class="fas fa-calendar-times"></i>
                                    لا توجد مواعيد تبرع حالياً
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- LATEST USERS -->
            <section class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-user-plus"></i> أحدث المستخدمين</h2>
                    <a href="/admin/users" style="color: #cc1b1b; text-decoration: none; font-weight: 600;">
                        عرض الكل <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>المدينة</th>
                                <th>الفصيلة</th>
                                <th>الصلاحية</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestUsers as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->city ?? '—' }}</td>
                                <td dir="ltr" style="font-weight: bold;">{{ $user->blood_type ?? '—' }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="status urgent">مشرف</span>
                                    @else
                                        <span class="status done">متبرع</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="mini-empty">
                                    <i class="fas fa-user-slash"></i>
                                    لا يوجد مستخدمون
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- URGENT REQUESTS -->
            <section class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-triangle-exclamation" style="color:#dc2626;"></i> طلبات عاجلة قيد الانتظار</h2>
                    <a href="/admin/requests" style="color: #cc1b1b; text-decoration: none; font-weight: 600;">
                        عرض الكل <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>المستخدم</th>
                                <th>الفصيلة</th>
                                <th>المدينة</th>
                                <th>المستشفى</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($urgentRequests as $req)
                            <tr>
                                <td><strong>{{ $req->user->name ?? 'غير معروف' }}</strong></td>
                                <td dir="ltr" style="font-weight: bold; color:#dc2626;">{{ $req->required_type }}</td>
                                <td>{{ $req->city ?? '—' }}</td>
                                <td>{{ $req->hospital ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="mini-empty">
                                    <i class="fas fa-circle-check" style="color:#10b981;"></i>
                                    لا توجد طلبات عاجلة معلّقة 🎉
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</div>

<script src="{{ asset('js/admin-scripts.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') return;

    Chart.defaults.font.family = "'Tajawal', sans-serif";
    Chart.defaults.color = '#6b7280';

    const palette = ['#cc1b1b', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'];

    // ===== 1. Monthly trend (line) =====
    const trendLabels = @json(array_keys($monthlyTrend));
    const trendValues = @json(array_values($monthlyTrend));
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: trendLabels,
            datasets: [{
                label: 'عدد الطلبات',
                data: trendValues,
                borderColor: '#cc1b1b',
                backgroundColor: 'rgba(204,27,27,0.12)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#cc1b1b',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    // ===== 2. Blood type distribution (doughnut) =====
    const btLabels = @json(array_keys($bloodTypeData));
    const btValues = @json(array_values($bloodTypeData));
    new Chart(document.getElementById('bloodTypeChart'), {
        type: 'doughnut',
        data: {
            labels: btLabels.length ? btLabels : ['لا توجد بيانات'],
            datasets: [{
                data: btValues.length ? btValues : [1],
                backgroundColor: btValues.length ? palette : ['#e5e7eb'],
                borderWidth: 2, borderColor: '#fff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // ===== 3. Request status (pie) =====
    const rs = @json($requestStatusData);
    new Chart(document.getElementById('requestStatusChart'), {
        type: 'pie',
        data: {
            labels: ['قيد المعالجة', 'تم التوفير', 'ملغي'],
            datasets: [{
                data: [rs.pending, rs.provided, rs.cancelled],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 2, borderColor: '#fff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // ===== 4. Appointment status (pie) =====
    const as = @json($appointmentStatusData);
    new Chart(document.getElementById('appointmentStatusChart'), {
        type: 'pie',
        data: {
            labels: ['قيد الانتظار', 'تم التبرع', 'ملغي'],
            datasets: [{
                data: [as.pending, as.completed, as.cancelled],
                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 2, borderColor: '#fff'
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // ===== 5. Top cities (bar) =====
    const cityLabels = @json(array_keys($topCities));
    const cityValues = @json(array_values($topCities));
    new Chart(document.getElementById('citiesChart'), {
        type: 'bar',
        data: {
            labels: cityLabels.length ? cityLabels : ['لا توجد بيانات'],
            datasets: [{
                label: 'عدد الطلبات',
                data: cityValues.length ? cityValues : [0],
                backgroundColor: '#cc1b1b',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
});
</script>
</body>
</html>
