@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="row g-3 mb-4">
    <!-- Total Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-wrap" style="background:#dbeafe; color:#3b82f6;">
                <i class="bi bi-bag-check-fill"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalOrders }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-wrap" style="background:#fef9c3; color:#ca8a04;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div>
                <div class="stat-value">{{ $pendingOrders }}</div>
                <div class="stat-label">Pending Orders</div>
            </div>
        </div>
    </div>

    <!-- Total Products -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-wrap" style="background:#dcfce7; color:#16a34a;">
                <i class="bi bi-bag"></i>
            </div>
            <div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="icon-wrap" style="background:#fce7f3; color:#db2777;">
                <i class="bi bi-star-fill"></i>
            </div>
            <div>
                <div class="stat-value">{{ $featuredProducts }}</div>
                <div class="stat-label">Featured Products</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="table-card">
    <div class="table-card-header">
        <span><i class="bi bi-clock-history me-2"></i>Recent Orders</span>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Phone</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                @php
                    $colors = ['pending'=>'warning','confirmed'=>'primary','shipped'=>'info','delivered'=>'success','cancelled'=>'danger'];
                    $color  = $colors[$order->status] ?? 'secondary';
                @endphp
                <tr>
                    <td class="fw-600">{{ $order->reference }}</td>
                    <td>{{ $order->customer_phone }}</td>
                    <td class="fw-700">₦{{ number_format($order->total, 2) }}</td>
                    <td><span class="badge bg-{{ $color }} badge-status text-capitalize">{{ $order->status }}</span></td>
                    <td style="font-size:.8rem; color:#6b7280;">{{ $order->created_at->format('M j, Y g:ia') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection