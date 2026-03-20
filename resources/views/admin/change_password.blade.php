@extends('admin.layouts.app')

@section('title', 'Change Password')
@section('page-title', 'Change Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="table-card p-4">
            <h5 class="fw-semibold mb-4" style="color:#111827;">Change Password</h5>

            <form action="{{ route('admin.change.password.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="current_password" class="form-label fw-medium" style="font-size:.875rem;">Current Password</label>
                    <input type="password"
                           class="form-control @error('current_password') is-invalid @enderror"
                           id="current_password"
                           name="current_password"
                           required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-medium" style="font-size:.875rem;">New Password</label>
                    <input type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           id="password"
                           name="password"
                           required
                           minlength="8">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-medium" style="font-size:.875rem;">Confirm New Password</label>
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           minlength="8">
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-lock-fill me-1"></i> Update Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
