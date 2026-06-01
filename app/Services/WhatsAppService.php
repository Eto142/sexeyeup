<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public function notifyNewOrder(Order $order): void
    {
        // Route to the correct WhatsApp number based on order location
        $configKey  = $order->location === 'bayelsa' ? 'waapi_bayelsa' : 'waapi';
        $instanceId = config("services.{$configKey}.instance_id");
        $apiToken   = config("services.{$configKey}.api_token");
        $chatId     = config("services.{$configKey}.chat_id");

        if (empty($instanceId) || empty($apiToken) || empty($chatId)) {
            return; // not configured — skip silently
        }

        $lines   = [];
        $lines[] = "🛒 *New Order — SexEyeUp*";
        $lines[] = "Ref: *{$order->reference}*";
        $lines[] = "Phone: "    . ($order->customer_phone ?: '—');
        $lines[] = "Phone 2: "  . ($order->customer_phone2 ?: '—');
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
            $url = "https://waapi.app/api/v1/instances/{$instanceId}/client/action/send-message";

            Http::timeout(15)
                ->withToken($apiToken)
                ->post($url, [
                    'chatId'  => $chatId,
                    'message' => $message,
                ]);
        } catch (\Exception $e) {
            Log::error('WhatsApp (WaAPI) notification failed: ' . $e->getMessage());
        }
    }
}
