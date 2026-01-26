<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::withCount('orders')->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $user->load('orders');
        return view('admin.customers.show', compact('user'));
    }
}
