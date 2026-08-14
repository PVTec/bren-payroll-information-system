<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeductionSetting;

class DeductionSettingSeeder extends Seeder
{
    public function run(): void
    {
        // SSS Contribution (simplified tiered structure)
        DeductionSetting::create([
            'name' => 'SSS Contribution',
            'type' => 'tiered',
            'tier_data' => [
                ['min' => 0, 'max' => 3250, 'employee_share' => 135.00, 'employer_share' => 270.00],
                ['min' => 3250, 'max' => 3750, 'employee_share' => 157.50, 'employer_share' => 315.00],
                ['min' => 3750, 'max' => 4250, 'employee_share' => 180.00, 'employer_share' => 360.00],
                ['min' => 4250, 'max' => 4750, 'employee_share' => 202.50, 'employer_share' => 405.00],
                ['min' => 4750, 'max' => 5250, 'employee_share' => 225.00, 'employer_share' => 450.00],
                ['min' => 5250, 'max' => 5750, 'employee_share' => 247.50, 'employer_share' => 495.00],
                ['min' => 5750, 'max' => 6250, 'employee_share' => 270.00, 'employer_share' => 540.00],
                ['min' => 6250, 'max' => 6750, 'employee_share' => 292.50, 'employer_share' => 585.00],
                ['min' => 6750, 'max' => 7250, 'employee_share' => 315.00, 'employer_share' => 630.00],
                ['min' => 7250, 'max' => 7750, 'employee_share' => 337.50, 'employer_share' => 675.00],
                ['min' => 7750, 'max' => 8250, 'employee_share' => 360.00, 'employer_share' => 720.00],
                ['min' => 8250, 'max' => 8750, 'employee_share' => 382.50, 'employer_share' => 765.00],
                ['min' => 8750, 'max' => 9250, 'employee_share' => 405.00, 'employer_share' => 810.00],
                ['min' => 9250, 'max' => 9750, 'employee_share' => 427.50, 'employer_share' => 855.00],
                ['min' => 9750, 'max' => 10250, 'employee_share' => 450.00, 'employer_share' => 900.00],
                ['min' => 10250, 'max' => 10750, 'employee_share' => 472.50, 'employer_share' => 945.00],
                ['min' => 10750, 'max' => 11250, 'employee_share' => 495.00, 'employer_share' => 990.00],
                ['min' => 11250, 'max' => 11750, 'employee_share' => 517.50, 'employer_share' => 1035.00],
                ['min' => 11750, 'max' => 12250, 'employee_share' => 540.00, 'employer_share' => 1080.00],
                ['min' => 12250, 'max' => 12750, 'employee_share' => 562.50, 'employer_share' => 1125.00],
                ['min' => 12750, 'max' => 13250, 'employee_share' => 585.00, 'employer_share' => 1170.00],
                ['min' => 13250, 'max' => 13750, 'employee_share' => 607.50, 'employer_share' => 1215.00],
                ['min' => 13750, 'max' => 14250, 'employee_share' => 630.00, 'employer_share' => 1260.00],
                ['min' => 14250, 'max' => 14750, 'employee_share' => 652.50, 'employer_share' => 1305.00],
                ['min' => 14750, 'max' => 15250, 'employee_share' => 675.00, 'employer_share' => 1350.00],
                ['min' => 15250, 'max' => 15750, 'employee_share' => 697.50, 'employer_share' => 1395.00],
                ['min' => 15750, 'max' => 16250, 'employee_share' => 720.00, 'employer_share' => 1440.00],
                ['min' => 16250, 'max' => 16750, 'employee_share' => 742.50, 'employer_share' => 1485.00],
                ['min' => 16750, 'max' => 17250, 'employee_share' => 765.00, 'employer_share' => 1530.00],
                ['min' => 17250, 'max' => 17750, 'employee_share' => 787.50, 'employer_share' => 1575.00],
                ['min' => 17750, 'max' => 18250, 'employee_share' => 810.00, 'employer_share' => 1620.00],
                ['min' => 18250, 'max' => 18750, 'employee_share' => 832.50, 'employer_share' => 1665.00],
                ['min' => 18750, 'max' => 19250, 'employee_share' => 855.00, 'employer_share' => 1710.00],
                ['min' => 19250, 'max' => 19750, 'employee_share' => 877.50, 'employer_share' => 1755.00],
                ['min' => 19750, 'max' => 20250, 'employee_share' => 900.00, 'employer_share' => 1800.00],
                ['min' => 20250, 'max' => 20750, 'employee_share' => 922.50, 'employer_share' => 1845.00],
                ['min' => 20750, 'max' => 21250, 'employee_share' => 945.00, 'employer_share' => 1890.00],
                ['min' => 21250, 'max' => 21750, 'employee_share' => 967.50, 'employer_share' => 1935.00],
                ['min' => 21750, 'max' => 22250, 'employee_share' => 990.00, 'employer_share' => 1980.00],
                ['min' => 22250, 'max' => 22750, 'employee_share' => 1012.50, 'employer_share' => 2025.00],
                ['min' => 22750, 'max' => 23250, 'employee_share' => 1035.00, 'employer_share' => 2070.00],
                ['min' => 23250, 'max' => 23750, 'employee_share' => 1057.50, 'employer_share' => 2115.00],
                ['min' => 23750, 'max' => 24250, 'employee_share' => 1080.00, 'employer_share' => 2160.00],
                ['min' => 24250, 'max' => 24750, 'employee_share' => 1102.50, 'employer_share' => 2205.00],
                ['min' => 24750, 'max' => PHP_INT_MAX, 'employee_share' => 1125.00, 'employer_share' => 2250.00],
            ],
            'is_active' => true,
        ]);

        // PhilHealth (percentage based)
        DeductionSetting::create([
            'name' => 'PhilHealth Contribution',
            'type' => 'percentage',
            'employee_share' => 2.5,
            'employer_share' => 2.5,
            'is_active' => true,
        ]);

        // Pag-IBIG (fixed amount)
        DeductionSetting::create([
            'name' => 'Pag-IBIG Contribution',
            'type' => 'fixed',
            'fixed_amount' => 100.00,
            'employer_share' => 100.00,
            'is_active' => true,
        ]);
    }
}
