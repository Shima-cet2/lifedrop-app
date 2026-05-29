<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>إضافة مركز تبرع جديد</h3>
            <span class="close" onclick="closeModal('addModal')">&times;</span>
        </div>
        <hr>
        <form action="{{ route('centers.store') }}" method="POST">
            @csrf <!-- مفتاح الأمان لـ Laravel -->
            
            <div class="input-group">
                <label>اسم المركز</label>
                <input type="text" name="name" placeholder="مثال: مركز طرابلس الطبي" required>
            </div>

            <div class="input-group">
                <label>المدينة</label>
                <input type="text" name="city" placeholder="طرابلس، بنغازي..." required>
            </div>

            <div class="input-group">
                <label>العنوان</label>
                <input type="text" name="address" placeholder="وصف المكان" required>
            </div>

            <div class="input-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" placeholder="091XXXXXXX" required>
            </div>

            <div class="modal-footer" style="margin-top: 20px;">
                <button type="submit" class="add-btn">حفظ المركز</button>
                <button type="button" class="cancel-btn" onclick="closeModal('addModal')">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<!-- مودال تعديل مركز تبرع -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>تعديل مركز تبرع</h3>
            <span class="close" onclick="closeModal('editModal')">&times;</span>
        </div>
        <hr>
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            
            <div class="input-group">
                <label>اسم المركز</label>
                <input type="text" name="name" id="edit_name" placeholder="مثال: مركز طرابلس الطبي" required>
            </div>

            <div class="input-group">
                <label>المدينة</label>
                <input type="text" name="city" id="edit_city" placeholder="طرابلس، بنغازي..." required>
            </div>

            <div class="input-group">
                <label>العنوان</label>
                <input type="text" name="address" id="edit_address" placeholder="وصف المكان">
            </div>

            <div class="input-group">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" id="edit_phone" placeholder="091XXXXXXX" required>
            </div>

            <div class="modal-footer" style="margin-top: 20px;">
                <button type="submit" class="add-btn">تحديث المركز</button>
                <button type="button" class="cancel-btn" onclick="closeModal('editModal')">إلغاء</button>
            </div>
        </form>
    </div>
</div>