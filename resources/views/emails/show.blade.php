@extends('layouts.app')

@section('title', 'Email Details')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Email Details</h5>
                <span class="badge bg-{{ $email->status === 'sent' ? 'success' : ($email->status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($email->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150" class="text-muted">Recipient</td>
                            <td>
                                <strong>{{ $email->recipient_name ?? 'Unknown' }}</strong><br>
                                <small>{{ $email->recipient_email }}</small>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Subject</td>
                            <td><strong>{{ $email->subject }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Template</td>
                            <td><span class="badge bg-info">{{ str_replace('_', ' ', $email->template) }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Sent At</td>
                            <td>{{ $email->sent_at ? $email->sent_at->format('F d, Y H:i:s') : 'Not sent yet' }}</td>
                        </tr>
                        @if($email->mailable)
                            <tr>
                                <td class="text-muted">Related To</td>
                                <td>{{ class_basename($email->mailable_type) }} #{{ $email->mailable_id }}</td>
                            </tr>
                        @endif
                    </table>
                </div>

                @if($email->body)
                    <hr>
                    <div class="mb-3">
                        <h6>Email Body</h6>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($email->body)) !!}
                        </div>
                    </div>
                @endif

                @if($email->error_message)
                    <hr>
                    <div class="alert alert-danger">
                        <h6>Error Message</h6>
                        <p class="mb-0">{{ $email->error_message }}</p>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="d-flex gap-2">
                    <a href="{{ route('emails.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to List
                    </a>
                    @if($email->status === 'failed')
                        <form action="{{ route('emails.retry', $email) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-arrow-clockwise me-2"></i>Retry Send
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
