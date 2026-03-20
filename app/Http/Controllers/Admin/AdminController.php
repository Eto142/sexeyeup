<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalProducts    = Product::count();
        $featuredProducts = Product::where('featured', true)->count();
        $totalOrders      = Order::count();
        $pendingOrders    = Order::where('status', 'pending')->count();
        $recentOrders     = Order::latest()->with('items')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'featuredProducts',
            'totalOrders',
            'pendingOrders',
            'recentOrders',
        ));
    }
}
