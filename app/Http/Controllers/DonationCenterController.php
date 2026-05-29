<?php

namespace App\Http\Controllers;

use App\Models\DonationCenter;
use Illuminate\Http\Request;

class DonationCenterController extends Controller
{
    /**
     * عرض جميع مراكز التبرع للمستخدمين العاديين
     */
    public function publicIndex()
    {
        // عرض المراكز النشطة في الواجهة
        $donationCenters = DonationCenter::all();
        return view('locations', compact('donationCenters'));
    }

    /**
     * عرض جميع مراكز التبرع في لوحة التحكم
     */
    public function index()
    {
        // جلب البيانات مرتبة من الأحدث إلى الأقدم
        $donationCenters = DonationCenter::latest()->get();
        return view('admin.centers', compact('donationCenters'));
    }

    /**
     * حفظ مركز تبرع جديد (إضافة)
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات باش ما يقعدش فيه حقل فارغ أو غلط
        $request->validate([
            'name'    => 'required|string|max:255',
            'city'    => 'required|string',
            'phone'   => 'required|string|max:15',
            'address' => 'nullable|string',
        ]);

        // 2. تخزين البيانات في جدول DonationCenter
        DonationCenter::create($request->all());

        // 3. الرجوع للخلف مع رسالة نجاح تظهر للمستخدم
        return back()->with('success', 'تم إضافة مركز التبرع بنجاح للمنظومة.');
    }

    /**
     * تحديث بيانات مركز موجود (تعديل)
     */
    public function update(Request $request, $id)
    {
        // 1. التحقق من البيانات الجديدة
        $request->validate([
            'name'    => 'required|string|max:255',
            'city'    => 'required|string',
            'phone'   => 'required|string|max:15',
            'address' => 'nullable|string',
        ]);

        // 2. البحث عن المركز وتحديث بياناته
        $center = DonationCenter::findOrFail($id);
        $center->update($request->all());

        return back()->with('success', 'تم تحديث بيانات المركز بنجاح.');
    }

    /**
     * حذف مركز تبرع نهائياً
     */
    public function destroy($id)
    {
        // البحث عن المركز وحذفه، أو إظهار خطأ 404 لو مش موجود
        $center = DonationCenter::findOrFail($id);
        $center->delete();

        return back()->with('success', 'تم حذف المركز بنجاح من المنظومة.');
    }
}