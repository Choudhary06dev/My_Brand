<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $contactMessagesCount = ContactMessage::count();
        $newsCount = \App\Models\Blog::where('status', 1)->count();

        $visitorsCount = Visitor::count();
        $recentActivities = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'contactMessagesCount',
            'newsCount',
            'visitorsCount',
            'recentActivities'
        ));
    }
}
