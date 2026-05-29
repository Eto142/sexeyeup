@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <span class="text-muted" style="font-size:.85rem;">{{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }}</span>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Product
    </a>
</div>

<!-- Location Tabs -->
<ul class="nav nav-tabs mb-3" style="border-bottom: 1px solid var(--bs-border-color);">
    <li class="nav-item">
        <a class="nav-link {{ $tab === 'all' ? 'active' : '' }}"
           href="{{ route('admin.products.index', ['tab' => 'all']) }}">
            🌿 All
            <span class="badge bg-secondary ms-1" style="font-size:.7rem;">{{ $counts['all'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tab === 'bayelsa' ? 'active' : '' }}"
           href="{{ route('admin.products.index', ['tab' => 'bayelsa']) }}">
            📍 Bayelsa Only
            <span class="badge bg-secondary ms-1" style="font-size:.7rem;">{{ $counts['bayelsa'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tab === 'benin' ? 'active' : '' }}"
           href="{{ route('admin.products.index', ['tab' => 'benin']) }}">
            📍 Benin Only
            <span class="badge bg-secondary ms-1" style="font-size:.7rem;">{{ $counts['benin'] }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $tab === 'both' ? 'active' : '' }}"
           href="{{ route('admin.products.index', ['tab' => 'both']) }}">
            🌍 Both Locations
            <span class="badge bg-secondary ms-1" style="font-size:.7rem;">{{ $counts['both'] }}</span>
        </a>
    </li>
</ul>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Flags</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="text-muted">{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ $product->image }}"
                                 alt="{{ $product->name }}"
                                 style="width:44px;height:44px;object-fit:cover;border-radius:8px;">
                        @else
                            <span style="font-size:1.8rem; line-height:1;">{{ $product->emoji ?: '🌿' }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-semibold" style="font-size:.9rem;">{{ $product->name }}</div>
                        <div class="text-muted" style="font-size:.78rem;">{{ $product->strain }}</div>
                    </td>
                    <td>
                        <span class="badge bg-secondary" style="font-size:.72rem; text-transform:capitalize;">
                            {{ $product->category }}
                        </span>
                    </td>
                    <td>
                        @if($product->location === 'both')
                            <span class="badge bg-primary" style="font-size:.72rem;">Both</span>
                        @elseif($product->location === 'bayelsa')
                            <span class="badge bg-info text-dark" style="font-size:.72rem;">Bayelsa</span>
                        @elseif($product->location === 'benin')
                            <span class="badge bg-warning text-dark" style="font-size:.72rem;">Benin</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:.82rem;">
                            <span class="fw-semibold">₦{{ number_format($product->price_gram, 0) }}</span>
                            <span class="text-muted"> / g</span>
                        </div>
                        <div style="font-size:.78rem; color:#6b7280;">
                            ₦{{ number_format($product->price_ounce, 0) }} / {{ $product->category === 'laughgas' ? 'carton' : 'oz' }}
                        </div>
                    </td>
                    <td>
                        @if($product->active)
                            <span class="badge bg-success badge-status">Active</span>
                        @else
                            <span class="badge bg-secondary badge-status">Inactive</span>
                        @endif
                    </td>
                    <td>
                        @if($product->featured)
                            <span class="badge bg-warning text-dark badge-status me-1">Featured</span>
                        @endif
                        @if($product->is_new)
                            <span class="badge bg-info text-dark badge-status">New</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete {{ addslashes($product->name) }}?')">
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
                    <td colspan="9" class="text-center text-muted py-5">
                        No products yet.
                        <a href="{{ route('admin.products.create') }}">Add the first one →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="d-flex justify-content-end p-3">
        {{ $products->links() }}
    </div>
    @endif
</div>

@endsection
