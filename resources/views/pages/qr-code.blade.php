@extends('layouts.app')

@section('title', 'SexEyeUp — Scan & Shop')

@push('styles')
<style>
    /* ── Page wrapper ─────────────────────────────────────────── */
    .qr-page {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        position: relative;
        overflow: hidden;
    }

    /* ── Floating orbs background ─────────────────────────────── */
    .qr-page::before,
    .qr-page::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.18;
        pointer-events: none;
        animation: floatOrb 8s ease-in-out infinite alternate;
    }
    .qr-page::before {
        width: 420px; height: 420px;
        background: var(--green-neon);
        top: -120px; left: -120px;
    }
    .qr-page::after {
        width: 320px; height: 320px;
        background: var(--green-bright);
        bottom: -80px; right: -80px;
        animation-delay: -4s;
    }
    @keyframes floatOrb {
        from { transform: translate(0,0) scale(1); }
        to   { transform: translate(30px, 20px) scale(1.08); }
    }

    /* ── Card ─────────────────────────────────────────────────── */
    .qr-card {
        background: var(--bg-card);
        border-radius: 24px;
        padding: 3rem 2.5rem 2.5rem;
        text-align: center;
        max-width: 420px;
        width: 100%;
        position: relative;
        z-index: 2;

        /* animated neon border via gradient + pseudo */
        box-shadow:
            0 0 0 1px rgba(90,173,63,0.35),
            0 0 40px rgba(162,245,99,0.12),
            0 24px 60px rgba(0,0,0,0.55);
        animation: cardPulse 4s ease-in-out infinite alternate;
    }
    @keyframes cardPulse {
        from { box-shadow: 0 0 0 1px rgba(90,173,63,0.35), 0 0 40px rgba(162,245,99,0.12), 0 24px 60px rgba(0,0,0,0.55); }
        to   { box-shadow: 0 0 0 1px rgba(162,245,99,0.6),  0 0 70px rgba(162,245,99,0.22), 0 24px 60px rgba(0,0,0,0.55); }
    }

    /* ── Heading ──────────────────────────────────────────────── */
    .qr-label {
        display: inline-block;
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--green-neon);
        background: rgba(162,245,99,0.08);
        border: 1px solid rgba(162,245,99,0.25);
        border-radius: 50px;
        padding: 4px 14px;
        margin-bottom: 1rem;
    }
    .qr-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.6rem;
        letter-spacing: .05em;
        color: var(--text-white);
        line-height: 1.05;
        margin-bottom: .35rem;
    }
    .qr-title span { color: var(--green-neon); }
    .qr-sub {
        font-size: .85rem;
        color: var(--text-muted-c);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* ── QR wrapper ───────────────────────────────────────────── */
    .qr-frame {
        position: relative;
        display: inline-block;
        margin-bottom: 1.75rem;
    }

    /* corner brackets */
    .qr-frame::before,
    .qr-frame::after,
    .qr-frame .corner-br,
    .qr-frame .corner-bl {
        content: '';
        position: absolute;
        width: 22px; height: 22px;
        border-color: var(--green-neon);
        border-style: solid;
        z-index: 3;
        transition: all .3s;
    }
    .qr-frame::before  { top: -4px;    left: -4px;  border-width: 3px 0 0 3px; border-radius: 4px 0 0 0; }
    .qr-frame::after   { top: -4px;    right: -4px; border-width: 3px 3px 0 0; border-radius: 0 4px 0 0; }
    .qr-frame .corner-br { bottom: -4px; right: -4px; border-width: 0 3px 3px 0; border-radius: 0 0 4px 0; }
    .qr-frame .corner-bl { bottom: -4px; left: -4px;  border-width: 0 0 3px 3px; border-radius: 0 0 0 4px; }
    .qr-frame:hover::before,
    .qr-frame:hover::after,
    .qr-frame:hover .corner-br,
    .qr-frame:hover .corner-bl { border-color: #fff; width: 30px; height: 30px; }

    /* scan line animation */
    .qr-scan-line {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent 0%, var(--green-neon) 50%, transparent 100%);
        box-shadow: 0 0 10px var(--green-neon), 0 0 20px rgba(162,245,99,0.5);
        animation: scan 2.8s ease-in-out infinite;
        z-index: 4;
        border-radius: 2px;
    }
    @keyframes scan {
        0%   { top: 0%;   opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }

    /* the QR canvas itself */
    #qrcode canvas,
    #qrcode img {
        border-radius: 12px;
        display: block;
    }
    .qr-inner {
        background: #fff;
        border-radius: 14px;
        padding: 14px;
        display: inline-block;
        position: relative;
        z-index: 2;
    }

    /* ── URL pill ─────────────────────────────────────────────── */
    .qr-url {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .6rem;
        background: var(--bg-card2);
        border: 1px solid var(--border-subtle);
        border-radius: 10px;
        padding: .55rem .9rem;
        margin-bottom: 1.5rem;
        font-size: .8rem;
        color: var(--text-muted-c);
        font-family: 'Courier New', monospace;
        word-break: break-all;
        text-align: left;
    }
    .qr-url-text { flex: 1; }
    .copy-btn {
        background: none;
        border: none;
        color: var(--green-neon);
        cursor: pointer;
        padding: 0 4px;
        font-size: 1rem;
        flex-shrink: 0;
        transition: transform .2s, color .2s;
    }
    .copy-btn:hover { transform: scale(1.2); color: #fff; }

    /* ── Action buttons ───────────────────────────────────────── */
    .qr-actions {
        display: flex;
        gap: .75rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    .btn-qr-primary {
        background: linear-gradient(135deg, var(--green-main) 0%, var(--green-bright) 100%);
        color: #0d1f0d;
        border: none;
        border-radius: 10px;
        padding: .65rem 1.4rem;
        font-weight: 700;
        font-size: .88rem;
        letter-spacing: .03em;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        transition: filter .25s, transform .2s;
        text-decoration: none;
    }
    .btn-qr-primary:hover { filter: brightness(1.15); transform: translateY(-2px); color: #0d1f0d; }

    .btn-qr-outline {
        background: transparent;
        color: var(--green-neon);
        border: 1px solid rgba(162,245,99,0.4);
        border-radius: 10px;
        padding: .65rem 1.4rem;
        font-weight: 600;
        font-size: .88rem;
        letter-spacing: .03em;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        transition: background .25s, border-color .25s, transform .2s;
        text-decoration: none;
    }
    .btn-qr-outline:hover {
        background: rgba(162,245,99,0.08);
        border-color: var(--green-neon);
        transform: translateY(-2px);
        color: var(--green-neon);
    }

    /* ── Toast notification ───────────────────────────────────── */
    .qr-toast {
        position: fixed;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: var(--green-neon);
        color: #0d1f0d;
        font-weight: 700;
        font-size: .85rem;
        padding: .6rem 1.4rem;
        border-radius: 50px;
        opacity: 0;
        pointer-events: none;
        transition: opacity .3s, transform .3s;
        z-index: 9999;
        white-space: nowrap;
    }
    .qr-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    /* ── Bottom hint ──────────────────────────────────────────── */
    .qr-hint {
        font-size: .75rem;
        color: var(--text-muted-c);
        margin-top: 1.5rem;
        opacity: .7;
    }
    .qr-hint i { font-size: .8rem; }
</style>
@endpush

@section('content')
<div class="qr-page">
    <div class="qr-card">

        <span class="qr-label">&#128247; Scan to Visit</span>

        <h1 class="qr-title">Scan. Shop.<br><span>Get Lifted.</span></h1>
        <p class="qr-sub">Point your camera at the code to open<br>the SexEyeUp store instantly.</p>

        <!-- QR Frame -->
        <div class="qr-frame">
            <div class="corner-br"></div>
            <div class="corner-bl"></div>
            <div class="qr-scan-line"></div>
            <div class="qr-inner">
                <div id="qrcode"></div>
            </div>
        </div>

        <!-- URL pill -->
        <div class="qr-url">
            <span class="qr-url-text" id="siteUrl">https://sexeyeup.com/</span>
            <button class="copy-btn" onclick="copyUrl()" title="Copy link">
                <i class="bi bi-clipboard" id="copyIcon"></i>
            </button>
        </div>

        <!-- Action buttons -->
        <div class="qr-actions">
            <button class="btn-qr-primary" onclick="downloadQR()">
                <i class="bi bi-download"></i> Download PNG
            </button>
            <button class="btn-qr-outline" onclick="shareUrl()">
                <i class="bi bi-share"></i> Share
            </button>
        </div>

        <p class="qr-hint">
            <i class="bi bi-info-circle"></i>
            Works with any camera app &mdash; no extra app needed.
        </p>

    </div>
</div>

<!-- Toast -->
<div class="qr-toast" id="qrToast"></div>

<!-- QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const SITE_URL = "https://sexeyeup.com/";

    // Generate QR code
    const qr = new QRCode(document.getElementById("qrcode"), {
        text: SITE_URL,
        width: 200,
        height: 200,
        colorDark: "#0d1f0d",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H,
    });

    // ── Download ──────────────────────────────────────────────────
    function downloadQR() {
        const canvas = document.querySelector("#qrcode canvas");
        if (!canvas) return toast("QR not ready yet");

        // Draw on a padded canvas
        const pad = 20;
        const out = document.createElement("canvas");
        out.width  = canvas.width  + pad * 2;
        out.height = canvas.height + pad * 2;
        const ctx = out.getContext("2d");
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, out.width, out.height);
        ctx.drawImage(canvas, pad, pad);

        const link = document.createElement("a");
        link.download = "sexeyeup-qr.png";
        link.href = out.toDataURL("image/png");
        link.click();
        toast("✓ QR code downloaded!");
    }

    // ── Copy URL ──────────────────────────────────────────────────
    async function copyUrl() {
        try {
            await navigator.clipboard.writeText(SITE_URL);
            document.getElementById("copyIcon").className = "bi bi-clipboard-check";
            toast("✓ Link copied to clipboard!");
            setTimeout(() => {
                document.getElementById("copyIcon").className = "bi bi-clipboard";
            }, 2000);
        } catch {
            toast("Copy not supported on this browser.");
        }
    }

    // ── Share (Web Share API) ─────────────────────────────────────
    async function shareUrl() {
        if (navigator.share) {
            try {
                await navigator.share({
                    title: "SexEyeUp — Premium Cannabis Store",
                    text: "Check out SexEyeUp — premium quality, fast delivery.",
                    url: SITE_URL,
                });
            } catch {/* user cancelled */}
        } else {
            copyUrl();
        }
    }

    // ── Toast helper ──────────────────────────────────────────────
    function toast(msg) {
        const el = document.getElementById("qrToast");
        el.textContent = msg;
        el.classList.add("show");
        setTimeout(() => el.classList.remove("show"), 2500);
    }
</script>
@endsection
