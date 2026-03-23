<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date'); // e.g. "2024-01-15"

        $query = Order::latest()->with('items');

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $orders = $query->paginate(10)->withQueryString();

        // All distinct dates that have at least one order, newest first
        $orderDates = Order::selectRaw('DATE(created_at) as order_date')
            ->groupBy('order_date')
            ->orderByDesc('order_date')
            ->pluck('order_date');

        return view('admin.orders.index', compact('orders', 'orderDates', 'date'));
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
