<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SexEyeUp — Premium Cannabis Store')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="/css/app.css">

    @stack('styles')
</head>
<body>

<!-- ======================== AGE GATE ======================== -->
<div id="age-gate">
    <div class="age-gate-card">
        <div class="age-gate-icon">🌿</div>
        <div class="age-gate-title">Age Verification</div>
        <p class="age-gate-sub">You must be <strong style="color:var(--text-white)">21 years or older</strong> to enter SexEyeUp. Please confirm your age.</p>
        <div class="d-flex gap-3 justify-content-center">
            <button class="btn-hero" onclick="enterSite()">Yes, I'm 21+</button>
            <a href="https://www.google.com" class="btn-hero-outline">No, Exit</a>
        </div>
        <p style="font-size:.7rem; color:var(--text-muted-c); margin-top:18px; line-height:1.6;">
            By entering you agree to our Terms & Conditions and confirm you are of legal age where you reside.
        </p>
    </div>
</div>

<!-- ======================== NAVBAR ======================== -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <span class="leaf-icon">🌿</span> SexEyeUp
        </a>

        <!-- Theme toggle visible on mobile (outside collapse) -->
        <button class="theme-toggle d-lg-none" onclick="toggleTheme()" title="Toggle theme">
            <i class="theme-icon-el bi bi-sun-fill"></i>
        </button>

        <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false">
            <span style="color:var(--green-bright); font-size:1.5rem;"><i class="bi bi-list"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-lg-3">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/shop">Shop</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="/deals">Deals</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="/how-to-order">How to Order</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">About</a></li>
            </ul>

            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <!-- Search (shop page only shows expanded; others show compact) -->
                <div class="search-wrap d-none d-lg-block">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input" id="navSearch" placeholder="Search strains…"
                           onkeydown="if(event.key==='Enter'){ window.location='/shop?q='+encodeURIComponent(this.value); }">
                </div>

                <!-- Theme toggle (desktop, inside collapsed menu) -->
                <button class="theme-toggle d-none d-lg-flex" onclick="toggleTheme()" title="Toggle theme">
                    <i class="theme-icon-el bi bi-sun-fill"></i>
                </button>

                <!-- Cart -->
                <button class="cart-btn" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas">
                    <i class="bi bi-bag"></i> Cart
                    <span class="cart-count">0</span>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- ======================== PAGE CONTENT ======================== -->
<main>
    @yield('content')
</main>

<!-- ======================== NEWSLETTER ======================== -->
@unless(View::hasSection('no_newsletter'))
<section class="py-5">
    <div class="container">
        <div class="newsletter-strip">
            <span class="section-tag">📧 Stay Updated</span>
            <h2 class="section-title mt-2">Get <span>Exclusive</span> Deals</h2>
            <p style="color:var(--text-muted-c); margin:10px auto 26px; max-width:460px; font-size:.92rem;">Subscribe for weekly strain drops, flash sales, and members-only discounts.</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <input type="email" id="newsletterEmail" class="newsletter-input" placeholder="your@email.com">
                <button class="btn-hero" onclick="subscribeNewsletter()" style="padding:11px 26px;">Subscribe</button>
            </div>
        </div>
    </div>
</section>
@endunless

<!-- ======================== FOOTER ======================== -->
<footer>
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="footer-brand">🌿 SexEyeUp</div>
                <p style="font-size:.83rem; margin:12px 0 18px; max-width:250px; line-height:1.75;">Premium cannabis products for the discerning consumer. Always organic. Always fresh.</p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-btn"><i class="bi bi-telegram"></i></a>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div style="font-weight:700; color:var(--text-white); margin-bottom:14px; font-size:.88rem;">Shop</div>
                <a href="/shop?cat=flower"      class="footer-link">Flower</a>
                <a href="/shop?cat=edible"      class="footer-link">Edibles</a>
                <a href="/shop?cat=concentrate" class="footer-link">Concentrates</a>
                <a href="/shop?cat=vape"        class="footer-link">Vapes</a>
                <a href="/shop?cat=preroll"     class="footer-link">Pre-Rolls</a>
            </div>
            <div class="col-6 col-md-2">
                <div style="font-weight:700; color:var(--text-white); margin-bottom:14px; font-size:.88rem;">Info</div>
                <a href="/about"  class="footer-link">About Us</a>
                {{-- <a href="/deals"  class="footer-link">Deals</a> --}}
                {{-- <a href="#"       class="footer-link">Lab Results</a>
                <a href="#"       class="footer-link">Blog</a> --}}
            </div>
            <div class="col-md-4">
                <div style="font-weight:700; color:var(--text-white); margin-bottom:14px; font-size:.88rem;">Contact</div>
                <p style="font-size:.84rem; line-height:2;">
                    <i class="bi bi-envelope" style="color:var(--green-bright)"></i> support@sexeyeup.com<br>
                    {{-- <i class="bi bi-telephone" style="color:var(--green-bright)"></i> +1 (800) 420-6969<br> --}}
                    <i class="bi bi-clock"     style="color:var(--green-bright)"></i> 24/7 Customer Support
                </p>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2" style="font-size:.76rem;">
            <span>© 2026 SexEyeUp. All rights reserved. For legal markets only. Must be 21+.</span>
            <div class="d-flex gap-3">
                <a href="#" class="footer-link" style="display:inline;">Privacy</a>
                <a href="#" class="footer-link" style="display:inline;">Terms</a>
                <a href="#" class="footer-link" style="display:inline;">Sitemap</a>
            </div>
        </div>
    </div>
