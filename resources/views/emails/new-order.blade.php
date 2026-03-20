<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Inter, Arial, sans-serif; background: #0d1f0d; color: #e8f5e3; margin: 0; padding: 0; }
  .wrap { max-width: 560px; margin: 30px auto; background: #12291a; border-radius: 14px; overflow: hidden; }
  .header { background: linear-gradient(135deg, #3d7a2e, #5aad3f); padding: 28px 32px; }
  .header h1 { margin: 0; font-size: 1.5rem; color: #fff; letter-spacing: 1px; }
  .header p { margin: 6px 0 0; font-size: .85rem; color: rgba(255,255,255,.8); }
  .body { padding: 28px 32px; }
  .ref { display: inline-block; background: rgba(90,173,63,.2); border: 1px solid #3d7a2e; color: #7ed95a; padding: 6px 16px; border-radius: 20px; font-weight: 700; font-size: .95rem; margin-bottom: 22px; }
  .info-row { display: flex; gap: 10px; margin-bottom: 8px; font-size: .88rem; }
  .info-label { color: #8aaa80; min-width: 80px; }
  .info-val { color: #e8f5e3; font-weight: 600; }
  .divider { border: none; border-top: 1px solid #1e3d20; margin: 20px 0; }
  table { width: 100%; border-collapse: collapse; font-size: .87rem; }
  th { text-align: left; color: #8aaa80; font-weight: 600; padding: 6px 0; border-bottom: 1px solid #1e3d20; }
  td { padding: 9px 0; border-bottom: 1px solid #1a2f1a; color: #e8f5e3; }
  .total-row td { font-weight: 700; font-size: 1rem; color: #7ed95a; border-bottom: none; padding-top: 14px; }
  .footer { background: #0a150a; padding: 18px 32px; font-size: .78rem; color: #5a7a52; text-align: center; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <h1>🌿 New Order Received</h1>
    <p>A customer has placed an order on SexEyeUp.</p>
  </div>
  <div class="body">
    <div class="ref">{{ $order->reference }}</div>

    <div class="info-row">
      <span class="info-label">Email</span>
      <span class="info-val">{{ $order->customer_email }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Phone</span>
      <span class="info-val">{{ $order->customer_phone }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Date</span>
      <span class="info-val">{{ $order->created_at->format('M j, Y — g:ia') }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Status</span>
      <span class="info-val" style="text-transform:capitalize;">{{ $order->status }}</span>
    </div>

    <hr class="divider">

    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th>Unit</th>
          <th style="text-align:center;">Qty</th>
          <th style="text-align:right;">Price</th>
          <th style="text-align:right;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product_name }}</td>
          <td>{{ $item->unit === 'ounce' ? '1 oz' : '1 g' }}</td>
          <td style="text-align:center;">{{ $item->qty }}</td>
          <td style="text-align:right;">₦{{ number_format($item->price, 2) }}</td>
          <td style="text-align:right;">₦{{ number_format($item->price * $item->qty, 2) }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
          <td colspan="4">Order Total</td>
          <td style="text-align:right;">₦{{ number_format($order->total, 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="footer">
    SexEyeUp · support@sexeyeup.store · This is an automated notification.
  </div>
</div>
</body>
</html>
