@extends('layouts.app')

@section('title', 'SexEyeUp — Premium Cannabis Store')

@section('content')

<!-- ======================== LOCATION PICKER MODAL ======================== -->
<div id="locationModal" class="location-modal-overlay" aria-modal="true" role="dialog" aria-labelledby="locationModalTitle">
    <div class="location-modal-box">
        <div class="location-modal-icon">&#127807;</div>
        <h2 class="location-modal-title" id="locationModalTitle">Where are you located?</h2>
        <p class="location-modal-sub">Choose your city so we can show you the right products.</p>
        <div class="location-modal-choices">
            <button class="location-choice-btn" onclick="chooseLocation('bayelsa')">
                <span class="choice-pin">&#128205;</span>
                <span class="choice-name">Bayelsa</span>
            </button>
            <button class="location-choice-btn" onclick="chooseLocation('benin')">
                <span class="choice-pin">&#128205;</span>
                <span class="choice-name">Benin</span>
            </button>
        </div>
    </div>
</div>

<!-- ======================== COMPACT HERO BANNER ======================== -->
<section class="hero-compact">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <span class="hero-badge">&#127807; Premium Quality</span>
                <h1 class="hero-compact-title">The <span>Purest</span> Green You'll Find.</h1>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="/shop" class="btn-hero">Browse All</a>
                <a href="/shop" class="btn-hero-outline">Today's Deals</a>
            </div>
        </div>
    </div>
</section>

<!-- ======================== LOCATION TABS ======================== -->
<section class="py-4 pb-0">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center gap-3 mb-4 flex-wrap">
            <button class="btn-location-tab active" id="tabBayelsa" onclick="switchLocation('bayelsa')">
                &#128205; Bayelsa
            </button>
            <button class="btn-location-tab" id="tabBenin" onclick="switchLocation('benin')">
                &#128205; Benin
            </button>
        </div>
    </div>
</section>

<!-- ======================== BAYELSA PRODUCTS ======================== -->
<section class="py-3" id="sectionBayelsa">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <span class="section-tag">&#128205; Bayelsa</span>
                <h2 class="section-title mb-0">Available in <span>Bayelsa</span></h2>
            </div>
            <a href="/shop" class="btn-hero-outline" style="padding:9px 22px; font-size:.9rem;">View All &rarr;</a>
        </div>
        <div class="row g-4" id="bayelsaGrid"></div>
        <p class="text-center mt-4" id="bayelsaEmpty" style="display:none; color:var(--text-muted-c);">No products available for Bayelsa yet.</p>
    </div>
</section>

<!-- ======================== BENIN PRODUCTS ======================== -->
<section class="py-3" id="sectionBenin" style="display:none;">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <span class="section-tag">&#128205; Benin</span>
                <h2 class="section-title mb-0">Available in <span>Benin</span></h2>
            </div>
            <a href="/shop" class="btn-hero-outline" style="padding:9px 22px; font-size:.9rem;">View All &rarr;</a>
        </div>
        <div class="row g-4" id="beninGrid"></div>
        <p class="text-center mt-4" id="beninEmpty" style="display:none; color:var(--text-muted-c);">No products available for Benin yet.</p>
    </div>
</section>

<!-- ======================== DEAL STRIP ======================== -->
@if($flashSale ?? null)
<section class="py-4" id="deal-strip">
    <div class="container">
        <div class="deals-banner">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <span class="section-tag">{{ $flashSale->badge }}</span>
                    <h2 class="section-title mt-2">{{ $flashSale->title }}</h2>
                    @if($flashSale->description)
                        <p style="color:var(--text-muted-c); margin:12px 0 22px; font-size:.92rem;">{{ $flashSale->description }}</p>
                    @endif
                    <button class="btn-hero" onclick="addBundleToCart()">{{ $flashSale->button_text }}</button>
                </div>
                <div class="col-md-6">
                    <p style="color:var(--text-muted-c); font-size:.82rem; margin-bottom:10px;">OFFER EXPIRES IN:</p>
                    <div class="countdown">
                        <div class="count-block"><span class="count-num" id="cdHours">00</span><span class="count-label">Hours</span></div>
                        <div class="count-block"><span class="count-num" id="cdMins">00</span><span class="count-label">Mins</span></div>
                        <div class="count-block"><span class="count-num" id="cdSecs">00</span><span class="count-label">Secs</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- ======================== WHY US ======================== -->
<section class="py-4 pb-5">
    <div class="container">
        <div class="text-center mb-4">
            <span class="section-tag">&#9989; Why SexEyeUp</span>
            <h2 class="section-title">You're in <span>Good Hands</span></h2>
        </div>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">&#128300;</div>
                    <div class="feature-title">Lab Tested</div>
                    <div class="feature-text">Every batch third-party tested for potency &amp; purity.</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">&#128230;</div>
                    <div class="feature-title">Discreet Shipping</div>
                    <div class="feature-text">Plain packaging, no labels. Your privacy first.</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">&#127807;</div>
                    <div class="feature-title">100% Organic</div>
                    <div class="feature-text">Pesticide-free, sun-grown as nature intended.</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">&#128172;</div>
                    <div class="feature-title">24/7 Support</div>
                    <div class="feature-text">Budtenders always online to find your perfect strain.</div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const BAYELSA_PRODUCTS = @json($bayelsaProducts);
