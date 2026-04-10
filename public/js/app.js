/* =============================================================
   SexEyeUp — Main App JS
   - Theme toggle (dark / light)
   - Cart (localStorage)
   - Toast notifications
   - Age gate
   - Countdown timer
   - Shared product card renderer
   ============================================================= */

/* ── Theme ─────────────────────────────────────────────────── */
function initTheme() {
    const saved = localStorage.getItem('seu_theme') || 'dark';
    applyTheme(saved);
}

function applyTheme(mode) {
    document.body.classList.toggle('light-mode', mode === 'light');
    localStorage.setItem('seu_theme', mode);

    document.querySelectorAll('.theme-icon-el').forEach(function(icon) {
        icon.className = mode === 'light' ? 'bi bi-moon-stars-fill theme-icon-el' : 'bi bi-sun-fill theme-icon-el';
    });
}

function toggleTheme() {
    const current = localStorage.getItem('seu_theme') || 'dark';
    applyTheme(current === 'dark' ? 'light' : 'dark');
}

/* ── Currency ──────────────────────────────────────────────── */
function formatNaira(amount) {
    return '\u20a6' + Math.round(amount).toLocaleString('en-NG');
}

/* ── Unit Selection ────────────────────────────────────────── */
const selectedUnits = {};

function selectUnit(id, unit) {
    selectedUnits[id] = unit;
    const priceEl = document.getElementById('cardPrice_' + id);
    if (priceEl) {
        const product = PRODUCTS.find(p => p.id === id);
        if (product) priceEl.textContent = formatNaira(unit === 'ounce' ? product.priceOunce : product.priceGram);
    }
    updateCardTotal(id);
}

function getSelectedUnit(id) {
    return selectedUnits[id] || 'gram';
}

/* ── Card quantity stepper ─────────────────────────────────── */
const cardQtys = {};

function changeCardQty(id, delta) {
    cardQtys[id] = Math.max(1, (cardQtys[id] || 1) + delta);
    const el = document.getElementById('cardQtyVal_' + id);
    if (el) el.textContent = cardQtys[id];
    updateCardTotal(id);
}

function updateCardTotal(id) {
    const el = document.getElementById('cardQtyTotal_' + id);
    if (!el) return;
    const product = PRODUCTS.find(p => p.id === id);
    if (!product) return;
    const qty   = cardQtys[id] || 1;
    const unit  = getSelectedUnit(id);
    const price = unit === 'ounce' ? product.priceOunce : product.priceGram;
    el.textContent = formatNaira(price * qty);
}

function addToCartFromCard(id) {
    const qty     = cardQtys[id] || 1;
    const unit    = getSelectedUnit(id);
    const product = PRODUCTS.find(p => p.id === id);
    if (!product) return;
    const price    = unit === 'ounce' ? product.priceOunce : product.priceGram;
    const cartKey  = `${id}_${unit}`;
    const existing = cart.find(c => c.cartKey === cartKey);
    if (existing) {
        existing.qty += qty;
    } else {
        cart.push({ ...product, price, unit, cartKey, qty });
    }
    saveCart();
    updateCartUI();
    if (typeof renderProducts === 'function') renderProducts(currentFilter || 'all');
    showToast(`🌿 <strong>${product.name}</strong> ×${qty} added to cart!`);
}

/* ── Cart ──────────────────────────────────────────────────── */
let cart = JSON.parse(localStorage.getItem('seu_cart') || '[]');

function saveCart() {
    localStorage.setItem('seu_cart', JSON.stringify(cart));
}

function getCartTotal() {
    return cart.reduce((s, i) => s + i.price * i.qty, 0);
}

function getCartCount() {
    return cart.reduce((s, i) => s + i.qty, 0);
}

function addToCart(id, unit) {
    unit = unit || 'gram';
    const product = PRODUCTS.find(p => p.id === id);
    if (!product) return;
    const price   = unit === 'ounce' ? product.priceOunce : product.priceGram;
    const cartKey = `${id}_${unit}`;
    const existing = cart.find(c => c.cartKey === cartKey);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ ...product, price, unit, cartKey, qty: 1 });
    }
    saveCart();
    updateCartUI();
    if (typeof renderProducts === 'function') renderProducts(currentFilter || 'all');
    showToast(`🌿 <strong>${product.name}</strong> (${unit === 'ounce' ? '1oz' : '1g'}) added to cart!`);
}