</footer>

<!-- ======================== CART OFFCANVAS ======================== -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="cartCanvas">
    <div class="offcanvas-header" style="justify-content:space-between; padding:12px 16px;">
        <button type="button" class="cart-back-btn" data-bs-dismiss="offcanvas" aria-label="Go back">
            <i class="bi bi-arrow-left"></i> Back
        </button>
        <span class="offcanvas-title" style="flex:1; text-align:center;">🛒 Your Cart</span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" style="flex-shrink:0;"></button>
    </div>
    <div class="offcanvas-body px-4" id="cartBody" style="overflow-y:auto; flex:1;">
        <div id="cartInfoBanner" style="display:none; background:rgba(74,222,128,.08); border:1px solid rgba(74,222,128,.2); border-radius:10px; padding:12px 14px; margin-bottom:16px; font-size:.8rem; color:var(--text-muted-c); line-height:1.7;">
            <strong style="color:var(--green-bright); font-size:.85rem;">🌿 How it works</strong><br>
            Review your items below, then tap <em>Secure Checkout</em>. Leave us your <strong>phone number</strong> and we'll confirm your order &amp; arrange discreet delivery straight to you.
        </div>
    </div>
    <div class="cart-footer" id="cartFooter" style="display:none;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="cart-total-label">Subtotal</span>
            <span class="cart-total-val" id="cartTotal">₦0</span>
        </div>
        <button class="btn-checkout" onclick="checkout()">
            <i class="bi bi-lock-fill"></i> Secure Checkout
        </button>
        {{-- <p style="font-size:.7rem; color:var(--text-muted-c); text-align:center; margin-top:8px;">Free discreet shipping on orders over $75</p> --}}
    </div>
</div>

<!-- ======================== MOBILE FLOATING CART ======================== -->
<button class="floating-cart d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas" aria-label="Open cart">
    <i class="bi bi-bag"></i>
    <span class="cart-count floating-cart-count">0</span>
</button>

<!-- ======================== CHECKOUT MODAL ======================== -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content checkout-modal-content">
            <div class="modal-header checkout-modal-header">
                <h5 class="modal-title" id="checkoutModalLabel"><i class="bi bi-bag-check-fill" style="color:var(--green-bright)"></i> Secure Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1) sepia(1) saturate(3) hue-rotate(90deg);"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <!-- Order summary -->
                <p class="checkout-section-label">Order Summary</p>
                <div id="checkoutSummary" class="mb-4"></div>

                <!-- Contact details -->
                <p class="checkout-section-label">Your Details</p>
                <p style="font-size:.8rem; color:var(--text-muted-c); background:rgba(74,222,128,.07); border:1px solid rgba(74,222,128,.18); border-radius:8px; padding:10px 13px; line-height:1.7; margin-bottom:16px;">
                    📋 Provide your phone number so we can confirm your order and arrange discreet delivery.
                </p>
                <div class="mb-3">
                    <label class="checkout-label" for="checkoutPhone">Phone number</label>
                    <input type="tel" id="checkoutPhone" class="checkout-input" placeholder="+234 800 000 0000" autocomplete="tel">
                </div>
                <div class="mb-3">
                    <label class="checkout-label" for="checkoutPhone2">Second phone number <span style="color:var(--text-muted-c); font-weight:400;">(optional)</span></label>
                    <input type="tel" id="checkoutPhone2" class="checkout-input" placeholder="+234 800 000 0000" autocomplete="tel">
                </div>
            </div>
            <div class="modal-footer checkout-modal-footer">
                <button class="btn-checkout w-100" id="placeOrderBtn" onclick="submitOrder()">
                    <i class="bi bi-lock-fill"></i> Place Order
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================== TOAST CONTAINER ======================== -->
<div id="toast-container"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Products Data (injected from DB) -->
<script>const PRODUCTS = @json($products ?? []);</script>
<script src="/js/products.js"></script>
<!-- App JS -->
<script src="/js/app.js"></script>

@stack('scripts')
</body>
</html>
