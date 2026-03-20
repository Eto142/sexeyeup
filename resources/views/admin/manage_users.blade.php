@extends('admin.layouts.app')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')

<div class="table-card">
    <div class="table-card-header">
        <span><i class="bi bi-people me-2"></i>All Users</span>
        <span class="text-muted" style="font-size:.8rem;">{{ $users->total() }} total</span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Email Verified</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-muted">{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:50%;background:#4ade80;color:#111;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.75rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="badge bg-success badge-status">Verified</span>
                        @else
                            <span class="badge bg-warning text-dark badge-status">Unverified</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.profile', $user->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <form action="{{ route('admin.delete', $user->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this user? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="d-flex justify-content-end p-3">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection
