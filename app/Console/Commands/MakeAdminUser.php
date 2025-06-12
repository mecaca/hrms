<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;

class MakeAdminUser extends Command
{
    protected $signature = 'make:admin-user
                          {--email= : Admin email address}
                          {--password= : Admin password}
                          {--name= : Admin full name}';

    protected $description = 'Create a new admin user for the HRMS system';

    public function handle()
    {
        $this->info('🔐 Creating Admin User...');

        $email = $this->option('email') ?: $this->ask('Admin Email Address');
        $password = $this->option('password') ?: $this->secret('Admin Password');
        $name = $this->option('name') ?: $this->ask('Admin Full Name', 'System Administrator');

        // Split name into first and last name
        $nameParts = explode(' ', $name, 2);
        $firstName = $nameParts[0] ?? 'System';
        $lastName = $nameParts[1] ?? 'Administrator';

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error("User with email {$email} already exists!");
            return 1;
        }

        // Create admin user
        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
            'account_type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create corresponding employee record
        Employee::create([
            'user_id' => $user->id,
            'employee_id' => 'ADMIN' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'hire_date' => now(),
            'employment_status' => 'active',
            'job_title' => 'System Administrator',
            'department_id' => 1, // Administration department
        ]);

        $this->info('✅ Admin user created successfully!');
        $this->info("📧 Email: {$email}");
        $this->info("🔑 Password: [Hidden for security]");
        $this->info("🌐 Login at: http://localhost:8000/admin/login");

        return 0;
    }
}
