@extends('admin.layouts.app')
@section('title', 'Orders — Admin')
@section('page-title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0 fw-700">All Orders</h4>
        <p class="text-muted mb-0" style="font-size:.82rem;">{{ $orders->total() }} orders total</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="table-card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span class="fw-600 text-dark">{{ $order->reference }}</span></td>
                    <td style="max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $order->customer_email }}</td>
                    <td>{{ $order->customer_phone }}</td>
                    <td>{{ $order->items->count() }}</td>
                    <td class="fw-700">₦{{ number_format($order->total, 2) }}</td>
                    <td>
                        @php
                            $colors = [
                                'pending'   => 'warning',
                                'confirmed' => 'primary',
                                'shipped'   => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                            ];
                            $color = $colors[$order->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }} badge-status text-capitalize">{{ $order->status }}</span>
                    </td>
                    <td style="font-size:.8rem; color:#6b7280;">{{ $order->created_at->format('M j, Y g:ia') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">No orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
<div class="mt-3 d-flex justify-content-end">
    {{ $orders->links() }}
</div>
@endif
@endsection
