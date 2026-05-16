<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $date     = $request->input('date');     // e.g. "2024-01-15"
        $location = $request->input('location'); // 'bayelsa', 'benin', or null (all)

        $query = Order::latest()->with('items');

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        if (in_array($location, ['bayelsa', 'benin'])) {
            $query->where('location', $location);
        }

        $orders = $query->paginate(10)->withQueryString();

        // Counts per location for the tab badges
        $locationCounts = [
            'all'     => Order::count(),
            'bayelsa' => Order::where('location', 'bayelsa')->count(),
            'benin'   => Order::where('location', 'benin')->count(),
        ];

        // All distinct dates that have at least one order (respects location filter), newest first
        $dateQuery = Order::selectRaw('DATE(created_at) as order_date')->groupBy('order_date')->orderByDesc('order_date');
        if (in_array($location, ['bayelsa', 'benin'])) {
            $dateQuery->where('location', $location);
        }
        $orderDates = $dateQuery->pluck('order_date');

        return view('admin.orders.index', compact('orders', 'orderDates', 'date', 'location', 'locationCounts'));
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order, \Illuminate\Http\Request $request)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Order status updated.');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order ' . $order->reference . ' deleted.');
    }
}
