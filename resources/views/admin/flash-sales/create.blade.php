@extends('admin.layouts.app')

@section('title', 'New Flash Sale')
@section('page-title', 'New Flash Sale')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.flash-sales.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Flash Sales
    </a>
</div>

<form action="{{ route('admin.flash-sales.store') }}" method="POST">
@csrf

<div class="row g-4">
    <div class="col-lg-8">
        <div class="table-card p-4">
            <h6 class="fw-bold mb-3">Flash Sale Details</h6>

            <div class="mb-3">
                <label class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" name="title"
                       class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title') }}"
                       placeholder="e.g. 30% OFF Sativa Bundle Pack"
                       required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">This is the headline shown on the homepage deal banner.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Badge Text</label>
                <input type="text" name="badge"
                       class="form-control"
                       value="{{ old('badge', '🔥 Flash Deal') }}"
                       placeholder="🔥 Flash Deal">
                <div class="form-text">Small label above the title (can include emoji).</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="e.g. 3 premium Sativa strains – 7g each. Limited stock.">{{ old('description') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Button Text</label>
                <input type="text" name="button_text"
                       class="form-control"
                       value="{{ old('button_text', 'Grab the Deal') }}"
                       placeholder="Grab the Deal">
            </div>

            <div class="mb-3">
                <label class="form-label">Expires At <span class="text-danger">*</span></label>
                <input type="datetime-local" name="ends_at"
                       class="form-control @error('ends_at') is-invalid @enderror"
                       value="{{ old('ends_at') }}"
                       required>
                @error('ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">The countdown on the homepage counts down to this time.</div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="table-card p-4">
            <h6 class="fw-bold mb-3">Visibility</h6>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="active" value="1" id="activeToggle"
                       {{ old('active') ? 'checked' : '' }}>
                <label class="form-check-label" for="activeToggle">
                    <strong>Set as Active</strong>
                </label>
            </div>
            <div class="form-text mb-4">Only one flash sale can be active at a time. Enabling this will deactivate any currently active sale.</div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-fire me-1"></i> Create Flash Sale
            </button>
        </div>
    </div>
</div>

</form>

@endsection
