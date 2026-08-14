@extends('layouts.app')

@section('title', 'Email Management')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Email Management</h2>
            <a href="{{ route('emails.compose') }}" class="btn btn-primary">
                <i class="bi bi-envelope-plus me-2"></i>Compose Email
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Emails</div>
                </div>
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-envelope"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-success">{{ $stats['sent'] }}</div>
                    <div class="stat-label">Sent</div>
                </div>
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Pending</div>
                </div>
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="stat-value text-danger">{{ $stats['failed'] }}</div>
                    <div class="stat-label">Failed</div>
                </div>
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-x-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">Email History</h5>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('emails.index') }}" class="d-flex gap-2">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Recipient</th>
                                <th>Subject</th>
                                <th>Template</th>
                                <th>Status</th>
                                <th>Sent At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emails as $email)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 12px;">
                                                {{ substr($email->recipient_name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $email->recipient_name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ $email->recipient_email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($email->subject, 40) }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ str_replace('_', ' ', $email->template) }}</span>
                                    </td>
                                    <td>
                                        @if($email->status === 'sent')
                                            <span class="badge bg-success">Sent</span>
                                        @elseif($email->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $email->sent_at ? $email->sent_at->format('M d, Y H:i') : '-' }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('emails.show', $email) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($email->status === 'failed')
                                                <form action="{{ route('emails.retry', $email) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning" title="Retry">
                                                        <i class="bi bi-arrow-clockwise"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="bi bi-envelope-slash fs-1"></i>
                                            <p class="mt-2">No emails found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($emails->hasPages())
                <div class="card-footer">
                    {{ $emails->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
