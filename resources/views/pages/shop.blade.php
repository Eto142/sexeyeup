@extends('layouts.app')

@section('title', 'Shop — SexEyeUp')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <span class="page-header-tag">🛍️ Our Menu</span>
    <h1>The <span>Shop</span></h1>
    <p>Lab-tested, strain-verified, freshly harvested. Browse all products below.</p>
</div>

<!-- Location Picker Modal -->
<div id="shopLocationModal" class="location-modal-overlay" aria-modal="true" role="dialog" aria-labelledby="shopLocationModalTitle">
    <div class="location-modal-box">
        <div class="location-modal-icon">&#127807;</div>
        <h2 class="location-modal-title" id="shopLocationModalTitle">Where are you located?</h2>
        <p class="location-modal-sub">Choose your city so we can show you the right products.</p>
        <div class="location-modal-choices">
            <button class="location-choice-btn" onclick="chooseShopLocation('bayelsa')">
                <span class="choice-pin">&#128205;</span>
                <span class="choice-name">Bayelsa, Yenagoa</span>
            </button>
            <button class="location-choice-btn" onclick="chooseShopLocation('benin')">
                <span class="choice-pin">&#128205;</span>
                <span class="choice-name">Edo, Benin City</span>
            </button>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">

        <!-- Location indicator -->
        <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
            <span class="section-tag" id="shopLocationTag">&#128205; Bayelsa</span>
            <button onclick="resetShopLocation()" style="background:none;border:none;padding:0;font-size:.82rem;color:var(--text-muted-c);cursor:pointer;text-decoration:underline;">&#128259; Change location</button>
        </div>

        <!-- Top Bar: Search + Sort -->
        <div class="sort-bar">
            <div class="search-wrap" style="flex:1; max-width:320px;">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" id="shopSearch" placeholder="Search strains, types…" oninput="renderShop()">
            </div>
            <select class="sort-select" id="sortSelect" onchange="renderShop()">
                <option value="default">Sort: Featured</option>
                <option value="price-asc">Price: Low → High</option>
                <option value="price-desc">Price: High → Low</option>
                <option value="rating">Top Rated</option>
                <option value="new">New Arrivals</option>
            </select>
            <span id="resultCount" style="color:var(--text-muted-c); font-size:.82rem; margin-left:auto;"></span>
        </div>

        <div class="row g-4">
            <!-- Sidebar filters -->
            <div class="col-lg-2 d-none d-lg-block">
                <div style="position:sticky; top:90px;">
                    <div style="font-weight:700; color:var(--text-white); font-size:.9rem; margin-bottom:14px; letter-spacing:.5px;">CATEGORIES</div>
                    <div class="d-flex flex-column gap-2">
                        <button class="cat-btn active text-start" onclick="setFilter('all',this)">🌿 All</button>
                        <button class="cat-btn text-start" onclick="setFilter('flower',this)">🌸 Flower</button>
                        <button class="cat-btn text-start" onclick="setFilter('edible',this)">🍪 Edibles</button>
                        <button class="cat-btn text-start" onclick="setFilter('concentrate',this)">💎 Concentrates</button>
                        <button class="cat-btn text-start" onclick="setFilter('vape',this)">💨 Vapes</button>
                        <button class="cat-btn text-start" onclick="setFilter('preroll',this)">🚬 Pre-Rolls</button>
                        <button class="cat-btn text-start" onclick="setFilter('laughgas',this)">😂 Laugh Gas</button>
                    </div>

                    <div style="font-weight:700; color:var(--text-white); font-size:.9rem; margin:28px 0 14px; letter-spacing:.5px;">PRICE RANGE</div>
                    <input type="range" id="priceRange" min="0" max="100000" value="100000" step="1000"
                           oninput="document.getElementById('priceVal').textContent='\u20a6'+Number(this.value).toLocaleString('en-NG'); renderShop();"
                           style="width:100%; accent-color:var(--green-light);">
                    <div style="font-size:.8rem; color:var(--text-muted-c); margin-top:4px;">Up to: <span id="priceVal">&#8358;100,000</span></div>
                </div>
            </div>

            <!-- Mobile category pills -->
            <div class="col-12 d-lg-none">
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <button class="cat-btn active" onclick="setFilter('all',this)">All</button>
                    <button class="cat-btn" onclick="setFilter('flower',this)">🌸 Flower</button>
                    <button class="cat-btn" onclick="setFilter('edible',this)">🍪 Edibles</button>
                    <button class="cat-btn" onclick="setFilter('concentrate',this)">💎 Conc.</button>
                    <button class="cat-btn" onclick="setFilter('vape',this)">💨 Vapes</button>
                    <button class="cat-btn" onclick="setFilter('preroll',this)">🚬 Pre-Rolls</button>
                    <button class="cat-btn" onclick="setFilter('laughgas',this)">😂 Laugh Gas</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-10">
                <div class="row g-4" id="shopGrid"></div>
            </div>
        </div><!-- /row -->
    </div>
</section>

@endsection

@push('scripts')
<script>
let shopFilter  = 'all';
let currentFilter = 'all';
let shopLocation = localStorage.getItem('seu_location') || null;

function switchShopLocation(loc) {
    shopLocation = loc;
    const labels = { bayelsa: '&#128205; Bayelsa', benin: '&#128205; Benin' };
    document.getElementById('shopLocationTag').innerHTML = labels[loc] || '&#128205; ' + loc;
    renderShop();
}

