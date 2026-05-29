// وظيفة فتح المودال عند الضغط على الزر
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "block";
    }
}

// وظيفة إغلاق المودال
function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = "none";
    }
}

// إغلاق المودال تلقائياً إذا ضغط المستخدم خارج نافذة المحتوى
window.onclick = function (event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
    }
}

// وظيفة فتح مودال التعديل وتعبئة البيانات
function openEditModal(center) {
    // إظهار المودال
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.style.display = "block";
    }

    // تعبئة الحقول ببيانات المركز
    document.getElementById('edit_name').value = center.name;
    document.getElementById('edit_city').value = center.city;
    document.getElementById('edit_phone').value = center.phone;
    document.getElementById('edit_address').value = center.address || '';

    // تغيير مسار الـ Form ليحتوي على ID المركز للتعديل
    const form = document.getElementById('editForm');
    form.action = '/admin/centers/update/' + center.id;
}