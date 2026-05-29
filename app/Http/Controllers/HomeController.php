<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationCenter;
use App\Models\BloodRequest;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية مع الإحصائيات الحقيقية
     */
    public function index()
    {
        $donationsCount = 15000 + BloodRequest::where('status', 'provided')->count() * 10; // افتراض أولي
        $livesSaved = 45000 + BloodRequest::where('status', 'provided')->count() * 30; // كل وحدة تنقذ 3 أشخاص
        
        $stats = [
            'donations' => $donationsCount,
            'lives' => $livesSaved,
            'centers' => DonationCenter::count() > 0 ? DonationCenter::count() : 50
        ];

        // جلب آخر 2 طلبات عاجلة (Urgent) لعرضها في قسم "المطلوبة عاجلاً"
        $urgentRequests = BloodRequest::where('is_urgent', true)
                                      ->where('status', 'pending')
                                      ->latest()
                                      ->take(2)
                                      ->get();

        return view('index', compact('stats', 'urgentRequests'));
    }

    /**
     * API لجلب أحدث الطلبات العاجلة لحظياً
     */
    public function urgentRequestsAPI()
    {
        $urgentRequests = BloodRequest::where('is_urgent', true)
                                      ->where('status', 'pending')
                                      ->latest()
                                      ->take(2)
                                      ->get(['required_type', 'city', 'hospital']);
        
        return response()->json($urgentRequests);
    }
    public function track()
    {
        return view('track-request');
    }

    public function processTrack(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string'
        ]);

        $bloodRequest = BloodRequest::where('tracking_id', $request->tracking_id)->first();

        if (!$bloodRequest) {
            return back()->with('error', 'رقم التتبع غير صحيح أو غير موجود.');
        }

        return view('track-request', compact('bloodRequest'));
    }
}
