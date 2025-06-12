<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Shift;
use App\Enums\UserRole;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Enums\UserStatus;
use App\Enums\AccountType;
use Illuminate\Support\Arr;
use App\Models\SpecificArea;
use App\Enums\EmploymentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class HrManagerSeeder extends Seeder
{
    protected static $freeEmailDomain = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        activity()->withoutLogs(function () {
            $employee = Employee::factory()->create();

            // Get or create job title
            $hrManagerJobTitle = JobTitle::where('job_title', 'HRD Manager')->first();
            if (!$hrManagerJobTitle) {
                $hrManagerJobTitle = JobTitle::where('job_title', 'LIKE', '%HR%Manager%')->orWhere('job_title', 'LIKE', '%Manager%')->first();
                if (!$hrManagerJobTitle) {
                    $hrManagerJobTitle = JobTitle::inRandomOrder()->first();
                    if (!$hrManagerJobTitle) {
                        $hrManagerJobTitle = JobTitle::factory()->create(['job_title' => 'HRD Manager']);
                    }
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
                'job_title_id'  => $hrManagerJobTitle->job_title_id,
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
                'email'             => "hr_manager@{$validDomains}",
                'password'          => Hash::make('UniqP@ssw0rd'),
                'user_status_id'    => UserStatus::ACTIVE,
                'email_verified_at' => fake()->dateTimeBetween('-10 days', 'now'),
            ];

            $employeeUser = User::factory()->create($userData);

            $employeeUser->assignRole(UserRole::INTERMEDIATE);
        });
    }
}