function changeQty(cartKey, delta) {
    const item = cart.find(c => c.cartKey === cartKey);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) cart = cart.filter(c => c.cartKey !== cartKey);
    saveCart();
    updateCartUI();
    if (typeof renderProducts === 'function') renderProducts(currentFilter || 'all');
}

function removeItem(cartKey) {
    const item = cart.find(c => c.cartKey === cartKey);
    cart = cart.filter(c => c.cartKey !== cartKey);
    saveCart();
    updateCartUI();
    if (typeof renderProducts === 'function') renderProducts(currentFilter || 'all');
    if (item) showToast(`🗑️ <strong>${item.name}</strong> removed.`);
}

function checkout() {
    if (!cart.length) return;
    // Close the cart offcanvas first
    const canvasEl = document.getElementById('cartCanvas');
    if (canvasEl) {
        const oc = bootstrap.Offcanvas.getInstance(canvasEl);
        if (oc) oc.hide();
    }
    // Render order summary then open checkout modal
    renderCheckoutSummary();
    const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    modal.show();
}

function renderCheckoutSummary() {
    const el = document.getElementById('checkoutSummary');
    if (!el) return;
    el.innerHTML = cart.map(item => `
        <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid var(--border-subtle); font-size:.85rem;">
            <span>${item.name} <span style="color:var(--text-muted-c); font-size:.78rem;">(${item.unit === 'ounce' ? '1 oz' : '1 g'} &times; ${item.qty})</span></span>
            <span style="color:var(--green-bright); font-weight:700; white-space:nowrap; margin-left:10px;">${formatNaira(item.price * item.qty)}</span>
        </div>
    `).join('') + `
        <div class="d-flex justify-content-between align-items-center pt-2 pb-1">
            <span style="font-weight:700;">Total</span>
            <span style="color:var(--green-neon); font-family:'Bebas Neue',cursive; font-size:1.5rem;">${formatNaira(getCartTotal())}</span>
        </div>
    `;
}

function submitOrder() {
    const phone  = document.getElementById('checkoutPhone').value.trim();
    const phone2 = document.getElementById('checkoutPhone2').value.trim();
    if (!phone) {
        showToast('⚠️ Please enter your phone number.');
        return;
    }
    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Placing order…';

    fetch('/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ phone, phone2, items: cart }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            cart = [];
            saveCart();
            updateCartUI();
            const modal = bootstrap.Modal.getInstance(document.getElementById('checkoutModal'));
            if (modal) modal.hide();
            document.getElementById('checkoutPhone').value = '';
            document.getElementById('checkoutPhone2').value = '';
            showToast(`✅ Order <strong>${data.reference}</strong> placed! We’ll be in touch shortly.`);
        } else {
            showToast('❌ ' + (data.message || 'Something went wrong. Please try again.'));
        }
    })
    .catch(() => showToast('❌ Connection error. Please try again.'))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-lock-fill"></i> Place Order';
    });
}

function addBundleToCart() {
    const bundle = PRODUCTS.filter(p => p.category === 'flower' && p.strain.toLowerCase().includes('sativa'));
    bundle.forEach(p => {
        const cartKey = `${p.id}_gram`;
        const ex = cart.find(c => c.cartKey === cartKey);
        if (ex) ex.qty++;
        else cart.push({ ...p, price: p.priceGram, unit: 'gram', cartKey, qty: 1 });
    });
    saveCart();
    updateCartUI();
    showToast('🔥 <strong>Sativa Bundle</strong> added to cart!');
}

/* ── Cart UI ───────────────────────────────────────────────── */
function updateCartUI() {
    const count = getCartCount();
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = count;
        el.classList.remove('bump');
        void el.offsetWidth;
        el.classList.add('bump');
    });
    renderCart();
}

