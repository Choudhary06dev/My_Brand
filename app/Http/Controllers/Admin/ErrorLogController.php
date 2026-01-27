<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ErrorLogController extends Controller
{
    public function index()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (File::exists($logPath)) {
            $file = File::get($logPath);
            // Simple approach: Read lines, reverse them to show newest first, pick top 100
            $lines = explode("\n", $file);
            $logs = array_slice(array_reverse($lines), 0, 200);
        }

        return view('admin.error_logs.index', compact('logs'));
    }
}
