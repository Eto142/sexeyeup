@extends('admin.layouts.app')

@section('title', 'Send Email')
@section('page-title', 'Send Email')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="table-card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-envelope me-2"></i>Compose Email</h5>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.send.email.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="to" class="form-label fw-semibold">To</label>
                    <input type="email" name="to" id="to" class="form-control @error('to') is-invalid @enderror"
                           placeholder="recipient@example.com" value="{{ old('to') }}" required>
                    @error('to')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label fw-semibold">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror"
                           placeholder="Email subject" value="{{ old('subject') }}" required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="message" class="form-label fw-semibold">Message</label>
                    <textarea name="message" id="message" rows="8"
                              class="form-control @error('message') is-invalid @enderror"
                              placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> Send Email
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">Clear</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
