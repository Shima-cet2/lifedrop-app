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
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h2>{{ $stats['users_count'] ?? 0 }}</h2>
                    <p>إجمالي المستخدمين</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-droplet"></i></div>
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

        <!-- ===== RECENT REQUESTS ===== -->
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
                            <th>رقم التتبع</th>
                            <th>المستخدم</th>
                            <th>الفصيلة</th>
                            <th>الحالة</th>
                            <th>الأهمية</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bloodRequests as $req)
                        <tr>
                            <td><code style="background: #f3f4f6; padding: 4px 8px; border-radius: 5px; font-weight: 600;">{{ $req->tracking_id }}</code></td>
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
                            <td colspan="5" style="text-align: center; padding: 40px; color: #718096;">
                                <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                لا توجد طلبات دم حالياً
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ===== DONATION CENTERS ===== -->
        <section class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-clinic-medical"></i> مراكز التبرع المتوفرة</h2>
                <button class="add-btn" onclick="openModal('addModal')" title="إضافة مركز جديد">
                    <i class="fas fa-plus"></i> إضافة
                </button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>اسم المركز</th>
                            <th>المدينة</th>
                            <th>الهاتف</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donationCenters as $center)
                        <tr>
                            <td><strong>{{ $center->name }}</strong></td>
                            <td>{{ $center->city }}</td>
                            <td dir="ltr">{{ $center->phone ?? 'N/A' }}</td>
                            <td class="actions">
                                <button onclick="openEditModal({{ json_encode($center) }})" style="background: #e0f2fe; color: #0284c7; padding: 8px 14px;" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('centers.destroy', $center->id) }}" method="POST" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="delete" onclick="return confirm('هل تؤكد حذف هذا المركز؟')" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: #718096;">
                                لا توجد مراكز مسجلة
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>

<!-- ===== MODALS ===== -->
@include('admin.modals')

<script src="{{ asset('js/admin-scripts.js') }}"></script>
<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>