@extends('admin.layouts.app')

@section('title', 'User Profile')
@section('page-title', 'User Profile')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Users
    </a>
</div>

<div class="row g-3 mb-4">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="table-card p-4 text-center">
            <div style="width:72px;height:72px;border-radius:50%;background:#4ade80;color:#111;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1.5rem;margin:0 auto 1rem;">
                {{ strtoupper(substr($userProfile->name, 0, 1)) }}
            </div>
            <h5 class="mb-0 fw-bold">{{ $userProfile->name }}</h5>
            <p class="text-muted mb-1" style="font-size:.85rem;">{{ $userProfile->email }}</p>
            <p class="text-muted" style="font-size:.8rem;">
                Joined {{ \Carbon\Carbon::parse($userProfile->created_at)->format('M d, Y') }}
            </p>

            @if($userProfile->email_verified_at)
                <span class="badge bg-success">Email Verified</span>
            @else
                <span class="badge bg-warning text-dark">Email Unverified</span>
            @endif

            <hr>

            <form action="{{ route('admin.delete', $userProfile->id) }}" method="POST"
                  onsubmit="return confirm('Delete this user permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-trash"></i> Delete User
                </button>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon-wrap" style="background:#dbeafe;color:#3b82f6;">
                        <i class="bi bi-bank"></i>
                    </div>
                    <div>
                        <div class="stat-value">${{ number_format($fiat_amount, 2) }}</div>
                        <div class="stat-label">Fiat Balance</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon-wrap" style="background:#dcfce7;color:#16a34a;">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div>
                        <div class="stat-value">${{ number_format($conversion_amount, 2) }}</div>
                        <div class="stat-label">Conversions</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon-wrap" style="background:#fce7f3;color:#db2777;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div>
                        <div class="stat-value">${{ number_format($withdrawal_total, 2) }}</div>
                        <div class="stat-label">Withdrawals</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deposit total row -->
        <div class="row g-3 mt-0">
            <div class="col-sm-4">
                <div class="stat-card">
                    <div class="icon-wrap" style="background:#fef9c3;color:#ca8a04;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div class="stat-value">${{ number_format($deposit_amount, 2) }}</div>
                        <div class="stat-label">Total Deposits</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Conversions Table -->
<div class="table-card mb-4">
    <div class="table-card-header">
        <span><i class="bi bi-arrow-left-right me-2"></i>Conversion History</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user_conversion as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>${{ number_format($c->amount, 2) }}</td>
                    <td>
                        @if($c->status == 1 || $c->status === 'completed')
                            <span class="badge bg-success badge-status">Approved</span>
                        @elseif($c->status == 2)
                            <span class="badge bg-danger badge-status">Declined</span>
                        @else
                            <span class="badge bg-warning text-dark badge-status">Pending</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($c->created_at)->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">No conversions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Withdrawals Table -->
<div class="table-card">
    <div class="table-card-header">
        <span><i class="bi bi-cash-stack me-2"></i>Withdrawal History</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user_withdrawal as $w)
                <tr>
                    <td>{{ $w->id }}</td>
                    <td>${{ number_format($w->amount, 2) }}</td>
                    <td>
                        @if($w->status == 1)
                            <span class="badge bg-success badge-status">Approved</span>
                        @elseif($w->status == 2)
                            <span class="badge bg-danger badge-status">Declined</span>
                        @else
                            <span class="badge bg-warning text-dark badge-status">Pending</span>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($w->created_at)->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">No withdrawals found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
