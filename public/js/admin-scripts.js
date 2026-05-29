// دالة لفتح المودال (النافذة المنبثقة)
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

// دالة لإغلاق المودال
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// دالة لفتح مودال التعديل وتعبئة البيانات تلقائياً
function openEditModal(center) {
    // 1. فتح المودال
    openModal('editModal');
    
    // 2. تعبئة الحقول بالبيانات الحالية
    document.getElementById('edit_name').value = center.name;
    document.getElementById('edit_city').value = center.city;
    document.getElementById('edit_address').value = center.address || '';
    document.getElementById('edit_phone').value = center.phone;
    
    // 3. تحديث مسار الـ Form Action ليتوجه للرابط الصحيح للتعديل
    // مثال: /admin/centers/update/5
    const editForm = document.getElementById('editForm');
    editForm.action = `/admin/centers/update/${center.id}`;
}

// إغلاق المودال عند النقر في أي مكان خارج المربع الأبيض
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
}
