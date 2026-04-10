<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function notifyNewOrder(Order $order): void
    {
        $phone  = config('services.callmebot.phone');
        $apiKey = config('services.callmebot.api_key');

        if (empty($phone) || empty($apiKey)) {
            return; // not configured — skip silently
        }

        $lines   = [];
        $lines[] = "🛒 *New Order — SexEyeUp*";
        $lines[] = "Ref: *{$order->reference}*";
        $lines[] = "Customer: " . ($order->customer_email ?: '—');
        $lines[] = "Phone: "    . ($order->customer_phone ?: '—');
        $lines[] = "";

        foreach ($order->items as $item) {
            $price = '₦' . number_format($item->price, 0);
            $lines[] = "• {$item->product_name} ({$item->unit}) × {$item->qty} @ {$price}";
        }

        $lines[] = "";
        $lines[] = "Total: *₦" . number_format($order->total, 0) . "*";
        $lines[] = "Status: Pending";

        $message = implode("\n", $lines);

        try {
            Http::timeout(10)->get('https://api.callmebot.com/whatsapp.php', [
                'phone'  => $phone,
                'text'   => $message,
                'apikey' => $apiKey,
            ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }
    }
}
