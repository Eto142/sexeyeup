@extends('admin.layouts.app')

@section('title', 'Flash Sales')
@section('page-title', 'Flash Sales')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <span class="text-muted" style="font-size:.85rem;">{{ $sales->total() }} total flash sales</span>
    <a href="{{ route('admin.flash-sales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Flash Sale
    </a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Badge</th>
                    <th>Expires</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td class="text-muted">{{ $sale->id }}</td>
                    <td>
                        <div class="fw-semibold" style="font-size:.9rem;">{{ $sale->title }}</div>
                        @if($sale->description)
                            <div class="text-muted" style="font-size:.78rem;">{{ Str::limit($sale->description, 60) }}</div>
                        @endif
                    </td>
                    <td style="font-size:.85rem;">{{ $sale->badge }}</td>
                    <td style="font-size:.82rem;">
                        @if($sale->ends_at->isPast())
                            <span class="badge bg-danger">Expired {{ $sale->ends_at->diffForHumans() }}</span>
                        @else
                            <span class="text-success fw-semibold">{{ $sale->ends_at->format('d M Y, H:i') }}</span>
                            <div class="text-muted" style="font-size:.75rem;">{{ $sale->ends_at->diffForHumans() }}</div>
                        @endif
                    </td>
                    <td>
                        @if($sale->active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.flash-sales.edit', $sale) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.flash-sales.destroy', $sale) }}"
                              style="display:inline;"
                              onsubmit="return confirm('Delete this flash sale?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-fire" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                        No flash sales yet. <a href="{{ route('admin.flash-sales.create') }}">Create one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($sales->hasPages())
    <div class="mt-3">{{ $sales->links() }}</div>
@endif

@endsection
