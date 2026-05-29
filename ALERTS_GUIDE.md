# نظام الإشعارات والتنبيهات - LifeDrop 🚨

## نظرة عامة
تم تحسين نظام الإشعارات بشكل شامل لضمان ظهور رسائل الخطأ والنجاح والتحذيرات بشكل احترافي وموحد عبر جميع صفحات التطبيق.

## ملفات النظام

### 1. **CSS** - `/public/css/alerts.css`
- ملف CSS موحد يحتوي على جميع أنماط الإشعارات
- يدعم جميع أنواع الإشعارات (success, error, warning, info)
- يتضمن animations سلسة وتأثيرات hover احترافية
- fully responsive لجميع أحجام الشاشات

### 2. **JavaScript** - `/public/js/alerts.js`
- يدير سلوك الإشعارات (إغلاق تلقائي، إغلاق يدوي، إلخ)
- يوفر دوال مساعدة لإنشاء إشعارات من التطبيق
- يدعم validation messages في النماذج
- يدعم toast notifications

---

## أنواع الإشعارات 📦

### 1. Success Alert (أخضر)
```html
<div class="alert-message alert-success">
    <i class="fas fa-check-circle"></i>
    <span>تم إنشاء الموعد بنجاح!</span>
    <button type="button">×</button>
</div>
```
- لون أخضر (#10b981)
- أيقونة علامة الاختيار ✓
- يختفي تلقائياً بعد 8 ثواني

### 2. Error Alert (أحمر)
```html
<div class="alert-message alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <span>حدث خطأ أثناء معالجة الطلب</span>
    <button type="button">×</button>
</div>
```
- لون أحمر (#ef4444)
- أيقونة تحذير ⚠️
- يمكن إغلاقه يدويًا

### 3. Warning Alert (أصفر)
```html
<div class="alert-message alert-warning">
    <i class="fas fa-exclamation-triangle"></i>
    <span>يرجى تحديث معلوماتك</span>
    <button type="button">×</button>
</div>
```
- لون أصفر (#f59e0b)
- أيقونة تحذير مثلثة △
- يحتاج تفاعل المستخدم

---

## استخدام الإشعارات في Blade Templates 📝

### Session Flash Messages (Session-based)
```blade
<!-- في Controller -->
return redirect('/dashboard')->with('success', 'تم بنجاح!');

<!-- في View -->
@if(session('success'))
    <div class="alert-message alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button">×</button>
    </div>
@endif
```

### Validation Errors
```blade
@if($errors->any())
    <div class="alert-message alert-error">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>⚠️ حدثت أخطاء:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button">×</button>
    </div>
@endif
```

---

## استخدام JavaScript Functions 🔧

### Toast Notifications (بدون إعادة تحميل الصفحة)
```javascript
// Success Toast
showToast('تم حفظ البيانات بنجاح', 'success', 4000);

// Error Toast
showToast('حدث خطأ أثناء الحفظ', 'error', 5000);

// Warning Toast
showToast('تأكد من ملء جميع الحقول', 'warning', 4000);

// Info Toast
showToast('يرجى التحقق من بريدك الإلكتروني', 'info', 4000);
```

### Form Validation Messages
```javascript
// Show error for input
const inputElement = document.getElementById('email');
showFormError(inputElement, 'البريد الإلكتروني غير صحيح');

// Clear error
clearFormError(inputElement);

// Show success
showFormSuccess(inputElement, 'البريد الإلكتروني صحيح ✓');
```

### Form Validation Helper
```javascript
// Validate form before submit
const myForm = document.getElementById('myForm');
if (validateForm(myForm)) {
    // Form is valid, submit it
    myForm.submit();
}
```

---

## المميزات الرئيسية ✨

### 1. **الإغلاق التلقائي**
- الإشعارات تختفي تلقائياً بعد 8 ثواني
- يمكن إغلاقها يدويًا بالضغط على زر X
- يمكن الضغط على ESC لإغلاق الإشعار النشط

### 2. **Animations احترافية**
- `slideInDown` عند الظهور (0.5s)
- `slideOutUp` عند الاختفاء (0.4s)
- cubic-bezier easing لتأثير سلس

### 3. **الاستجابة (Responsive)**
- تعديل تلقائي للـ mobile والـ tablet
- padding وfont-size محسّنة لكل حجم شاشة
- زر الإغلاق يبقى في مكان سهل الضغط عليه

### 4. **Accessibility**
- Support كامل لـ keyboard navigation
- أيقونات واضحة تميز نوع الإشعار
- ألوان high contrast للقراءة السهلة
- ARIA labels موجودة

### 5. **التكامل مع الصور والنصوص**
- يدعم HTML content مثل القوائم
- يدعم أيقونات Font Awesome 6.4
- يدعم النصوص الطويلة مع wrapping

---

## الأماكن المستخدمة 📍

تم تفعيل النظام في جميع صفحات التطبيق:

1. **صفحة التبرع** (`donate.blade.php`) ✅
   - رسائل الخطأ في حجز الموعد
   - تأكيد النجاح

2. **لوحة التحكم** (`admin.blade.php`) ✅
   - أخطاء العمليات الإدارية
   - تحديث البيانات

3. **لوحة المستخدم** (`dashboard.blade.php`) ✅
   - رسائل الإشعارات
   - تحديثات الحالة

4. **صفحة الطلب** (`request.blade.php`) ✅
   - تأكيد إنشاء الطلب
   - أخطاء النموذج

5. **صفحة التواصل** (`contact.blade.php`) ✅
   - تأكيد إرسال الرسالة
   - أخطاء النموذج

6. **صفحات أخرى**
   - blood-types.blade.php
   - locations.blade.php
   - login.blade.php
   - register.blade.php
   - track-request.blade.php
   - welcome.blade.php
   - index.blade.php

---

## أمثلة عملية 💻

### مثال 1: في Controller
```php
// PostController.php
public function store(Request $request) {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string'
    ]);

    $post = Post::create($validated);

    return redirect('/posts')
        ->with('success', 'تم إنشاء المنشور بنجاح!');
}
```

### مثال 2: في JavaScript (AJAX)
```javascript
fetch('/api/appointment', {
    method: 'POST',
    body: JSON.stringify(data)
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        showToast('تم حجز الموعد بنجاح', 'success');
        setTimeout(() => window.location.reload(), 2000);
    } else {
        showToast(data.error, 'error');
    }
})
.catch(err => {
    showToast('حدث خطأ غير متوقع', 'error');
});
```

### مثال 3: Form Validation
```javascript
// Real-time validation on blur
document.querySelectorAll('input[required]').forEach(input => {
    input.addEventListener('blur', function() {
        if (!this.value.trim()) {
            showFormError(this, 'هذا الحقل مطلوب');
        } else {
            clearFormError(this);
        }
    });
});
```

---

## التصميم والألوان 🎨

| نوع | اللون الأساسي | اللون النص | الرمز |
|-----|-------------|----------|------|
| Success | #10b981 (أخضر) | #065f46 | ✓ |
| Error | #ef4444 (أحمر) | #991b1b | ⚠️ |
| Warning | #f59e0b (أصفر) | #92400e | △ |
| Info | #0ea5e9 (أزرق) | #0c4a6e | ⓘ |

---

## ملاحظات مهمة ⚠️

1. **تأكد من تضمين ملفات CSS و JS**
   - كل صفحة تحتوي على `<link rel="stylesheet" href="{{ asset('css/alerts.css') }}">`
   - كل صفحة تحتوي على `<script src="{{ asset('js/alerts.js') }}"></script>`

2. **استخدام الأيقونات الصحيحة**
   - تأكد من تضمين Font Awesome CDN في `<head>`
   - الأيقونات المستخدمة متوفرة في الإصدار 6.4

3. **الإغلاق اليدوي**
   - زر X يجب أن يكون داخل الإشعار `<button type="button">×</button>`

4. **الإشعارات المتعددة**
   - يمكن عرض عدة إشعارات في نفس الوقت
   - كل إشعار له animation منفصل

---

## الدعم والمشاكل 🆘

إذا واجهت مشاكل:
1. تحقق من console errors بـ F12
2. تأكد من تحميل ملفات CSS و JS
3. تحقق من أن أيقونات Font Awesome محملة بشكل صحيح
4. استخدم `showToast()` بدلاً من `alert()` للإشعارات الحديثة

---

**آخر تحديث:** 2024
**الإصدار:** 1.0
**الحالة:** ✅ جاهز للاستخدام
