@extends('admin.layouts.app')
@section('title', 'Orders — Admin')
@section('page-title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h4 class="mb-0 fw-700">All Orders</h4>
        <p class="text-muted mb-0" style="font-size:.82rem;">
            {{ $orders->total() }} order{{ $orders->total() == 1 ? '' : 's' }}
            @if($date) on <strong>{{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</strong> @endif
        </p>
    </div>
    @if($date)
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">&#x2715; Clear filter</a>
    @endif
</div>

{{-- ── Date filter bar ── --}}
@if($orderDates->isNotEmpty())
<div class="table-card mb-4 p-3">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex align-items-center flex-wrap gap-2">
        <label class="fw-600 mb-0" style="font-size:.88rem; white-space:nowrap;">&#128197; Filter by date:</label>

        <select name="date" class="form-select form-select-sm" style="max-width:210px;"
                onchange="this.form.submit()">
            <option value="">— All dates —</option>
            @foreach($orderDates as $d)
                <option value="{{ $d }}" {{ $date === $d ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($d)->format('D, M j Y') }}
                    ({{ \App\Models\Order::whereDate('created_at', $d)->count() }})
                </option>
            @endforeach
        </select>

        {{-- Manual date input as alternative --}}
        <input type="date" name="date" class="form-control form-control-sm" style="max-width:160px;"
               value="{{ $date ?? '' }}">
        <button class="btn btn-sm btn-primary" type="submit">Go</button>
    </form>
</div>
@endif

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
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete order {{ $order->reference }}? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
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
