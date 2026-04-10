@extends('admin.layouts.app')
@section('title', 'Order ' . $order->reference . ' — Admin')
@section('page-title', 'Order Detail')

@section('content')
<div class="mb-4 d-flex align-items-center gap-2">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Orders
    </a>
    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="ms-auto" onsubmit="return confirm('Delete order {{ $order->reference }}? This cannot be undone.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="bi bi-trash3"></i> Delete Order
        </button>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    {{-- Order details --}}
    <div class="col-lg-8">
        <div class="table-card mb-4">
            <div class="table-card-header">
                <span>{{ $order->reference }}</span>
                @php
                    $colors = ['pending'=>'warning','confirmed'=>'primary','shipped'=>'info','delivered'=>'success','cancelled'=>'danger'];
                    $color  = $colors[$order->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $color }} badge-status text-capitalize">{{ $order->status }}</span>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:right;">Unit Price</th>
                            <th style="text-align:right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td class="fw-600">{{ $item->product_name }}</td>
                            <td>{{ $item->unit === 'ounce' ? '1 oz' : '1 g' }}</td>
                            <td style="text-align:center;">{{ $item->qty }}</td>
                            <td style="text-align:right;">₦{{ number_format($item->price, 2) }}</td>
                            <td style="text-align:right;" class="fw-700">₦{{ number_format($item->price * $item->qty, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr style="background:#f9fafb;">
                            <td colspan="4" class="fw-700 text-end">Order Total</td>
                            <td style="text-align:right;" class="fw-700 text-success fs-5">₦{{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Customer info + status update --}}
    <div class="col-lg-4">
        <div class="table-card mb-4 p-3">
            <p class="fw-700 mb-3" style="font-size:.82rem; text-transform:uppercase; letter-spacing:.05em; color:#6b7280;">Customer</p>
            <p class="mb-1" style="font-size:.88rem;"><i class="bi bi-telephone me-2 text-success"></i>{{ $order->customer_phone }}</p>
            @if($order->customer_phone2)
            <p class="mb-1" style="font-size:.88rem;"><i class="bi bi-telephone-fill me-2 text-success"></i>{{ $order->customer_phone2 }}</p>
            @endif
            <p class="mb-0" style="font-size:.82rem; color:#6b7280;"><i class="bi bi-clock me-2"></i>{{ $order->created_at->format('M j, Y — g:ia') }}</p>
        </div>

        <div class="table-card p-3">
            <p class="fw-700 mb-3" style="font-size:.82rem; text-transform:uppercase; letter-spacing:.05em; color:#6b7280;">Update Status</p>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="form-select form-select-sm mb-3">
                    @foreach(['pending','confirmed','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-success w-100">Save Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