const BENIN_PRODUCTS   = @json($beninProducts);
// Merge for shared cart/unit helpers in app.js which look up by PRODUCTS
const _allHome = [...BAYELSA_PRODUCTS, ...BENIN_PRODUCTS];
PRODUCTS.push(..._allHome.filter(p => !PRODUCTS.some(e => e.id === p.id)));

function buildCard(p) {
    const inCart   = cart.some(c => c.id === p.id);
    const stars    = renderStars(p.rating);
    const newBadge = p.isNew ? `<span class="badge-new">NEW</span>` : '';
    const imgHtml  = p.image
        ? `<img src="${p.image}" alt="${p.name}" style="width:100%;height:160px;object-fit:cover;">`
        : `<span class="product-emoji">${p.emoji || '🌿'}</span>`;
    return `
    <div class="col-sm-6 col-lg-4">
        <div class="product-card">
            <div class="product-img-wrap">
                ${imgHtml}
                <span class="badge-thc">${p.thc}</span>
                ${newBadge}
            </div>
            <div class="product-body">
                <div class="product-name">${p.name}</div>
                <div class="product-strain">${p.strain}</div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="stars">${stars}</span>
                    <span class="star-count">(${p.reviews})</span>
                </div>
                <div class="price-unit-row">
                    <span class="product-price" id="cardPrice_${p.id}">${formatNaira(p.priceGram)}</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="price-per-label">per</span>
                        <div class="unit-select-wrap">
                            <select class="unit-select" id="unitSelect_${p.id}" onchange="selectUnit(${p.id}, this.value)">
                                <option value="gram">Gram</option>
                                <option value="ounce">Ounce</option>
                            </select>
                            <i class="bi bi-chevron-down unit-chevron"></i>
                        </div>
                    </div>
                </div>
                <div class="card-qty-row">
                    <button class="card-qty-btn" onclick="changeCardQty(${p.id},-1)"><i class="bi bi-dash"></i></button>
                    <span class="card-qty-val" id="cardQtyVal_${p.id}">1</span>
                    <button class="card-qty-btn" onclick="changeCardQty(${p.id},1)"><i class="bi bi-plus"></i></button>
                    <span class="card-qty-total" id="cardQtyTotal_${p.id}">${formatNaira(p.priceGram)}</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn-add-cart${inCart ? ' added' : ''}" id="btnCart${p.id}" onclick="addToCartFromCard(${p.id})">
                        <i class="bi bi-bag-plus"></i> ${inCart ? 'Added' : 'Add to Cart'}
                    </button>
                    <button class="btn-wishlist" onclick="toggleWishlist(this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>`;
}

function renderGrid(products, gridId, emptyId) {
    const grid  = document.getElementById(gridId);
    const empty = document.getElementById(emptyId);
    if (!grid) return;
    if (products.length === 0) {
        grid.innerHTML = '';
        if (empty) empty.style.display = 'block';
    } else {
        grid.innerHTML = products.map(p => buildCard(p)).join('');
        if (empty) empty.style.display = 'none';
    }
}

function switchLocation(loc) {
    const sectionBayelsa = document.getElementById('sectionBayelsa');
    const sectionBenin   = document.getElementById('sectionBenin');
    const tabBayelsa     = document.getElementById('tabBayelsa');
    const tabBenin       = document.getElementById('tabBenin');

    if (loc === 'bayelsa') {
        sectionBayelsa.style.display = '';
        sectionBenin.style.display   = 'none';
        tabBayelsa.classList.add('active');
        tabBenin.classList.remove('active');
    } else {
        sectionBayelsa.style.display = 'none';
        sectionBenin.style.display   = '';
        tabBayelsa.classList.remove('active');
        tabBenin.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    renderGrid(BAYELSA_PRODUCTS, 'bayelsaGrid', 'bayelsaEmpty');
    renderGrid(BENIN_PRODUCTS,   'beninGrid',   'beninEmpty');

    // Show location modal on first visit; restore saved choice on return visits
    const saved = localStorage.getItem('seu_location');
    if (saved === 'bayelsa' || saved === 'benin') {
        switchLocation(saved);
    } else {
        document.getElementById('locationModal').classList.add('visible');
    }

    @if($flashSale ?? null)
        startCountdown('cdHours', 'cdMins', 'cdSecs', 'seu_deal_end', {{ $flashSale->ends_at->timestamp * 1000 }});
    @endif
});

function chooseLocation(loc) {
    localStorage.setItem('seu_location', loc);
    const modal = document.getElementById('locationModal');
    modal.classList.add('hiding');
    modal.addEventListener('animationend', () => modal.remove(), { once: true });
    switchLocation(loc);
}
</script>
@endpush
