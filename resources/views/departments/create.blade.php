@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add Department</h2>
    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('departments.store') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Department Code *</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                           value="{{ old('code') }}" required maxlength="20">
                    @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label">Department Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Department</button>
        </form>
    </div>
</div>
@endsection
