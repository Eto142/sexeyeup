@extends('layouts.app')

@section('title', $product->name . ' — SexEyeUp')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <span class="page-header-tag">
        <a href="/shop" style="color:inherit; text-decoration:none;">&#127837; Shop</a>
        &rsaquo; {{ $product->category }}
    </span>
    <h1>{{ $product->name }}</h1>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Product Image -->
            <div class="col-lg-5">
                <div class="product-detail-img-wrap">
                    @if($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-detail-img">
                    @else
                        <div class="product-detail-emoji">{{ $product->emoji ?: '🌿' }}</div>
                    @endif
                    @if($product->is_new)
                        <span class="badge-new" style="position:absolute; top:16px; left:16px; font-size:.85rem; padding:5px 14px;">NEW</span>
                    @endif
                    @if($product->thc)
                        <span class="badge-thc" style="position:absolute; top:16px; right:16px; font-size:.85rem; padding:5px 14px;">{{ $product->thc }}</span>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-7">
                <div class="product-detail-body">

                    <!-- Name & Strain -->
                    <h2 class="product-detail-name">{{ $product->name }}</h2>
                    <p class="product-detail-strain">{{ $product->strain }}</p>

                    <!-- Rating -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="stars" id="detailStars"></span>
                        <span class="star-count">({{ $product->reviews }} reviews)</span>
                    </div>

                    <!-- Price Block -->
                    <div class="product-detail-price-block mb-4">
                        <span class="product-detail-price" id="detailPrice"></span>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <span class="price-per-label">per</span>
                            <div class="unit-select-wrap">
                                <select class="unit-select" id="detailUnit" onchange="updateDetailPrice()">
                                    <option value="gram">Gram</option>
                                    <option value="ounce">{{ $product->category === 'laughgas' ? 'Carton' : 'Ounce' }}</option>
                                </select>
                                <i class="bi bi-chevron-down unit-chevron"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                    <div class="product-detail-desc mb-4">
                        <h5 style="color:var(--green-bright); font-size:.85rem; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">About This Product</h5>
                        <p style="color:var(--text-muted-c); line-height:1.8;">{{ $product->description }}</p>
                    </div>
                    @endif

                    <!-- Meta Tags -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="product-meta-tag"><i class="bi bi-tag-fill"></i> {{ ucfirst($product->category) }}</span>
                        @if($product->thc)
                            <span class="product-meta-tag"><i class="bi bi-activity"></i> {{ $product->category === 'laughgas' ? 'Size/Grade' : 'THC' }}: {{ $product->thc }}</span>
                        @endif
                        @if($product->location && $product->location !== 'both')
                            <span class="product-meta-tag"><i class="bi bi-geo-alt-fill"></i> {{ ucfirst($product->location) }} only</span>
                        @elseif($product->location === 'both')
                            <span class="product-meta-tag"><i class="bi bi-geo-alt-fill"></i> Bayelsa &amp; Benin</span>
                        @endif
                    </div>

                    <!-- Qty + Add to Cart -->
                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                        <div class="card-qty-row" style="margin:0;">
                            <button class="card-qty-btn" onclick="changeDetailQty(-1)"><i class="bi bi-dash"></i></button>
                            <span class="card-qty-val" id="detailQtyVal">1</span>
                            <button class="card-qty-btn" onclick="changeDetailQty(1)"><i class="bi bi-plus"></i></button>
                            <span class="card-qty-total" id="detailQtyTotal"></span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn-add-cart" id="detailBtnCart" onclick="addDetailToCart()" style="flex:1; min-width:180px;">
                            <i class="bi bi-bag-plus"></i> Add to Cart
                        </button>
                        <button class="btn-wishlist" onclick="toggleWishlist(this)" style="padding:12px 18px;">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>

                </div>
            </div>

        </div>

        <!-- Related Products -->
        @if($related->count())
        <div class="mt-5 pt-4" style="border-top:1px solid var(--border-subtle);">
            <div class="mb-4">
                <span class="section-tag">&#127807; More Like This</span>
                <h2 class="section-title">Related <span>Products</span></h2>
            </div>
            <div class="row g-4" id="relatedGrid"></div>
        </div>
        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
.product-detail-img-wrap {
    position: relative;
    background: var(--bg-card2);
    border: 1px solid var(--border-subtle);
    border-radius: 20px;
    overflow: hidden;
    min-height: 360px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.product-detail-img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    display: block;
}
.product-detail-emoji {
    font-size: 8rem;
    line-height: 1;
    padding: 40px;
}
.product-detail-name {
    font-family: 'Bebas Neue', cursive;
    font-size: 2.4rem;
    color: var(--text-white);
    letter-spacing: 1px;
    margin-bottom: 4px;
}
.product-detail-strain {
    color: var(--green-bright);
    font-size: .95rem;
    font-weight: 600;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.product-detail-price-block {
    background: var(--bg-card2);
    border: 1px solid var(--border-subtle);
    border-radius: 14px;
    padding: 18px 22px;
    display: inline-block;
}
.product-detail-price {
    font-family: 'Bebas Neue', cursive;
    font-size: 2.4rem;
    color: var(--green-neon);
    letter-spacing: 1px;
}
.product-meta-tag {
    background: rgba(162,245,99,.1);
    border: 1px solid rgba(162,245,99,.2);
    color: var(--green-bright);
    font-size: .78rem;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 50px;
    letter-spacing: .4px;
}
</style>
@endpush

@push('scripts')
<script>
const PRODUCT_DATA = {
    id:         {{ $product->id }},
    name:       @json($product->name),
    strain:     @json($product->strain),
    category:   @json($product->category),
    emoji:      @json($product->emoji ?: '🌿'),
    thc:        @json($product->thc ?? ''),
    priceGram:  {{ (float) $product->price_gram }},
    priceOunce: {{ (float) $product->price_ounce }},
    rating:     {{ (float) $product->rating }},
    reviews:    {{ (int) $product->reviews }},
    isNew:      {{ $product->is_new ? 'true' : 'false' }},
    featured:   {{ $product->featured ? 'true' : 'false' }},
    location:   @json($product->location ?? 'both'),
    image:      @json($product->image),
};

const RELATED_PRODUCTS = @json($related);

let detailQty = 1;

function getDetailUnit() {
    return document.getElementById('detailUnit')?.value || 'gram';
}

function getDetailUnitPrice() {
    return getDetailUnit() === 'ounce' ? PRODUCT_DATA.priceOunce : PRODUCT_DATA.priceGram;
}

function updateDetailPrice() {
    document.getElementById('detailPrice').textContent = formatNaira(getDetailUnitPrice());
    document.getElementById('detailQtyTotal').textContent = formatNaira(getDetailUnitPrice() * detailQty);
    // keep cart button state
    const inCart = cart.some(c => c.id === PRODUCT_DATA.id);
    const btn = document.getElementById('detailBtnCart');
    if (btn) {
        btn.classList.toggle('added', inCart);
        btn.innerHTML = `<i class="bi bi-bag-plus"></i> ${inCart ? 'Added' : 'Add to Cart'}`;
    }
}

function changeDetailQty(delta) {
    detailQty = Math.max(1, detailQty + delta);
    document.getElementById('detailQtyVal').textContent = detailQty;
    document.getElementById('detailQtyTotal').textContent = formatNaira(getDetailUnitPrice() * detailQty);
}

function addDetailToCart() {
    const unit  = getDetailUnit();
    const price = getDetailUnitPrice();
    const existing = cart.find(c => c.id === PRODUCT_DATA.id && c.unit === unit);
    if (existing) {
        existing.qty += detailQty;
    } else {
        cart.push({ ...PRODUCT_DATA, unit, price, qty: detailQty });
    }
    saveCart();
    renderCart();
    updateDetailPrice();
    showToast(`${PRODUCT_DATA.name} added to cart!`);
}

// Make sure this product is in the global PRODUCTS array for cart lookup
if (!PRODUCTS.some(p => p.id === PRODUCT_DATA.id)) {
    PRODUCTS.push(PRODUCT_DATA);
}
if (RELATED_PRODUCTS.length) {
    PRODUCTS.push(...RELATED_PRODUCTS.filter(p => !PRODUCTS.some(e => e.id === p.id)));
}

document.addEventListener('DOMContentLoaded', () => {
    // Stars
    document.getElementById('detailStars').innerHTML = renderStars(PRODUCT_DATA.rating);
    // Price
    updateDetailPrice();
    document.getElementById('detailQtyTotal').textContent = formatNaira(PRODUCT_DATA.priceGram);

    // Related grid
    const relatedGrid = document.getElementById('relatedGrid');
    if (relatedGrid && RELATED_PRODUCTS.length) {
        relatedGrid.innerHTML = RELATED_PRODUCTS.map(p => buildRelatedCard(p)).join('');
    }
});

function buildRelatedCard(p) {
    const stars   = renderStars(p.rating);
    const imgHtml = p.image
        ? `<img src="${p.image}" alt="${p.name}" style="width:100%;height:160px;object-fit:cover;">`
        : `<span class="product-emoji">${p.emoji || '🌿'}</span>`;
    return `
    <div class="col-sm-6 col-lg-4">
        <a href="/products/${p.id}" style="text-decoration:none; color:inherit; display:block;">
            <div class="product-card" style="cursor:pointer;">
                <div class="product-img-wrap">
                    ${imgHtml}
                    <span class="badge-thc">${p.thc}</span>
                    ${p.isNew ? '<span class="badge-new">NEW</span>' : ''}
                </div>
                <div class="product-body">
                    <div class="product-name">${p.name}</div>
                    <div class="product-strain">${p.strain}</div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="stars">${stars}</span>
                        <span class="star-count">(${p.reviews})</span>
                    </div>
                    <div class="product-price">${formatNaira(p.priceGram)}</div>
                </div>
            </div>
        </a>
    </div>`;
}
</script>
@endpush
