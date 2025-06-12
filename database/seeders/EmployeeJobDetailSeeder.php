<?php

namespace Database\Seeders;

use App\Models\EmployeeShift;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\SpecificArea;
use Illuminate\Database\Seeder;
use App\Models\EmploymentStatus;
use Illuminate\Support\Facades\DB;

class EmployeeJobDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all()->map(function ($item) {
            // Get records with null safety
            $jobTitle = JobTitle::inRandomOrder()->first();
            $area = SpecificArea::inRandomOrder()->first();
            $shift = EmployeeShift::inRandomOrder()->first();
            $empStatus = EmploymentStatus::inRandomOrder()->first();

            // Create fallback records if none exist
            if (!$jobTitle) {
                $jobTitle = JobTitle::factory()->create();
            }
            if (!$area) {
                $area = SpecificArea::factory()->create();
            }
            if (!$shift) {
                $shift = EmployeeShift::factory()->create();
            }
            if (!$empStatus) {
                $empStatus = EmploymentStatus::factory()->create();
            }

            return [
                'employee_id'   => $item->employee_id,
                'job_title_id'  => $jobTitle->job_title_id,
                'area_id'       => $area->area_id,
                'shift_id'      => $shift->employee_shift_id,
                'emp_status_id' => $empStatus->emp_status_id,
                'hired_at'      => now(),
            ];
        })->toArray();

        DB::table('employee_job_details')->insert($employees);
    }
}
