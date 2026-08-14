<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Human Resources', 'code' => 'HR', 'description' => 'HR Department'],
            ['name' => 'Finance', 'code' => 'FIN', 'description' => 'Finance and Accounting'],
            ['name' => 'Information Technology', 'code' => 'IT', 'description' => 'IT Department'],
            ['name' => 'Sales', 'code' => 'SAL', 'description' => 'Sales Department'],
            ['name' => 'Operations', 'code' => 'OPS', 'description' => 'Operations Department'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }

        // Create sample employee for demo employee user
        $user = User::where('email', 'employee@payroll.com')->first();
        if ($user) {
            Employee::create([
                'user_id' => $user->id,
                'department_id' => 1,
                'employee_id' => 'EMP001',
                'first_name' => 'John',
                'last_name' => 'Employee',
                'middle_name' => 'Doe',
                'date_of_birth' => '1990-01-15',
                'gender' => 'male',
                'contact_number' => '09123456789',
                'email' => 'employee@payroll.com',
                'address' => '123 Sample Street, City',
                'hire_date' => '2020-06-01',
                'position' => 'Staff',
                'salary_type' => 'monthly',
                'basic_salary' => 25000,
                'status' => 'active',
                'sss_number' => '1234567890',
                'philhealth_number' => '9876543210',
                'pagibig_number' => '1122334455',
                'tin_number' => '000123456',
            ]);
        }
    }
}
