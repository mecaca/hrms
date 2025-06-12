<?php

namespace Database\Seeders;

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

class ProbationaryEmployeesSeeder extends Seeder
{
    protected static $freeEmailDomain = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        activity()->disableLogging();

        $jobFamilies = JobFamily::with('jobTitles')->get();

        $jobFamilies->each(function ($family) {
            $employee = Employee::factory()->create();

            // Get job title with null safety and fallback logic
            $jobTitle = $family->jobTitles->first();

            if (!$jobTitle) {
                // If no job titles in this family, try to find any job title
                $jobTitle = JobTitle::first();
            }

            if (!$jobTitle) {
                // Last resort: create a job title
                $jobTitle = JobTitle::factory()->create([
                    'job_title' => 'Probationary Employee - ' . $family->job_family_name
                ]);
            }

            $name = $jobTitle->job_title;

            $employee->jobDetail()->create([
                'job_title_id'  => $jobTitle->job_title_id,
                'area_id'       => SpecificArea::where('area_name', 'Head Office')->first()->area_id,
                'shift_id'      => Shift::inRandomOrder()->first()->shift_id,
                'emp_status_id' => EmploymentStatus::PROBATIONARY,
            ]);

            $this->createUser($employee, $name);
        });

        activity()->enableLogging();
    }

    private function createUser(Employee $employee, string $jobFamily)
    {
        $file = File::json(base_path('resources/js/email-domain-list.json'));
        self::$freeEmailDomain = $file['valid_email'];
        $validDomains = Arr::random(self::$freeEmailDomain);

        $filteredEmail = strtolower($jobFamily).fake()->userName()."@{$validDomains}";

        $trimmedEmail = preg_replace('/[\/\s]+/', '.', $filteredEmail);

        $newUser = $employee->account()->create([
            'account_type'      => AccountType::EMPLOYEE,
            'account_id'        => $employee->employee_id,
            'email'             => $trimmedEmail,
            'password'          => Hash::make('UniqP@ssw0rd'),
            'user_status_id'    => UserStatus::ACTIVE,
            'email_verified_at' => fake()->dateTimeBetween('-10 days', 'now'),
        ]);

        $newUser->assignRole(UserRole::BASIC);
    }
}
