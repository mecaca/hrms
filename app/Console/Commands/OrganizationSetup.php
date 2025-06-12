<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\JobFamily;
use App\Models\SpecificArea;

class OrganizationSetup extends Command
{    protected $signature = 'organization:setup
                          {--company-name= : Company name}
                          {--company-code= : Company code}
                          {--admin-email= : Admin email}
                          {--admin-password= : Admin password}
                          {--phone= : Company phone}
                          {--address= : Company address}
                          {--website= : Company website}
                          {--clear-demo : Clear existing demo data}';

    protected $description = 'Set up HRMS for a new organization with interactive prompts';

    public function handle()
    {
        $this->info('🚀 Welcome to HRMS Organization Setup!');
        $this->info('This will configure the system for your organization.');
        $this->newLine();

        // Check if we should clear demo data
        if ($this->option('clear-demo') || $this->confirm('Clear existing demo data?', true)) {
            $this->clearDemoData();
        }

        // Collect organization information
        $orgData = $this->collectOrganizationData();

        // Set up company
        $this->setupCompany($orgData);

        // Create admin user
        $this->createAdminUser($orgData);

        // Set up basic organizational structure
        if ($this->confirm('Set up basic organizational structure (departments, job families)?', true)) {
            $this->setupOrganizationalStructure();
        }

        // Final steps
        $this->finalizeSetup($orgData);

        $this->newLine();
        $this->info('✅ Organization setup completed successfully!');
        $this->info('🌐 Admin Login: http://localhost:8000/admin/login');
        $this->info('📧 Email: ' . $orgData['admin_email']);
        $this->info('🔑 Password: [Your configured password]');
    }

    private function collectOrganizationData()
    {
        $this->info('📋 Please provide your organization information:');
        $this->newLine();

        return [
            'company_name' => $this->option('company-name') ?: $this->ask('Company Name'),
            'company_code' => $this->option('company-code') ?: $this->ask('Company Code (e.g., ACME, TECH)', strtoupper(substr($this->option('company-name') ?: 'COMPANY', 0, 6))),
            'admin_email' => $this->option('admin-email') ?: $this->ask('Admin Email Address'),
            'admin_password' => $this->option('admin-password') ?: $this->secret('Admin Password (min 8 characters)'),
            'phone' => $this->option('phone') ?: $this->ask('Company Phone Number', '+1234567890'),
            'address' => $this->option('address') ?: $this->ask('Company Address'),
            'website' => $this->option('website') ?: $this->ask('Company Website (optional)', 'https://example.com'),
        ];
    }

    private function clearDemoData()
    {
        $this->info('🧹 Clearing demo data...');

        if (!$this->confirm('This will delete all existing data. Are you sure?', false)) {
            $this->warn('Skipping demo data clearing.');
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear main data tables but keep system structure
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
            'company_information'
        ];

        foreach ($tablesToClear as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                $count = DB::table($table)->count();
                if ($count > 0) {
                    DB::table($table)->delete();
                    $this->line("Cleared: {$table} ({$count} records)");
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->info('✅ Demo data cleared');
    }

    private function setupCompany($orgData)
    {
        $this->info('🏢 Setting up company information...');

        // Update the .env file with company name
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            $envContent = preg_replace('/APP_NAME=.*/', "APP_NAME=\"{$orgData['company_name']} HRMS\"", $envContent);
            file_put_contents($envPath, $envContent);
        }

        // Check if company_information table exists and update it
        if (DB::getSchemaBuilder()->hasTable('company_information')) {
            DB::table('company_information')->updateOrInsert(
                ['id' => 1],
                [
                    'company_name' => $orgData['company_name'],
                    'company_code' => $orgData['company_code'],
                    'phone' => $orgData['phone'],
                    'address' => $orgData['address'],
                    'website' => $orgData['website'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->info('✅ Company information saved');
    }

    private function createAdminUser($orgData)
    {
        $this->info('👤 Creating admin user...');

        // Check if user already exists
        $existingUser = User::where('email', $orgData['admin_email'])->first();
        if ($existingUser) {
            if ($this->confirm("User with email {$orgData['admin_email']} already exists. Update password?", false)) {
                $existingUser->update([
                    'password' => Hash::make($orgData['admin_password']),
                ]);
                $this->info('✅ Admin user password updated');
            }
            return;
        }

        $user = User::create([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'email' => $orgData['admin_email'],
            'password' => Hash::make($orgData['admin_password']),
            'account_type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create corresponding employee record if employees table exists
        if (DB::getSchemaBuilder()->hasTable('employees')) {
            Employee::create([
                'user_id' => $user->id,
                'employee_id' => 'ADMIN001',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'email' => $orgData['admin_email'],
                'phone' => $orgData['phone'],
                'hire_date' => now(),
                'employment_status' => 'active',
                'job_title' => 'System Administrator',
                'department_id' => 1, // Will be created in structure setup
            ]);
        }

        $this->info('✅ Admin user created');
    }

    private function setupOrganizationalStructure()
    {
        $this->info('🏗️ Setting up organizational structure...');

        // Create basic departments
        if (DB::getSchemaBuilder()->hasTable('departments')) {
            $departments = [
                'Administration' => 'Administrative and executive functions',
                'Human Resources' => 'Human resource management and development',
                'Information Technology' => 'Technology and systems management',
                'Finance' => 'Financial management and accounting',
                'Operations' => 'Core business operations'
            ];

            foreach ($departments as $name => $description) {
                Department::updateOrCreate(
                    ['name' => $name],
                    ['description' => $description]
                );
                $this->line("Created department: {$name}");
            }
        }

        // Create basic job families
        if (DB::getSchemaBuilder()->hasTable('job_families')) {
            $jobFamilies = [
                'Executive' => 'Senior leadership and executive roles',
                'Management' => 'Management and supervisory positions',
                'Professional' => 'Professional and specialist roles',
                'Technical' => 'Technical and IT positions',
                'Administrative' => 'Administrative support roles'
            ];

            foreach ($jobFamilies as $name => $description) {
                JobFamily::updateOrCreate(
                    ['name' => $name],
                    ['description' => $description]
                );
                $this->line("Created job family: {$name}");
            }
        }

        // Create basic area/location
        if (DB::getSchemaBuilder()->hasTable('specific_areas')) {
            SpecificArea::updateOrCreate(
                ['name' => 'Head Office'],
                ['description' => 'Main office location']
            );
            $this->line("Created area: Head Office");
        }

        $this->info('✅ Basic organizational structure created');
    }

    private function finalizeSetup($orgData)
    {
        $this->info('🔧 Finalizing setup...');

        // Clear caches
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        // Update .env APP_NAME if needed
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            $companyName = $orgData['company_name'] ?? 'HRMS';
            $envContent = preg_replace('/APP_NAME=.*/', "APP_NAME=\"$companyName HRMS\"", $envContent);
            file_put_contents($envPath, $envContent);
        }

        $this->info('✅ Setup finalized');
    }
}
