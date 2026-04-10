@extends('admin.layouts.app')

@section('title', 'Site Visitors')
@section('page-title', 'Site Visitors')

@section('content')
<div class="table-card">
    <div class="table-card-header">
        <span><i class="bi bi-people me-2"></i>Email Submissions</span>
        <span class="text-muted" style="font-size:.8rem;">{{ $visitors->total() }} total</span>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>IP Address</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visitors as $visitor)
                <tr>
                    <td class="text-muted" style="font-size:.8rem;">{{ $visitor->id }}</td>
                    <td>{{ $visitor->email }}</td>
                    <td style="font-size:.82rem; color:#6b7280;">{{ $visitor->ip ?? '—' }}</td>
                    <td style="font-size:.8rem; color:#6b7280;">{{ $visitor->created_at->format('M j, Y g:ia') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">No visitors yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($visitors->hasPages())
    <div class="p-3">
        {{ $visitors->links() }}
    </div>
    @endif
</div>
@endsection
