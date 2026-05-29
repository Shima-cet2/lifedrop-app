<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلبات الدم | لوحة تحكم الأدمن</title>
    <!-- الروابط الخارجية -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>

@if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="admin-layout">
    <!-- القائمة الجانبية -->
    <aside class="sidebar">
        <div class="logo"><i class="fas fa-tint"></i> <span>LifeDrop</span></div>
        <nav>
            <a href="/admin" title="الرئيسية والإحصائيات"><i class="fas fa-chart-line"></i> لوحة التحكم</a>
            <a href="/admin/users" title="عرض وإدارة كافة المستخدمين"><i class="fas fa-users"></i> إدارة المستخدمين</a>
            <a href="/admin/requests" class="active" title="طلبات التبرع بالدم"><i class="fas fa-droplet"></i> طلبات الدم</a>
            <a href="/admin/centers" title="مراكز ومستشفيات التبرع"><i class="fas fa-hospital"></i> مراكز التبرع</a>
        </nav>
        <form action="/logout" method="POST" class="logout-form">
            @csrf 
            <button type="submit" title="تسجيل الخروج من النظام"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</button>
        </form>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <header class="topbar">
            <h1>إدارة طلبات الدم</h1>
            <div class="admin-info">مرحباً، {{ Auth::user()->name }}</div>
        </header>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <section class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-notes-medical"></i> قائمة طلبات نقل الدم</h2>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>رقم التتبع</th>
                            <th>المستخدم (مقدم الطلب)</th>
                            <th>الفصيلة المطلوبة</th>
                            <th>المدينة والمستشفى</th>
                            <th>الحالة</th>
                            <th>مستوى الأهمية</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bloodRequests as $req)
                        <tr>
                            <td style="font-weight: bold; color: #555;">{{ $req->tracking_id }}</td>
                            <td>{{ $req->user->name ?? 'غير معروف' }}</td>
                            <td dir="ltr"><strong>{{ $req->required_type }}</strong></td>
                            <td>{{ $req->city }} - {{ $req->hospital }}</td>
                            <td>
                                <!-- نموذج تغيير الحالة -->
                                <form class="ajax-update-form" action="{{ route('admin.requests.update', $req->id) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" style="padding: 5px; border-radius: 5px; border: 1px solid #ccc;">
                                        <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                        <option value="provided" {{ $req->status == 'provided' ? 'selected' : '' }}>تم التوفير</option>
                                        <option value="cancelled" {{ $req->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                    </select>
                                    <button type="submit" style="background:#1e88e5; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">تحديث</button>
                                </form>
                            </td>
                            <td>
                                @if($req->is_urgent)
                                    <span class="status urgent">🚨 عاجل جداً</span>
                                @else
                                    <span class="status pending">عادي</span>
                                @endif
                            </td>
                            <td class="actions">
                                <form action="{{ route('admin.requests.destroy', $req->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="delete" onclick="return confirm('هل أنت متأكد من الحذف؟')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align: center;">لا توجد طلبات دم في الوقت الحالي.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
<!-- Notification Toast -->
<div id="toast" style="display:none; position:fixed; bottom:20px; right:20px; background:#4CAF50; color:white; padding:15px; border-radius:5px; box-shadow:0 4px 6px rgba(0,0,0,0.1); z-index:1000;">
    تم التحديث بنجاح!
</div>

<script>
    document.querySelectorAll('.ajax-update-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // منع إعادة تحميل الصفحة
            
            let formData = new FormData(this);
            let actionUrl = this.getAttribute('action');
            let btn = this.querySelector('button[type="submit"]');
            let originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            fetch(actionUrl, {
                method: 'POST', // Laravel uses POST with _method=PUT
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // إظهار إشعار مؤقت
                    let toast = document.getElementById('toast');
                    toast.innerText = data.message;
                    toast.style.display = 'block';
                    setTimeout(() => { toast.style.display = 'none'; }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء التحديث');
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    });
</script>
</body>
</html>
