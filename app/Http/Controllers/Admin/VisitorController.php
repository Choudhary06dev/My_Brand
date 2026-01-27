<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        try {
            $visitors = \App\Models\Visitor::latest()->paginate(20);
        } catch (\Exception $e) {
            \Log::error('Visitor index failed: ' . $e->getMessage());
            $visitors = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);
        }
        return view('admin.visitors.index', compact('visitors'));
    }
}
