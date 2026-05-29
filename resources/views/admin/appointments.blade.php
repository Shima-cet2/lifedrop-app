<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة المواعيد | لوحة تحكم الأدمن</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
</head>
<body>
<div class="admin-layout">
    <!-- القائمة الجانبية -->
    <aside class="sidebar">
        <div class="logo"><i class="fas fa-tint"></i> <span>LifeDrop</span></div>
        <nav>
            <a href="/admin"><i class="fas fa-chart-line"></i> لوحة التحكم</a>
            <a href="/admin/users"><i class="fas fa-users"></i> إدارة المستخدمين</a>
            <a href="/admin/requests"><i class="fas fa-droplet"></i> طلبات الدم</a>
            <a href="/admin/centers"><i class="fas fa-hospital"></i> مراكز التبرع</a>
            <a href="/admin/appointments" class="active"><i class="fas fa-calendar"></i> مواعيد التبرع</a>
        </nav>
        <form action="/logout" method="POST" class="logout-form">
            @csrf
            <button type="submit"><i class="fas fa-sign-out-alt"></i> تسجيل خروج</button>
        </form>
    </aside>

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <header class="topbar">
            <h1>إدارة مواعيد التبرع</h1>
            <div class="admin-info">مرحباً، {{ Auth::user()->name }}</div>
        </header>

        <!-- رسائل النجاح / الخطأ -->
        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:15px; border-radius:8px; margin-bottom:20px;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:8px; margin-bottom:20px;">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- إحصائيات سريعة -->
        <section class="stats-grid" style="margin-bottom: 30px;">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h2>{{ $appointments->count() }}</h2>
                    <p>إجمالي المواعيد</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-info">
                    <h2>{{ $appointments->where('status', 'pending')->count() }}</h2>
                    <p>قيد الانتظار</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="stat-info">
                    <h2>{{ $appointments->where('status', 'completed')->count() }}</h2>
                    <p>تم التبرع</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                <div class="stat-info">
                    <h2>{{ $appointments->where('status', 'cancelled')->count() }}</h2>
                    <p>ملغاة</p>
                </div>
            </div>
        </section>

        <!-- المواعيد مجمعة حسب المركز -->
        <section class="content-section">
            <div class="section-header">
                <h2><i class="fas fa-list"></i> المواعيد حسب مركز التبرع</h2>
            </div>

            @forelse($appointmentsByCenter as $centerId => $centerAppointments)
                @php
                    $center = $centerAppointments->first()->donationCenter;
                @endphp
                <div style="margin-bottom: 40px; background: #f9f9f9; padding: 20px; border-radius: 8px; border-right: 4px solid #cc1b1b;">
                    <h3 style="margin-top: 0; color: #cc1b1b; font-size: 1.3rem;">
                        <i class="fas fa-hospital"></i> {{ $center->name }}
                    </h3>
                    <p style="color: #666; margin: 5px 0;">
                        📍 {{ $center->city }} - {{ $center->address }}&nbsp;&nbsp;|&nbsp;&nbsp;
                        📞 {{ $center->phone }}
                    </p>

                    <div class="table-container" style="margin-top: 15px;">
                        <table>
                            <thead>
                                <tr>
                                    <th>اسم المتبرع</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>تاريخ الموعد</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($centerAppointments as $apt)
                                <tr>
                                    <td><strong>{{ $apt->user->name }}</strong></td>
                                    <td dir="ltr">{{ $apt->user->email }}</td>
                                    <td>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('Y-m-d') }}</td>
                                    <td>
                                        @if($apt->status == 'pending')
                                            <span style="background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;">⏳ قيد الانتظار</span>
                                        @elseif($apt->status == 'completed')
                                            <span style="background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;">✅ تم التبرع</span>
                                        @elseif($apt->status == 'cancelled')
                                            <span style="background: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 5px; font-size: 0.9rem;">❌ ملغي</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                            @if($apt->status != 'completed')
                                            <form action="{{ route('admin.appointments.status', $apt->id) }}" method="POST" style="display: inline;">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" title="تأكيد التبرع" style="background: #28a745; color: white; border: none; padding: 6px 10px; border-radius: 5px; cursor: pointer; font-size: 0.85rem;">
                                                    <i class="fas fa-check"></i> تأكيد
                                                </button>
                                            </form>
                                            @endif

                                            @if($apt->status != 'cancelled')
                                            <form action="{{ route('admin.appointments.status', $apt->id) }}" method="POST" style="display: inline;">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" title="إلغاء الموعد" style="background: #ffc107; color: #333; border: none; padding: 6px 10px; border-radius: 5px; cursor: pointer; font-size: 0.85rem;">
                                                    <i class="fas fa-ban"></i> إلغاء
                                                </button>
                                            </form>
                                            @endif

                                            <form action="{{ route('admin.appointments.destroy', $apt->id) }}" method="POST" style="display: inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="حذف الموعد" onclick="return confirm('هل أنت متأكد من حذف هذا الموعد؟')" style="background: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 5px; cursor: pointer; font-size: 0.85rem;">
                                                    <i class="fas fa-trash"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 15px; display: block;"></i>
                <p style="color: #666; font-size: 1.1rem;">لا توجد مواعيد تبرع مسجلة حالياً</p>
            </div>
            @endforelse
        </section>
    </main>
</div>

<script src="{{ asset('js/alerts.js') }}"></script>
</body>
</html>
