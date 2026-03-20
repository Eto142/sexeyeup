@extends('layouts.app')

@section('title', 'How to Order — SexEyeUp')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <span class="page-header-tag">🛒 Ordering Guide</span>
    <h1>How to <span>Order</span></h1>
    <p>Simple, discreet, and delivered to your door in just a few steps.</p>
</div>

<!-- Steps Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">📋 Step by Step</span>
            <h2 class="section-title">Placing Your <span>Order</span></h2>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Step 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon">🛍️</div>
                    <div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--green-neon); margin:6px 0 4px;">01</div>
                    <div class="feature-title">Browse the Shop</div>
                    <p class="feature-text mt-2">
                        Head over to our <a href="/shop" style="color:var(--green-neon); text-decoration:none;">Shop</a> and explore our full catalogue of premium strains, concentrates, and more. Filter by category or use the search bar to find exactly what you're after.
                    </p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon">🛒</div>
                    <div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--green-neon); margin:6px 0 4px;">02</div>
                    <div class="feature-title">Add to Cart</div>
                    <p class="feature-text mt-2">
                        Select your desired quantity and click <strong style="color:var(--text-white);">Add to Cart</strong>. You can add multiple products and review everything in your cart before proceeding.
                    </p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon">📝</div>
                    <div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--green-neon); margin:6px 0 4px;">03</div>
                    <div class="feature-title">Review Your Cart</div>
                    <p class="feature-text mt-2">
                        Open your cart by clicking the <strong style="color:var(--text-white);">Cart</strong> button in the top right. Check your items, adjust quantities, or remove anything you don't need.
                    </p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon">📦</div>
                    <div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--green-neon); margin:6px 0 4px;">04</div>
                    <div class="feature-title">Enter Your Details</div>
                    <p class="feature-text mt-2">
                        Fill in your delivery address and contact information. All details are kept strictly confidential and used solely for fulfilling your order.
                    </p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon">💳</div>
                    <div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--green-neon); margin:6px 0 4px;">05</div>
                    <div class="feature-title">Place Your Order</div>
                    <p class="feature-text mt-2">
                        Hit <strong style="color:var(--text-white);">Place Order</strong> to confirm. You'll receive a confirmation with your order details and an estimated delivery window.
                    </p>
                </div>
            </div>

            <!-- Step 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="feature-card text-center h-100">
                    <div class="feature-icon">🚚</div>
                    <div style="font-family:'Bebas Neue',cursive; font-size:3rem; color:var(--green-neon); margin:6px 0 4px;">06</div>
                    <div class="feature-title">Sit Back & Wait</div>
                    <p class="feature-text mt-2">
                        Your order is packed discreetly and dispatched promptly. Expect delivery within the timeframe provided in your confirmation.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5" style="background:var(--bg-card);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">❓ FAQs</span>
            <h2 class="section-title">Common <span>Questions</span></h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">

                    <div class="accordion-item" style="background:var(--bg-section); border:1px solid var(--border-c); border-radius:12px; margin-bottom:12px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1"
                                style="background:transparent; color:var(--text-white); font-weight:600; border-radius:12px;">
                                How do I pay for my order?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color:var(--text-muted-c); font-size:.93rem; line-height:1.8;">
                                Payment instructions are provided after you place your order. We support several secure payment methods and will guide you through the process via your confirmation details.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" style="background:var(--bg-section); border:1px solid var(--border-c); border-radius:12px; margin-bottom:12px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2"
                                style="background:transparent; color:var(--text-white); font-weight:600; border-radius:12px;">
                                Is my order packaged discreetly?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color:var(--text-muted-c); font-size:.93rem; line-height:1.8;">
                                Yes. Every order ships in plain, unmarked packaging with no identifiable branding on the outside. Your privacy is our priority.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" style="background:var(--bg-section); border:1px solid var(--border-c); border-radius:12px; margin-bottom:12px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3"
                                style="background:transparent; color:var(--text-white); font-weight:600; border-radius:12px;">
                                How long does delivery take?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color:var(--text-muted-c); font-size:.93rem; line-height:1.8;">
                                Delivery times vary by location. You'll receive an estimated timeframe in your order confirmation. We work hard to get your order to you as quickly as possible.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" style="background:var(--bg-section); border:1px solid var(--border-c); border-radius:12px; margin-bottom:12px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4"
                                style="background:transparent; color:var(--text-white); font-weight:600; border-radius:12px;">
                                Can I change or cancel my order?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color:var(--text-muted-c); font-size:.93rem; line-height:1.8;">
                                If you need to make changes or cancel, please reach out to us as soon as possible after placing your order. Once dispatched, orders cannot be cancelled.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" style="background:var(--bg-section); border:1px solid var(--border-c); border-radius:12px; margin-bottom:12px;">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5"
                                style="background:transparent; color:var(--text-white); font-weight:600; border-radius:12px;">
                                What if there's an issue with my order?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color:var(--text-muted-c); font-size:.93rem; line-height:1.8;">
                                If anything is wrong with your order — wrong items, damaged goods, or a missing parcel — contact us straight away with your order details and we'll make it right.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5">
    <div class="container text-center">
        <span class="section-tag">🌿 Ready?</span>
        <h2 class="section-title mt-2">Start <span>Shopping</span></h2>
        <p style="color:var(--text-muted-c); margin:12px auto 28px; max-width:460px; font-size:.93rem;">
            Browse our full selection of premium cannabis products and place your order in minutes.
        </p>
        <a href="/shop" class="btn-hero">Shop Now</a>
    </div>
</section>

@endsection
