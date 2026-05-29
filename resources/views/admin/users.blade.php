<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المستخدمين | لوحة تحكم الأدمن</title>
    <!-- الروابط الخارجية -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <style>
        .role-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .role-admin { background-color: #ffe4e6; color: #e11d48; }
        .role-user { background-color: #e0f2fe; color: #0284c7; }
        .blood-badge {
            background-color: #f1f5f9;
            color: #334155;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: bold;
            border: 1px solid #cbd5e1;
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
            <a href="/admin/users" class="active"><i class="fas fa-users"></i> إدارة المستخدمين</a>
            <a href="/admin/requests"><i class="fas fa-droplet"></i> طلبات الدم</a>
            <a href="/admin/centers"><i class="fas fa-hospital"></i> مراكز التبرع</a>
        </nav>
        <form action="/logout" method="POST" class="logout-form">
            @csrf 
            <button type="submit"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</button>
        </form>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <header class="topbar">
            <h1>إدارة المستخدمين</h1>
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

        <!-- قسم عرض المستخدمين -->
        <section class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-users"></i> قائمة المسجلين بالمنصة</h2>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>الاسم الكامل</th>
                            <th>البريد الإلكتروني</th>
                            <th>رقم الهاتف</th>
                            <th>المدينة</th>
                            <th>فصيلة الدم</th>
                            <th>الدور (الصلاحية)</th>
                            <th>تاريخ التسجيل</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'غير محدد' }}</td>
                            <td>{{ $user->city ?? 'غير محدد' }}</td>
                            <td>
                                @if($user->blood_type)
                                    <span class="blood-badge" dir="ltr">{{ $user->blood_type }}</span>
                                @else
                                    <span style="color:#999;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="role-badge role-admin">مشرف (Admin)</span>
                                @else
                                    <span class="role-badge role-user">متبرع (User)</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="actions">
                                @if($user->id === Auth::id())
                                    <span style="color:#999;">حسابك الحالي</span>
                                @else
                                    <div style="display:flex; gap:8px; align-items:center; justify-content:flex-start;">
                                        <!-- تبديل الصلاحية (ترقية/إنزال) -->
                                        <form action="{{ route('admin.users.role', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('PUT')
                                            <button type="submit" title="تغيير صلاحية المستخدم"
                                                style="background:#1e88e5; color:white; border:none; padding:6px 10px; border-radius:5px; cursor:pointer; white-space:nowrap;">
                                                {{ $user->role === 'admin' ? 'إنزال لمتبرع' : 'ترقية لمشرف' }}
                                            </button>
                                        </form>
                                        <!-- حذف المستخدم -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="delete" title="حذف المستخدم"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟ سيتم حذف طلباته ومواعيده أيضاً.')"
                                                style="background:#e11d48; color:white; border:none; padding:6px 10px; border-radius:5px; cursor:pointer;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
</body>
</html>
