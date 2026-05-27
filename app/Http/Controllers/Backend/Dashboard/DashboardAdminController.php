<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        
        $totalSubscriptions = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('subscriptions')) {
            $totalSubscriptions = \App\Models\Subscription::where('status', 'active')->count();
        }
        
        $totalFrames = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('custom_frames')) {
            $totalFrames = \App\Models\CustomFrame::count();
        }
        
        $totalMoments = 0;
        if (\Illuminate\Support\Facades\Schema::hasTable('published_photos')) {
            $totalMoments = \App\Models\PublishedPhoto::count();
        }

        return view('backend.dashboard.index', compact(
            'totalUsers',
            'totalSubscriptions',
            'totalFrames',
            'totalMoments'
        ));
    }
}