<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shift;
use App\Enums\UserRole;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Enums\UserStatus;
use App\Models\JobFamily;
use App\Enums\AccountType;
use Illuminate\Support\Arr;
use App\Models\SpecificArea;
use App\Enums\EmploymentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class OperationsEmployeesSeeder extends Seeder
{
    protected static $freeEmailDomain = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        activity()->withoutLogs(function () {
            $employee = Employee::factory()->create();

            // Try to find Operations job family with GA Staff job titles
            $jobFamily = JobFamily::with(['jobTitles' => function ($query) {
                $query->whereLike('job_title', "%GA Staff%");
            }])
                ->whereLike('job_family_name', "%Operations%")
                ->first();

            $jobTitleId = null;
            if ($jobFamily && $jobFamily->jobTitles->isNotEmpty()) {
                $jobTitleId = $jobFamily->jobTitles->random()->job_title_id;
            } else {
                // Fallback: try to find any Operations job title
                $operationsFamily = JobFamily::with('jobTitles')
                    ->whereLike('job_family_name', "%Operations%")
                    ->first();
                
                if ($operationsFamily && $operationsFamily->jobTitles->isNotEmpty()) {
                    $jobTitleId = $operationsFamily->jobTitles->random()->job_title_id;
                } else {
                    // Final fallback: use any job title or create one
                    $jobTitle = JobTitle::inRandomOrder()->first();
                    if (!$jobTitle) {
                        $jobTitle = JobTitle::factory()->create(['job_title' => 'Operations Staff']);
                    }
                    $jobTitleId = $jobTitle->job_title_id;
                }
            }

            // Get or create area
            $headOffice = SpecificArea::where('area_name', 'Head Office')->first();
            if (!$headOffice) {
                $headOffice = SpecificArea::inRandomOrder()->first();
                if (!$headOffice) {
                    $headOffice = SpecificArea::factory()->create(['area_name' => 'Head Office']);
                }
            }

            // Get or create shift
            $shift = Shift::inRandomOrder()->first();
            if (!$shift) {
                $shift = Shift::factory()->create();
            }

            $employee->jobDetail()->updateOrCreate([
                'job_title_id'  => $jobTitleId,
                'area_id'       => $headOffice->area_id,
                'shift_id'      => $shift->shift_id,
                'emp_status_id' => EmploymentStatus::REGULAR,
            ]);

            $file = File::json(base_path('resources/js/email-domain-list.json'));
            self::$freeEmailDomain = $file['valid_email'];
            $validDomains = Arr::random(self::$freeEmailDomain);
    
            $userData = [
                'account_type'      => AccountType::EMPLOYEE,
                'account_id'        => $employee->employee_id,
                'email'             => 'ops.employee.'.fake()->userName()."@{$validDomains}",
                'password'          => Hash::make('UniqP@ssw0rd'),
                'user_status_id'    => UserStatus::ACTIVE,
                'email_verified_at' => fake()->dateTimeBetween('-10 days', 'now'),
            ];
    
            $employeeUser = User::factory()->create($userData);
    
            $employeeUser->assignRole(UserRole::BASIC);
        });
    }
}
