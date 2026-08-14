@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Employee: {{ $employee->full_name }}</h2>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @csrf
            @method('PUT')
            
            <h5 class="mb-3 text-primary">Personal Information</h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                           value="{{ old('first_name', $employee->first_name) }}" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $employee->middle_name) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                           value="{{ old('last_name', $employee->last_name) }}" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Date of Birth *</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                           value="{{ old('date_of_birth', $employee->date_of_birth->format('Y-m-d')) }}" required>
                    @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Contact Number *</label>
                    <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" 
                           value="{{ old('contact_number', $employee->contact_number) }}" required>
                    @error('contact_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $employee->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Address *</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="1" required>{{ old('address', $employee->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3 text-primary">Employment Details</h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Employee ID *</label>
                    <input type="text" name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" 
                           value="{{ old('employee_id', $employee->employee_id) }}" required>
                    @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Department *</label>
                    <select name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Position *</label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror" 
                           value="{{ old('position', $employee->position) }}" required>
                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Hire Date *</label>
                    <input type="date" name="hire_date" class="form-control @error('hire_date') is-invalid @enderror" 
                           value="{{ old('hire_date', $employee->hire_date->format('Y-m-d')) }}" required>
                    @error('hire_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Salary Type *</label>
                    <select name="salary_type" class="form-select @error('salary_type') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        <option value="monthly" {{ old('salary_type', $employee->salary_type) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="daily" {{ old('salary_type', $employee->salary_type) == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="hourly" {{ old('salary_type', $employee->salary_type) == 'hourly' ? 'selected' : '' }}>Hourly</option>
                    </select>
                    @error('salary_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Basic Salary *</label>
                    <input type="number" step="0.01" name="basic_salary" class="form-control @error('basic_salary') is-invalid @enderror" 
                           value="{{ old('basic_salary', $employee->basic_salary) }}" required>
                    @error('basic_salary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <hr class="my-4">
            <h5 class="mb-3 text-primary">Government ID Numbers</h5>

            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">SSS Number</label>
                    <input type="text" name="sss_number" class="form-control" value="{{ old('sss_number', $employee->sss_number) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">PhilHealth Number</label>
                    <input type="text" name="philhealth_number" class="form-control" value="{{ old('philhealth_number', $employee->philhealth_number) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pag-IBIG Number</label>
                    <input type="text" name="pagibig_number" class="form-control" value="{{ old('pagibig_number', $employee->pagibig_number) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">TIN Number</label>
                    <input type="text" name="tin_number" class="form-control" value="{{ old('tin_number', $employee->tin_number) }}">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Employee</button>
            </div>
        </form>
    </div>
</div>
@endsection