function renderCart() {
    const body   = document.getElementById('cartBody');
    const footer = document.getElementById('cartFooter');
    if (!body) return;

    if (!cart.length) {
        body.innerHTML = `
            <div class="text-center py-5" style="color:var(--text-muted-c)">
                <span style="font-size:3.2rem">🛒</span>
                <p class="mt-3 fw-semibold">Your cart is empty</p>
                <p style="font-size:.82rem">Add some green to get started 🌿</p>
            </div>`;
        if (footer) footer.style.display = 'none';
        const banner = document.getElementById('cartInfoBanner');
        if (banner) banner.style.display = 'none';
        return;
    }
    if (footer) footer.style.display = 'block';
    const banner = document.getElementById('cartInfoBanner');
    if (banner) banner.style.display = 'block';

    body.innerHTML = cart.map(item => `
        <div class="cart-item">
            <span class="cart-item-emoji">${item.emoji}</span>
            <div style="flex:1; min-width:0;">
                <div class="cart-item-name">${item.name}</div>
                <div class="cart-item-strain">${item.strain} · ${item.unit === 'ounce' ? '1oz' : '1g'}</div>
                <div class="cart-item-price">${formatNaira(item.price * item.qty)}</div>
            </div>
            <div class="d-flex flex-column align-items-center gap-2">
                <div class="qty-control">
                    <button class="qty-btn" onclick="changeQty('${item.cartKey}',-1)"><i class="bi bi-dash"></i></button>
                    <span class="qty-val">${item.qty}</span>
                    <button class="qty-btn" onclick="changeQty('${item.cartKey}',1)"><i class="bi bi-plus"></i></button>
                </div>
                <button class="btn-remove" onclick="removeItem('${item.cartKey}')"><i class="bi bi-trash3"></i></button>
            </div>
        </div>`).join('');

    const total = document.getElementById('cartTotal');
    if (total) total.textContent = formatNaira(getCartTotal());
}

/* ── Toast ─────────────────────────────────────────────────── */
function showToast(message) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = 'weed-toast';
    toast.innerHTML = `<span>🌿</span>${message}`;
    container.appendChild(toast);
    setTimeout(() => {
        toast.style.animation = 'slideOut .3s ease forwards';
        setTimeout(() => toast.remove(), 310);
    }, 3200);
}

/* ── Stars ─────────────────────────────────────────────────── */
function renderStars(rating) {
    let html = '';
    for (let i = 1; i <= 5; i++) {
        if (rating >= i)       html += '<i class="bi bi-star-fill"></i>';
        else if (rating > i-1) html += '<i class="bi bi-star-half"></i>';
        else                   html += '<i class="bi bi-star"></i>';
    }
    return html;
}

/* ── Wishlist ──────────────────────────────────────────────── */
function toggleWishlist(btn) {
    btn.classList.toggle('active');
    const icon = btn.querySelector('i');
    if (btn.classList.contains('active')) {
        icon.className = 'bi bi-heart-fill';
        showToast('❤️ Added to wishlist!');
    } else {
        icon.className = 'bi bi-heart';
    }
}

/* ── Age Gate ──────────────────────────────────────────────── */
function enterSite() {
    sessionStorage.setItem('seu_age_ok', '1');
    const gate = document.getElementById('age-gate');
    if (gate) gate.style.display = 'none';
}

function initAgeGate() {
    if (sessionStorage.getItem('seu_age_ok')) {
        const gate = document.getElementById('age-gate');
        if (gate) gate.style.display = 'none';
    }
}

/* ── Countdown ─────────────────────────────────────────────── */
function startCountdown(hoursId, minsId, secsId, storageKey, fixedEndMs) {
    // If an exact end timestamp is supplied from the server, always use it
    const end = fixedEndMs || (() => {
        const key = storageKey || 'seu_deal_end';
        let saved = parseInt(localStorage.getItem(key) || '0');
        const now = Date.now();
        if (!saved || saved < now) {
            saved = now + (11 * 3600 + 59 * 60) * 1000;
            localStorage.setItem(key, saved);
        }
        return saved;
    })();
    function tick() {
        const diff = Math.max(0, end - Date.now());
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        const hEl = document.getElementById(hoursId);
        const mEl = document.getElementById(minsId);
        const sEl = document.getElementById(secsId);
        if (hEl) hEl.textContent = String(h).padStart(2,'0');
        if (mEl) mEl.textContent = String(m).padStart(2,'0');
        if (sEl) sEl.textContent = String(s).padStart(2,'0');
    }
    tick();
    setInterval(tick, 1000);
}

/* ── Newsletter ────────────────────────────────────────────── */
function subscribeNewsletter() {
    const input = document.getElementById('newsletterEmail');
    if (!input) return;
    const email = (input.value || '').trim();
    if (!email || !email.includes('@')) {
        showToast('⚠️ Please enter a valid email address.');
        return;
    }
    showToast(`✅ <strong>${email}</strong> subscribed!`);
    input.value = '';
}

/* ── Active Nav link ───────────────────────────────────────── */
function setActiveNav() {
    const path = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href') || '';
        if (href && path.startsWith(href) && href !== '/') {
            link.classList.add('active');
        } else if (href === '/' && (path === '/' || path === '')) {
            link.classList.add('active');
        }
    });
}

/* ── Init ──────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initAgeGate();
    updateCartUI();
    setActiveNav();
});
