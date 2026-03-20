<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'           => 'nullable|email|max:255',
            'phone'           => 'nullable|string|max:30',
            'items'           => 'required|array|min:1',
            'items.*.id'      => 'required|integer',
            'items.*.name'    => 'required|string|max:255',
            'items.*.unit'    => 'required|in:gram,ounce',
            'items.*.qty'     => 'required|integer|min:1|max:1000',
            'items.*.price'   => 'required|numeric|min:0',
        ]);

        if (empty(trim($validated['email'] ?? '')) && empty(trim($validated['phone'] ?? ''))) {
            return response()->json(['success' => false, 'message' => 'Please provide an email or phone number.'], 422);
        }

        $total = collect($validated['items'])
            ->sum(fn($i) => $i['price'] * $i['qty']);

        $order = Order::create([
            'reference'       => Order::generateReference(),
            'customer_email'  => $validated['email'],
            'customer_phone'  => $validated['phone'],
            'total'           => $total,
            'status'          => 'pending',
        ]);

        foreach ($validated['items'] as $item) {
            $order->items()->create([
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'unit'         => $item['unit'],
                'qty'          => $item['qty'],
                'price'        => $item['price'],
            ]);
        }

        try {
            Mail::to(config('mail.from.address'))
                ->send(new NewOrderMail($order));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('NewOrderMail failed: ' . $e->getMessage());
        }

        return response()->json([
            'success'   => true,
            'reference' => $order->reference,
        ]);
    }
}
