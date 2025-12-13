<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Laborer;
use App\Models\TimeRecord;
use App\Models\Paycheck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        // Create Manager user
        $manager = User::factory()->create([
            'name' => 'Site Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'Manager',
        ]);

        // Create Employee users
        $employees = [
            ['name' => 'Juan Dela Cruz', 'email' => 'juan@example.com'],
            ['name' => 'Maria Santos', 'email' => 'maria@example.com'],
            ['name' => 'Pedro Reyes', 'email' => 'pedro@example.com'],
        ];

        foreach ($employees as $emp) {
            User::factory()->create([
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => Hash::make('password'),
                'role' => 'Employee',
            ]);
        }

        // Create sample laborers
        $laborers = [
            ['first_name' => 'Jose', 'last_name' => 'Garcia', 'job_position' => 'Mason', 'daily_rate' => 650.00, 'contact' => '09171234567'],
            ['first_name' => 'Roberto', 'last_name' => 'Cruz', 'job_position' => 'Carpenter', 'daily_rate' => 600.00, 'contact' => '09181234567'],
            ['first_name' => 'Antonio', 'last_name' => 'Ramos', 'job_position' => 'Electrician', 'daily_rate' => 750.00, 'contact' => '09191234567'],
            ['first_name' => 'Miguel', 'last_name' => 'Torres', 'job_position' => 'Plumber', 'daily_rate' => 700.00, 'contact' => '09201234567'],
            ['first_name' => 'Carlos', 'last_name' => 'Mendoza', 'job_position' => 'Laborer', 'daily_rate' => 500.00, 'contact' => '09211234567'],
        ];

        foreach ($laborers as $laborer) {
            Laborer::create($laborer);
        }

        // Create sample time records for employees
        $employeeUsers = User::where('role', 'Employee')->get();
        
        foreach ($employeeUsers as $user) {
            // Create time records for the past 5 days
            for ($i = 5; $i >= 1; $i--) {
                $clockIn = Carbon::now()->subDays($i)->setTime(8, 0, 0);
                $clockOut = Carbon::now()->subDays($i)->setTime(17, 0, 0);
                
                TimeRecord::create([
                    'user_id' => $user->id,
                    'clock_in' => $clockIn,
                    'clock_out' => $clockOut,
                    'hours_worked' => 8.0,
                ]);
            }
        }

        // Create sample paychecks for last 6 months for ALL users (including Admin/Manager for testing)
        $allUsers = User::all();
        
        foreach ($allUsers as $user) {
            // Create 2 paychecks per month for the last 6 months
            for ($month = 5; $month >= 0; $month--) {
                $baseDate = Carbon::now()->subMonths($month);
                
                // First paycheck of the month (1st-15th)
                Paycheck::create([
                    'user_id' => $user->id,
                    'pay_period_start' => $baseDate->copy()->startOfMonth(),
                    'pay_period_end' => $baseDate->copy()->startOfMonth()->addDays(14),
                    'pay_date' => $baseDate->copy()->startOfMonth()->addDays(15),
                    'gross_pay' => rand(4000, 6000),
                    'net_pay' => rand(3600, 5400),
                    'total_deductions' => 400.00,
                    'status' => 'Paid',
                ]);
                
                // Second paycheck of the month (16th-end)
                Paycheck::create([
                    'user_id' => $user->id,
                    'pay_period_start' => $baseDate->copy()->startOfMonth()->addDays(15),
                    'pay_period_end' => $baseDate->copy()->endOfMonth(),
                    'pay_date' => $baseDate->copy()->endOfMonth(),
                    'gross_pay' => rand(4000, 6000),
                    'net_pay' => rand(3600, 5400),
                    'total_deductions' => 400.00,
                    'status' => 'Paid',
                ]);
            }
        }

        $this->command->info('Seeded users with roles: Admin, Manager, Employee');
        $this->command->info('Login credentials: email / password');
    }
}
