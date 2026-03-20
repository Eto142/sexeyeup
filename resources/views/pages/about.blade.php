@extends('layouts.app')

@section('title', 'About — SexEyeUp')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <span class="page-header-tag">🌿 Our Story</span>
    <h1>About <span>SexEyeUp</span></h1>
    <p>Born from a passion for premium cannabis, built for a community that demands better.</p>
</div>

<!-- Mission Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-tag">🎯 Our Mission</span>
                <h2 class="section-title mt-2">Green is Our <span>Religion</span></h2>
                <p style="color:var(--text-muted-c); font-size:.95rem; line-height:1.85; margin-top:16px;">
                    SexEyeUp was founded with one goal: make premium, lab-tested cannabis accessible, affordable, and fully deserving of your trust. We work directly with organic farms to source only the finest flower, concentrates, and edibles — then ship them discreetly to your door.
                </p>
                <p style="color:var(--text-muted-c); font-size:.95rem; line-height:1.85; margin-top:12px;">
                    Every product on our shelves carries a certificate of analysis. No guessing games. No mystery. Just pure, clean cannabis the way it was always meant to be enjoyed.
                </p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="/shop" class="btn-hero">Browse Products</a>
                    <a href="/deals" class="btn-hero-outline">See Deals</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">🌱</div>
                            <div class="feature-title">Organic Farms</div>
                            <div style="font-family:'Bebas Neue',cursive; font-size:2.2rem; color:var(--green-neon); margin:6px 0;">12+</div>
                            <div class="feature-text">Partnered farms across 6 states</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">👥</div>
                            <div class="feature-title">Happy Customers</div>
                            <div style="font-family:'Bebas Neue',cursive; font-size:2.2rem; color:var(--green-neon); margin:6px 0;">50K+</div>
                            <div class="feature-text">Satisfied orders delivered</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">🔬</div>
                            <div class="feature-title">Lab Tests</div>
                            <div style="font-family:'Bebas Neue',cursive; font-size:2.2rem; color:var(--green-neon); margin:6px 0;">100%</div>
                            <div class="feature-text">Every batch tested, every time</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">⭐</div>
                            <div class="feature-title">Avg. Rating</div>
                            <div style="font-family:'Bebas Neue',cursive; font-size:2.2rem; color:var(--gold); margin:6px 0;">4.8</div>
                            <div class="feature-text">Across 12,000+ verified reviews</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="py-5" style="background:var(--bg-card);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">📅 Our Journey</span>
            <h2 class="section-title">From <span>Seed</span> to Store</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-year">2019</div>
                        <p class="timeline-text">SexEyeUp is founded in a small apartment with a big dream: democratise access to quality cannabis. First 10 orders shipped from a kitchen table.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-year">2020</div>
                        <p class="timeline-text">Partnered with 3 organic farms. Launched our first online storefront. Processed 5,000 orders in year one.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-year">2022</div>
                        <p class="timeline-text">Expanded to 10+ farm partners. Introduced edibles and concentrates. Hit the 25,000 customer milestone. Opened our first customer support team.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-year">2024</div>
                        <p class="timeline-text">Launched the SexEyeUp Loyalty Program. Over 50,000 happy customers. Full lab-result transparency on every product page.</p>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-year">2026</div>
                        <p class="timeline-text">New website, new products, same commitment to quality. Thank you for being part of the journey. Stay green. 🌿</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">👋 Meet the Team</span>
            <h2 class="section-title">The <span>People</span> Behind the Green</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @php
            $team = [
                ['emoji'=>'🧑‍🌾','name'=>'Marcus K.','role'=>'Founder & Head Cultivator','bio'=>'Cannabis connoisseur for 15+ years. Personally visits every farm we partner with.'],
                ['emoji'=>'👩‍🔬','name'=>'Dr. Priya S.','role'=>'Head of Quality & Lab Relations','bio'=>'PhD in plant biochemistry. Oversees all third-party testing and COA verification.'],
                ['emoji'=>'🧑‍💻','name'=>'Jordan T.','role'=>'Tech & Operations Lead','bio'=>'Keeps the store running smoothly 24/7. Obsessed with fast, discreet delivery.'],
                ['emoji'=>'👩‍🎨','name'=>'Lexi M.','role'=>'Brand & Community Manager','bio'=>'Builds the SexEyeUp community. Your biggest hype person and support rep.'],
            ];
            @endphp
            @foreach($team as $member)
            <div class="col-sm-6 col-lg-3">
                <div class="feature-card text-center">
                    <div style="font-size:3rem; margin-bottom:12px;">{{ $member['emoji'] }}</div>
                    <div class="feature-title">{{ $member['name'] }}</div>
                    <div style="font-size:.76rem; color:var(--green-neon); font-weight:600; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase;">{{ $member['role'] }}</div>
                    <div class="feature-text">{{ $member['bio'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-5" style="background:var(--bg-card2); border-top:1px solid var(--border-subtle); border-bottom:1px solid var(--border-subtle);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="section-tag">💡 Core Values</span>
            <h2 class="section-title">What We <span>Stand For</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3"><div class="feature-card"><div class="feature-icon">🔬</div><div class="feature-title">Transparency</div><div class="feature-text">Every product has a public COA. No hidden ingredients. No secrets.</div></div></div>
            <div class="col-sm-6 col-lg-3"><div class="feature-card"><div class="feature-icon">🌍</div><div class="feature-title">Sustainability</div><div class="feature-text">We only work with farms that use regenerative, eco-friendly growing practices.</div></div></div>
            <div class="col-sm-6 col-lg-3"><div class="feature-card"><div class="feature-icon">🔒</div><div class="feature-title">Privacy First</div><div class="feature-text">Plain packaging, encrypted orders, zero data sharing. Your business stays yours.</div></div></div>
            <div class="col-sm-6 col-lg-3"><div class="feature-card"><div class="feature-icon">❤️</div><div class="feature-title">Community</div><div class="feature-text">A portion of every sale supports cannabis equity and social justice initiatives.</div></div></div>
        </div>
    </div>
</section>

@endsection
