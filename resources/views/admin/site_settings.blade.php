@extends('admin.layouts.app')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="card" style="border-radius:10px; border:1px solid #e5e7eb;">
            <div class="card-body p-4">
                <h5 class="mb-1 fw-semibold">Site Passcode</h5>
                <p class="text-muted mb-4" style="font-size:.875rem;">
                    Set a passcode that visitors must enter before accessing the site.
                    Leave the field empty and save to <strong>remove</strong> passcode protection.
                </p>

                @if($currentPasscode)
                <div class="mb-3 p-3 rounded" style="background:#dcfce7; border:1px solid #86efac; font-size:.875rem;">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-lock-fill text-success"></i>
                        <span class="text-success fw-semibold">Passcode is currently active</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <span class="text-muted" style="font-size:.8rem;">Current passcode:</span>
                        <code id="passcode-display" style="background:#fff; padding:.25rem .6rem; border-radius:6px; border:1px solid #86efac; letter-spacing:.1em; font-size:.95rem; filter:blur(4px); cursor:pointer;" title="Click to reveal">{{ $currentPasscode }}</code>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0" onclick="togglePasscode()" id="toggle-btn" style="font-size:.75rem;">Show</button>
                    </div>
                </div>
                @else
                <div class="mb-3 p-3 rounded d-flex align-items-center gap-2"
                     style="background:#fef9c3; border:1px solid #fde047; font-size:.875rem;">
                    <i class="bi bi-unlock-fill" style="color:#ca8a04;"></i>
                    <span style="color:#92400e; font-weight:600;">No passcode set — site is publicly accessible.</span>
                </div>
                @endif

                <form action="{{ route('admin.site-settings.passcode') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.875rem;">
                            New Passcode
                        </label>
                        <input
                            type="text"
                            name="passcode"
                            class="form-control @error('passcode') is-invalid @enderror"
                            placeholder="Enter new passcode (leave empty to disable)"
                            autocomplete="off"
                        >
                        @error('passcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Minimum 4 characters. Visitors will need this to access the site.</div>
                    </div>

                    <button type="submit" class="btn btn-success px-4">Save Passcode</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let revealed = false;
    function togglePasscode() {
        const el  = document.getElementById('passcode-display');
        const btn = document.getElementById('toggle-btn');
        revealed = !revealed;
        el.style.filter  = revealed ? 'none' : 'blur(4px)';
        btn.textContent  = revealed ? 'Hide' : 'Show';
    }
</script>
@endpush
@endsection
