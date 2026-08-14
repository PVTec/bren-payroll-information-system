@extends('layouts.app')

@section('title', 'Compose Email')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-envelope-plus me-2"></i>Compose Email</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('emails.send') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-medium">Recipients</label>
                        <div class="recipient-selector border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            <div class="d-flex justify-content-between mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label fw-medium" for="selectAll">
                                        Select All Employees
                                    </label>
                                </div>
                                <span class="text-muted small">{{ $employees->count() }} employees</span>
                            </div>
                            <hr class="my-2">
                            @foreach($employees as $employee)
                                <div class="form-check py-1">
                                    <input class="form-check-input recipient-checkbox" type="checkbox" name="recipients[]" value="{{ $employee->id }}" id="emp_{{ $employee->id }}">
                                    <label class="form-check-label d-flex justify-content-between" for="emp_{{ $employee->id }}">
                                        <span>{{ $employee->full_name }}</span>
                                        <small class="text-muted">{{ $employee->department?->name ?? 'No Dept' }}</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('recipients')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="template" class="form-label">Email Template</label>
                        <select name="template" id="template" class="form-select @error('template') is-invalid @enderror" onchange="toggleCustomFields()">
                            @foreach($templates as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="customFields" style="display: none;">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" rows="8" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Send Email
                        </button>
                        <a href="{{ route('emails.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCustomFields() {
        const template = document.getElementById('template').value;
        const customFields = document.getElementById('customFields');
        if (template === 'custom') {
            customFields.style.display = 'block';
        } else {
            customFields.style.display = 'none';
        }
    }

    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.recipient-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    toggleCustomFields();
</script>
@endsection
