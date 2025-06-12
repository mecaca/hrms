<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasicSystemSeeder extends Seeder
{
    /**
     * Seed basic system data needed for any organization
     */
    public function run(): void
    {
        $this->command->info('Seeding basic system data...');

        // Employment statuses
        $this->seedEmploymentStatuses();

        // Basic employment types
        $this->seedEmploymentTypes();

        // Leave types
        $this->seedLeaveTypes();

        // Performance rating scales
        $this->seedPerformanceRatings();

        $this->command->info('Basic system data seeded successfully!');
    }

    private function seedEmploymentStatuses()
    {
        $statuses = [
            ['name' => 'Active', 'description' => 'Currently employed'],
            ['name' => 'Inactive', 'description' => 'Temporarily inactive'],
            ['name' => 'Terminated', 'description' => 'Employment terminated'],
            ['name' => 'Resigned', 'description' => 'Voluntarily resigned'],
            ['name' => 'Retired', 'description' => 'Retired from service'],
            ['name' => 'On Leave', 'description' => 'Currently on extended leave']
        ];

        foreach ($statuses as $status) {
            DB::table('employment_statuses')->updateOrInsert(
                ['name' => $status['name']],
                $status
            );
        }
    }

    private function seedEmploymentTypes()
    {
        $types = [
            ['name' => 'Full-time', 'description' => 'Full-time permanent employee'],
            ['name' => 'Part-time', 'description' => 'Part-time employee'],
            ['name' => 'Contract', 'description' => 'Contract-based employment'],
            ['name' => 'Temporary', 'description' => 'Temporary employment'],
            ['name' => 'Intern', 'description' => 'Internship position'],
            ['name' => 'Consultant', 'description' => 'External consultant']
        ];

        foreach ($types as $type) {
            DB::table('employment_types')->updateOrInsert(
                ['name' => $type['name']],
                $type
            );
        }
    }

    private function seedLeaveTypes()
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'days_allowed' => 21, 'description' => 'Annual vacation leave'],
            ['name' => 'Sick Leave', 'days_allowed' => 15, 'description' => 'Medical/sick leave'],
            ['name' => 'Maternity Leave', 'days_allowed' => 90, 'description' => 'Maternity leave'],
            ['name' => 'Paternity Leave', 'days_allowed' => 14, 'description' => 'Paternity leave'],
            ['name' => 'Emergency Leave', 'days_allowed' => 5, 'description' => 'Emergency situations'],
            ['name' => 'Bereavement Leave', 'days_allowed' => 7, 'description' => 'Family bereavement'],
        ];

        foreach ($leaveTypes as $leaveType) {
            DB::table('leave_types')->updateOrInsert(
                ['name' => $leaveType['name']],
                $leaveType
            );
        }
    }

    private function seedPerformanceRatings()
    {
        $ratings = [
            ['rating' => 5, 'description' => 'Outstanding', 'min_score' => 90],
            ['rating' => 4, 'description' => 'Exceeds Expectations', 'min_score' => 80],
            ['rating' => 3, 'description' => 'Meets Expectations', 'min_score' => 70],
            ['rating' => 2, 'description' => 'Below Expectations', 'min_score' => 60],
            ['rating' => 1, 'description' => 'Unsatisfactory', 'min_score' => 0],
        ];

        foreach ($ratings as $rating) {
            DB::table('performance_ratings')->updateOrInsert(
                ['rating' => $rating['rating']],
                $rating
            );
        }
    }
}
