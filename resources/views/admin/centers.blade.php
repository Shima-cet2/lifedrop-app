<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة مراكز التبرع | لوحة تحكم الأدمن</title>
    <!-- الروابط الخارجية -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <style>
        .city-badge {
            background-color: #e3f2fd;
            color: #1565c0;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="admin-layout">
    <!-- القائمة الجانبية -->
    <aside class="sidebar">
        <div class="logo"><i class="fas fa-tint"></i> <span>LifeDrop</span></div>
        <nav>
            <a href="/admin"><i class="fas fa-chart-line"></i> لوحة التحكم</a>
            <a href="/admin/appointments"><i class="fas fa-calendar"></i> مواعيد التبرع</a>
            <a href="/admin/users"><i class="fas fa-users"></i> إدارة المستخدمين</a>
            <a href="/admin/requests"><i class="fas fa-droplet"></i> طلبات الدم</a>
            <a href="/admin/centers" class="active"><i class="fas fa-hospital"></i> مراكز التبرع</a>
        </nav>
        <form action="/logout" method="POST" class="logout-form">
            @csrf
            <button type="submit"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</button>
        </form>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <header class="topbar">
            <h1>إدارة مراكز التبرع</h1>
            <div class="admin-info">مرحباً، {{ Auth::user()->name }}</div>
        </header>

        <!-- رسائل النجاح / الخطأ -->
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:8px; margin-bottom:20px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- قسم عرض مراكز التبرع -->
        <section class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-hospital"></i> قائمة مراكز التبرع</h2>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>اسم المركز</th>
                            <th>المدينة</th>
                            <th>العنوان</th>
                            <th>رقم الهاتف</th>
                            <th>تاريخ الإضافة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donationCenters as $center)
                        <tr>
                            <td><strong>{{ $center->name }}</strong></td>
                            <td><span class="city-badge">{{ $center->city }}</span></td>
                            <td>{{ $center->address ?? 'غير محدد' }}</td>
                            <td dir="ltr">{{ $center->phone }}</td>
                            <td>{{ $center->created_at->format('Y-m-d') }}</td>
                            <td class="actions">
                                <div style="display:flex; gap:8px; align-items:center; justify-content:flex-start;">
                                    <!-- تعديل -->
                                    <button class="edit-btn" title="تعديل المركز"
                                        style="background:#1e88e5; color:white; border:none; padding:6px 10px; border-radius:5px; cursor:pointer;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- حذف -->
                                    <form action="{{ route('centers.destroy', $center->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="حذف المركز"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المركز؟')"
                                            style="background:#e11d48; color:white; border:none; padding:6px 10px; border-radius:5px; cursor:pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:30px;">
                                لا توجد مراكز تبرع مسجلة حالياً
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 30px;">
                <h3><i class="fas fa-plus-circle"></i> إضافة مركز تبرع جديد</h3>
                <form action="{{ route('centers.store') }}" method="POST" style="background:#f5f5f5; padding:20px; border-radius:8px; max-width:500px;">
                    @csrf
                    <div class="form-group" style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:bold;">اسم المركز</label>
                        <input type="text" name="name" required placeholder="مثال: مركز نبرع الرئيسي"
                            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-family:inherit;">
                    </div>
                    <div class="form-group" style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:bold;">المدينة</label>
                        <input type="text" name="city" required placeholder="مثال: طرابلس"
                            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-family:inherit;">
                    </div>
                    <div class="form-group" style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:bold;">العنوان</label>
                        <input type="text" name="address" placeholder="مثال: شارع الجمهورية"
                            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-family:inherit;">
                    </div>
                    <div class="form-group" style="margin-bottom:15px;">
                        <label style="display:block; margin-bottom:5px; font-weight:bold;">رقم الهاتف</label>
                        <input type="tel" name="phone" required placeholder="مثال: 0912345678"
                            style="width:100%; padding:10px; border:1px solid #ddd; border-radius:5px; font-family:inherit;">
                    </div>
                    <button type="submit" style="width:100%; padding:12px; background:#cc1b1b; color:white; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">
                        <i class="fas fa-plus"></i> إضافة المركز
                    </button>
                </form>
            </div>
        </section>
    </main>
</div>
</body>
</html>
