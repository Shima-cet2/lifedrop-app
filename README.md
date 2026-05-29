# 🩸 LifeDrop — منصة التبرع بالدم

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-red?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.4-blue?style=flat-square&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT">
</p>

---

## 📋 نبذة عن المشروع

**LifeDrop** هو تطبيق ويب متكامل لإدارة منظومة التبرع بالدم، مبني بإطار عمل **Laravel**. يهدف إلى ربط المتبرعين بالدم مع مراكز التبرع والمحتاجين، مع توفير لوحة تحكم متكاملة للمشرفين.

### ✨ الميزات الرئيسية

| الميزة | الوصف |
|--------|-------|
| 🔐 نظام المصادقة | تسجيل دخول / إنشاء حساب بفصل الصلاحيات (Admin / User) |
| 📋 طلبات الدم | تقديم طلبات الدم مع رقم تتبع فريد وحالة معالجة |
| 📅 حجز المواعيد | حجز موعد تبرع في أقرب مركز مع إشعار إلكتروني |
| 🏥 مراكز التبرع | عرض مراكز التبرع على الخريطة مع الفصائل المتاحة |
| 📊 لوحة التحكم | داش بورد تفاعلية بالرسوم البيانية وإحصائيات حية |
| 📧 الإشعارات | إشعارات بريد إلكتروني عند تأكيد الموعد (Mailtrap) |

---

## 🛠️ متطلبات التشغيل

- **PHP** >= 8.2
- **Composer** >= 2.x
- **MySQL** >= 8.0
- **Node.js** >= 18.x (لبناء الأصول)

---

## 🚀 خطوات التثبيت

### 1. استخراج الملفات
```bash
unzip lifedrop-submission.zip -d lifedrop
cd lifedrop
```

### 2. تثبيت التبعيات
```bash
composer install
npm install && npm run build
```

### 3. إعداد البيئة
```bash
cp .env.example .env
php artisan key:generate
```

### 4. ضبط قاعدة البيانات في ملف `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lifedrop
DB_USERNAME=root
DB_PASSWORD=
```

### 5. إنشاء قاعدة البيانات وتعبئتها
```bash
php artisan migrate:fresh --seed
```

### 6. تشغيل التطبيق
```bash
php artisan serve
```
ثم افتح المتصفح على: **http://localhost:8000**

---

## 🔑 بيانات الدخول التجريبية

| الدور | البريد الإلكتروني | كلمة المرور |
|-------|-------------------|-------------|
| 👤 مشرف (Admin) | admin@lifedrop.com | Admin@1234 |
| 💉 متبرع (User) | ahmed@lifedrop.com | User@1234 |

---

## 🗂️ هيكل المشروع

```
lifedrop/
├── app/
│   ├── Http/Controllers/     # كنترولرز التطبيق
│   └── Models/               # موديلز Eloquent
├── database/
│   ├── migrations/           # هيكل قاعدة البيانات
│   └── seeders/              # بيانات تجريبية واقعية
├── public/
│   ├── css/                  # ملفات التنسيق
│   └── js/                   # ملفات الجافاسكريبت
├── resources/views/
│   ├── admin/                # واجهات لوحة التحكم
│   └── ...                   # واجهات المستخدم
└── routes/web.php            # مسارات التطبيق
```

---

## 📊 قاعدة البيانات

| الجدول | المحتوى |
|--------|---------|
| `users` | المستخدمون (متبرعون + مشرفون) |
| `donation_centers` | مراكز التبرع بالدم |
| `blood_requests` | طلبات الدم مع رقم التتبع |
| `appointments` | مواعيد التبرع |
| `notifications` | إشعارات النظام |

---

## 👨‍💻 تقنيات المستخدمة

- **Backend:** Laravel 13, PHP 8.4, Eloquent ORM
- **Frontend:** Blade Templates, Tailwind-inspired CSS, Font Awesome 6
- **Charts:** Chart.js 4.4
- **Database:** MySQL / MariaDB
- **Email:** Mailtrap (SMTP)
- **Fonts:** Tajawal (Arabic RTL)

---

## 🔗 الـ Repository

**GitHub:** [github.com/Shima-cet2/lifedrop-app](https://github.com/Shima-cet2/lifedrop-app)
