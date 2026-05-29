# نشر LifeDrop على Railway 🚀

## الخطوات السريعة:

### 1️⃣ إنشاء حساب Railway (مجاني)
- اذهب إلى https://railway.app
- اضغط "Sign Up with GitHub" أو "Sign Up with Email"
- أتمم التسجيل

### 2️⃣ إنشاء GitHub Repository (أو استخدام Railway مباشرة)

#### الخيار أ: عبر GitHub (الأسهل)
```bash
git init
git add .
git commit -m "Initial commit: LifeDrop blood donation app"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/lifedrop.git
git push -u origin main
```

#### الخيار ب: النشر المباشر عبر Railway CLI
```bash
railway login
railway init
railway up
```

### 3️⃣ إذا استخدمت GitHub:
1. اذهب إلى https://railway.app
2. اضغط "New Project"
3. اختر "Deploy from GitHub"
4. اختر repo "lifedrop"
5. اضغط "Deploy"

### 4️⃣ إضافة قاعدة البيانات (MySQL)
1. بعد عمل Deploy الأول، اذهب إلى project settings
2. اضغط "Add Service"
3. اختر "MySQL"
4. اختر الإصدار الأحدث (8.0+)
5. Railway ستربط البيانات تلقائياً

### 5️⃣ تشغيل Migrations
بعد ربط Database:
1. اذهب إلى "Deployments"
2. اضغط على الـ service الأساسي
3. اضغط "View Logs"
4. بحث عن أي أخطاء

أو عبر Railway CLI:
```bash
railway exec php artisan migrate --force
railway exec php artisan db:seed --force
```

---

## الملفات المعدة:
- ✅ `Procfile` — يخبر Railway كيفية تشغيل التطبيق
- ✅ `runtime.txt` — يحدد إصدار PHP (8.4.20)
- ✅ `.env.production` — متغيرات الإنتاج

---

## المتغيرات البيئية في Railway:
Railway توفر تلقائياً:
- `DATABASE_HOST` ← DB_HOST
- `DATABASE_PORT` ← DB_PORT
- `DATABASE_NAME` ← DB_DATABASE
- `DATABASE_USER` ← DB_USERNAME
- `DATABASE_PASSWORD` ← DB_PASSWORD
- `RAILWAY_PUBLIC_DOMAIN` ← APP_URL

---

## بعد النشر:
✅ الرابط النهائي يكون مثل: `https://lifedrop-production.up.railway.app`

---

## حل المشاكل:

### خطأ "Command not found"
→ تأكد أن `railway.json` موجود وصحيح

### خطأ Database Connection
→ تأكد أن MySQL service موضوفة وأن البيئات متطابقة

### خطأ "APP_KEY not set"
→ Railway توجد APP_KEY تلقائياً (موجودة في .env بالفعل)

---

**ملاحظات:**
- الـ free tier كافي تماماً
- الـ cache، session، queue تستخدم database (معدّة سلفاً)
- لا حاجة لـ Redis أو Memcached في الفترة الحالية