function chooseShopLocation(loc) {
    localStorage.setItem('seu_location', loc);
    const modal = document.getElementById('shopLocationModal');
    modal.classList.add('hiding');
    modal.addEventListener('animationend', () => {
        modal.classList.remove('visible', 'hiding');
    }, { once: true });
    switchShopLocation(loc);
}

function resetShopLocation() {
    localStorage.removeItem('seu_location');
    shopLocation = null;
    document.getElementById('shopLocationModal').classList.add('visible');
}

// Pre-select category from URL param  (?cat=flower)
(function readUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const cat = params.get('cat');
    const q   = params.get('q');
    if (cat) shopFilter = cat;
    if (q) {
        document.addEventListener('DOMContentLoaded', () => {
            const inp = document.getElementById('shopSearch');
            if (inp) inp.value = q;
        });
    }
})();

function setFilter(cat, btn) {
    shopFilter = cat;
    currentFilter = cat;
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    renderShop();
}

function renderShop() {
    const grid      = document.getElementById('shopGrid');
    const query     = (document.getElementById('shopSearch')?.value || '').toLowerCase().trim();
    const sort      = document.getElementById('sortSelect')?.value || 'default';
    const maxPrice  = parseFloat(document.getElementById('priceRange')?.value || '100000');
    const countEl   = document.getElementById('resultCount');

    let list = PRODUCTS.filter(p => {
        const matchLoc   = !shopLocation || p.location === 'both' || p.location === shopLocation;
        const matchCat   = shopFilter === 'all' || p.category === shopFilter;
        const matchQ     = !query || p.name.toLowerCase().includes(query) || p.strain.toLowerCase().includes(query);
        const matchPrice = p.priceGram <= maxPrice;
        return matchLoc && matchCat && matchQ && matchPrice;
    });

    // Sort
    if (sort === 'price-asc')  list = [...list].sort((a,b) => a.priceGram - b.priceGram);
    if (sort === 'price-desc') list = [...list].sort((a,b) => b.priceGram - a.priceGram);
    if (sort === 'rating')     list = [...list].sort((a,b) => b.rating - a.rating);
    if (sort === 'new')        list = [...list].filter(p => p.isNew).concat(list.filter(p => !p.isNew));

    if (countEl) countEl.textContent = `${list.length} product${list.length !== 1 ? 's' : ''}`;

    if (!list.length) {
        grid.innerHTML = `<div class="col-12 text-center py-5" style="color:var(--text-muted-c)"><span style="font-size:3rem">🌵</span><p class="mt-3">No products match your filters.</p></div>`;
        return;
    }

    grid.innerHTML = list.map(p => buildCard(p)).join('');
}

function buildCard(p) {
    const inCart   = cart.some(c => c.id === p.id);
    const stars    = renderStars(p.rating);
    const newBadge = p.isNew ? `<span class="badge-new">NEW</span>` : '';
    const imgHtml  = p.image
        ? `<img src="${p.image}" alt="${p.name}" style="width:100%;height:160px;object-fit:cover;">`
        : `<span class="product-emoji">${p.emoji || '\ud83c\udf3f'}</span>`;
    return `
    <div class="col-sm-6 col-xl-4">
        <div class="product-card">
            <a href="/products/${p.id}" style="text-decoration:none; color:inherit;">
            <div class="product-img-wrap" style="cursor:pointer;">
                ${imgHtml}
                <span class="badge-thc">${p.thc}</span>
                ${newBadge}
            </div>
            <div class="product-body" style="padding-bottom:0;">
                <div class="product-name">${p.name}</div>
                <div class="product-strain">${p.strain}</div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="stars">${stars}</span>
                    <span class="star-count">(${p.reviews})</span>
                </div>
            </div>
            </a>
            <div class="product-body" style="padding-top:0;">
                <div class="price-unit-row">
                    <span class="product-price" id="cardPrice_${p.id}">${formatNaira(p.priceGram)}</span>
                    <div class="d-flex align-items-center gap-2">
                        <span class="price-per-label">per</span>
                        <div class="unit-select-wrap">
                            <select class="unit-select" id="unitSelect_${p.id}" onchange="selectUnit(${p.id}, this.value)">
                                <option value="gram">Gram</option>
                                <option value="ounce">${p.category === 'laughgas' ? 'Carton' : 'Ounce'}</option>
                            </select>
                            <i class="bi bi-chevron-down unit-chevron"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn-add-cart${inCart ? ' added' : ''}" id="btnCart${p.id}" onclick="addToCart(${p.id}, getSelectedUnit(${p.id}))">
                        <i class="bi bi-bag-plus"></i> ${inCart ? 'Added \u2713' : 'Add to Cart'}
                    </button>
                    <button class="btn-wishlist" onclick="toggleWishlist(this)">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>`;
}

// Patch addToCart so the grid re-renders on this page
const _origAdd = addToCart;
window.addToCart = function(id, unit) {
    _origAdd(id, unit);
    renderShop();
};

document.addEventListener('DOMContentLoaded', () => {
    // Apply saved location or show modal
    const saved = localStorage.getItem('seu_location');
    if (saved === 'bayelsa' || saved === 'benin') {
        switchShopLocation(saved);
    } else {
        document.getElementById('shopLocationModal').classList.add('visible');
        renderShop();
    }

    // Sync sidebar buttons with URL cat param
    if (shopFilter !== 'all') {
        document.querySelectorAll('.cat-btn').forEach(b => {
            if (b.getAttribute('onclick') && b.getAttribute('onclick').includes(`'${shopFilter}'`)) {
                document.querySelectorAll('.cat-btn').forEach(x => x.classList.remove('active'));
                b.classList.add('active');
            }
        });
    }
});
</script>
@endpush
