@extends('admin.layouts.app')

@section('title', 'Edit Flash Sale')
@section('page-title', 'Edit Flash Sale')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Flash Sales
    </a>
</div>

<form action="{{ route('admin.flash-sales.update', $flashSale) }}" method="POST">
@csrf
@method('PUT')

<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card p-4">
            <h6 class="fw-bold mb-3">Flash Sale Details</h6>

            <div class="mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', $flashSale->title) }}"
                       required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Badge Text</label>
                <input type="text" name="badge"
                       class="form-control"
                       value="{{ old('badge', $flashSale->badge) }}"
                       placeholder="🔥 Flash Deal">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $flashSale->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Button Text</label>
                <input type="text" name="button_text"
                       class="form-control"
                       value="{{ old('button_text', $flashSale->button_text) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Expires At <span class="text-danger">*</span></label>
                <input type="datetime-local" name="ends_at"
                       class="form-control @error('ends_at') is-invalid @enderror"
                       value="{{ old('ends_at', $flashSale->ends_at->format('Y-m-d\TH:i')) }}"
                       required>
                @error('ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="table-card p-4">
            <h6 class="fw-bold mb-3">Visibility</h6>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="active" value="1" id="activeToggle"
                       {{ old('active', $flashSale->active) ? 'checked' : '' }}>
                <label class="form-check-label" for="activeToggle">
                    <strong>Set as Active</strong>
                </label>
            </div>
            <div class="form-text mb-4">Only one flash sale can be active at a time.</div>

            <button type="submit" class="btn btn-primary w-100 mb-2">
                <i class="bi bi-check-circle me-1"></i> Save Changes
            </button>

            <form method="POST" action="{{ route('admin.flash-sales.destroy', $flashSale) }}"
                  onsubmit="return confirm('Delete this flash sale?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>

</form>

@endsection
