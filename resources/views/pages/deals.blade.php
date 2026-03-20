@extends('layouts.app')

@section('title', 'Deals — SexEyeUp')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <span class="page-header-tag">🔥 Limited Time</span>
    <h1>Hot <span>Deals</span></h1>
    <p>Stack your savings — exclusive bundles, flash sales, and member discounts updated daily.</p>
</div>

<section class="py-5">
    <div class="container">

        <!-- Flash sale banner with countdown -->
        <div class="deals-banner mb-5">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <span class="section-tag">⚡ Flash Sale</span>
                    <h2 class="section-title mt-2">30% OFF <span>Sativa</span><br>Bundle Pack</h2>
                    <p style="color:var(--text-muted-c); margin:12px 0 22px; font-size:.92rem;">
                        Get 3 top-shelf Sativa strains — 7g each. Lab-tested, freshly cured. Limited stock — grab it before it's gone.
                    </p>
                    <button class="btn-hero" onclick="addBundleToCart()">Add Bundle to Cart — $79.99</button>
                </div>
                <div class="col-md-6">
                    <p style="color:var(--text-muted-c); font-size:.8rem; margin-bottom:10px; letter-spacing:1px;">OFFER EXPIRES IN:</p>
                    <div class="countdown">
                        <div class="count-block"><span class="count-num" id="cdHours">00</span><span class="count-label">Hours</span></div>
                        <div class="count-block"><span class="count-num" id="cdMins">00</span><span class="count-label">Mins</span></div>
                        <div class="count-block"><span class="count-num" id="cdSecs">00</span><span class="count-label">Secs</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deal Cards Grid -->
        <div class="text-center mb-4">
            <span class="section-tag">💸 All Deals</span>
            <h2 class="section-title">More <span>Savings</span></h2>
        </div>

        <div class="row g-4" id="dealGrid">
            <!-- Rendered by JS below -->
        </div>

        <!-- Loyalty Banner -->
        <div class="mt-5 p-4 p-md-5 text-center"
             style="background:var(--bg-card2); border:1px solid var(--border-subtle); border-radius:24px;">
            <div style="font-size:2.6rem; margin-bottom:12px;">🏆</div>
            <h3 class="section-title mb-2">Earn <span>Points</span>, Save More</h3>
            <p style="color:var(--text-muted-c); max-width:480px; margin:0 auto 22px; font-size:.92rem;">
                Join the SexEyeUp Loyalty Program — earn 1 point per $1 spent. Redeem for discounts, free pre-rolls, and exclusive drops.
            </p>
            <button class="btn-hero" onclick="showToast('🎉 Loyalty program coming soon!')">Join Now — It\'s Free</button>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
const DEAL_ITEMS = [
    { id: 'd1', emoji:'🌿🌿🌿', title:'Indica Trio Bundle', desc:'3 premium Indica strains, 5g each. Perfect for nights in. Hand-picked, lab-tested.', discount:'25% OFF', originalPrice:89.99, salePrice:67.49, tag:'Bundle', products:[1,3,6] },
    { id: 'd2', emoji:'🍪🟢🥭', title:'Edibles Sampler Pack', desc:'Try all 3 edibles — brownie, gummies, and mango bites. Start low, go slow.', discount:'20% OFF', originalPrice:46.97, salePrice:37.57, tag:'Sampler', products:[7,8,9] },
    { id: 'd3', emoji:'🚬🌾',   title:'Pre-Roll 5-Pack',    desc:'Mix of Sativa and Indica pre-rolls. Ready to spark — no grinder needed.',        discount:'15% OFF', originalPrice:55.94, salePrice:47.55, tag:'Value', products:[14,15] },
    { id: 'd4', emoji:'💎🫙',   title:'Concentrate Duo',    desc:'Live Rosin + Wax Sauce combo. For the seasoned consumer who wants the best.',    discount:'18% OFF', originalPrice:109.98, salePrice:90.18, tag:'Premium', products:[12,13] },
    { id: 'd5', emoji:'💨🔋',   title:'Vape Starter Kit',   title2: '', desc:'Both vape options — 1g cart + 0.5g disposable. Discreet, clean, potent.',   discount:'22% OFF', originalPrice:77.98, salePrice:60.82, tag:'Kit', products:[10,11] },
    { id: 'd6', emoji:'🌱💚',   title:'New Customer Box',   desc:'Hand-picked starter pack for first-timers. 2 flower strains + 1 edible + guide.', discount:'30% OFF', originalPrice:71.97, salePrice:50.37, tag:'New User', products:[2,4,7] },
];

function renderDeals() {
    const grid = document.getElementById('dealGrid');
    grid.innerHTML = DEAL_ITEMS.map(d => `
        <div class="col-md-6 col-xl-4">
            <div class="deal-card">
                <div class="deal-card-head">
                    <span class="deal-badge">${d.discount}</span>
                    <div style="font-size:3rem; margin:8px 0 10px;">${d.emoji}</div>
                    <div style="font-weight:700; font-size:1.1rem; color:#fff;">${d.title}</div>
                    <span style="background:rgba(162,245,99,.15); color:var(--green-neon); font-size:.7rem; font-weight:700; letter-spacing:1px; padding:3px 10px; border-radius:50px;">${d.tag}</span>
                </div>
                <div class="deal-card-body">
                    <p style="color:var(--text-muted-c); font-size:.86rem; line-height:1.7; margin-bottom:16px;">${d.desc}</p>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <span style="font-family:'Bebas Neue',cursive; font-size:1.7rem; color:var(--green-neon);">$${d.salePrice.toFixed(2)}</span>
                            <span style="font-size:.82rem; color:var(--text-muted-c); text-decoration:line-through; margin-left:6px;">$${d.originalPrice.toFixed(2)}</span>
                        </div>
                        <span style="background:rgba(201,168,76,.15); border:1px solid var(--gold); color:var(--gold); font-size:.72rem; font-weight:700; padding:4px 12px; border-radius:50px;">${d.discount}</span>
                    </div>
                    <button class="btn-add-cart" onclick="addDealToCart(${JSON.stringify(d.products).replace(/"/g,"'")})">
                        <i class="bi bi-bag-plus"></i> Add Bundle to Cart
                    </button>
                </div>
            </div>
        </div>`).join('');
}

function addDealToCart(productIds) {
    productIds.forEach(id => {
        const product  = PRODUCTS.find(p => p.id === id);
        if (!product) return;
        const existing = cart.find(c => c.id === id);
        if (existing) existing.qty++;
        else cart.push({ ...product, qty: 1 });
    });
    saveCart();
    updateCartUI();
    showToast('🛍️ <strong>Bundle</strong> added to cart!');
}

document.addEventListener('DOMContentLoaded', () => {
    renderDeals();
    startCountdown('cdHours','cdMins','cdSecs');
});
</script>
@endpush
