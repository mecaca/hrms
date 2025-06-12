<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearDemoDataSeeder extends Seeder
{
    /**
     * Clear all demo data while preserving system structure
     */
    public function run(): void
    {
        $this->command->info('Clearing demo data...');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Tables to clear (preserving lookups and system data)
        $tablesToClear = [
            'users',
            'employees',
            'employee_details',
            'attendances',
            'payroll_summaries',
            'performance_evaluations',
            'job_postings',
            'job_applications',
            'leave_requests',
            'disciplinary_actions',
            'training_records',
            'benefits_enrollments',
            'salary_histories',
            'emergency_contacts',
            'company_information',
            'announcements',
            'documents',
            'time_logs',
            'overtime_requests',
            'employee_benefits',
            'payroll_details'
        ];

        foreach ($tablesToClear as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->truncate();
                $this->command->line("✓ Cleared: {$table}");
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Demo data cleared successfully!');
    }
}
