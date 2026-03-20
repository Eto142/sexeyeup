@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row g-4">
    <!-- Left: Main Details -->
    <div class="col-lg-8">
        <div class="table-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Product Details</h6>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $product->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Strain <span class="text-danger">*</span></label>
                    <input type="text" name="strain" class="form-control @error('strain') is-invalid @enderror"
                           value="{{ old('strain', $product->strain) }}" required>
                    @error('strain')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="">Select…</option>
                        @foreach(['flower'=>'🌸 Flower','edible'=>'🍪 Edibles','concentrate'=>'💎 Concentrates','vape'=>'💨 Vapes','preroll'=>'🚬 Pre-Rolls'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $product->category)==$val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label">THC / Potency</label>
                    <input type="text" name="thc" class="form-control"
                           value="{{ old('thc', $product->thc) }}" placeholder="e.g. 22% THC or 100mg">
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Emoji (fallback icon)</label>
                    <input type="text" name="emoji" class="form-control"
                           value="{{ old('emoji', $product->emoji) }}" maxlength="10">
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Price per Gram (&#8358;) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₦</span>
                        <input type="number" name="price_gram" step="1" min="0"
                               class="form-control @error('price_gram') is-invalid @enderror"
                               value="{{ old('price_gram', $product->price_gram) }}" required>
                    </div>
                    @error('price_gram')<div class="text-danger" style="font-size:.8rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Price per Ounce (&#8358;) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">₦</span>
                        <input type="number" name="price_ounce" step="1" min="0"
                               class="form-control @error('price_ounce') is-invalid @enderror"
                               value="{{ old('price_ounce', $product->price_ounce) }}" required>
                    </div>
                    @error('price_ounce')<div class="text-danger" style="font-size:.8rem;">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Rating (0–5)</label>
                    <input type="number" name="rating" step="0.1" min="0" max="5"
                           class="form-control" value="{{ old('rating', $product->rating) }}">
                </div>
                <div class="col-sm-3">
                    <label class="form-label">Review Count</label>
                    <input type="number" name="reviews" min="0"
                           class="form-control" value="{{ old('reviews', $product->reviews) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Image + Flags -->
    <div class="col-lg-4">
        <div class="table-card p-4 mb-4">
            <h6 class="fw-bold mb-3">Product Image</h6>

            @if($product->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}" id="imgPreview"
                     style="width:100%;border-radius:10px;object-fit:cover;max-height:200px;">
            </div>
            @else
            <div id="imgPreviewWrap" class="mb-3" style="display:none;">
                <img id="imgPreview" src="" alt="Preview"
                     style="width:100%;border-radius:10px;object-fit:cover;max-height:200px;">
            </div>
            @endif

            <input type="file" name="image" id="imageInput"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="image/*"
                   onchange="previewImage(this)">
            <div class="form-text mt-1">Upload new to replace current. JPEG, PNG, WebP — max 2MB</div>
            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="table-card p-4">
            <h6 class="fw-bold mb-3">Flags</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="active" id="active"
                       value="1" {{ old('active', $product->active) ? 'checked' : '' }}>
                <label class="form-check-label" for="active">Active (visible in store)</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="featured" id="featured"
                       value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
                <label class="form-check-label" for="featured">Featured (homepage)</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_new" id="is_new"
                       value="1" {{ old('is_new', $product->is_new) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_new">Mark as New</label>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-2">
    <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-check-lg me-1"></i> Update Product
    </button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

</form>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const img = document.getElementById('imgPreview');
    const wrap = document.getElementById('imgPreviewWrap');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            if (img) { img.src = e.target.result; }
            if (wrap) wrap.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
