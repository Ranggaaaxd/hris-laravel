<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            SuperAdminSeeder::class,
        ]);

        if (app()->isLocal()) {
            // Sample test users for different roles in local environment
            $roles = [
                'hr-admin' => ['name' => 'HR Administrator', 'email' => 'hradmin@example.com'],
                'hr-staff' => ['name' => 'HR Staff Member', 'email' => 'hrstaff@example.com'],
                'manager' => ['name' => 'Department Manager', 'email' => 'manager@example.com'],
                'supervisor' => ['name' => 'Team Supervisor', 'email' => 'supervisor@example.com'],
                'employee' => ['name' => 'Regular Employee', 'email' => 'employee@example.com'],
            ];

            foreach ($roles as $role => $info) {
                $user = User::updateOrCreate(
                    ['email' => $info['email']],
                    [
                        'name' => $info['name'],
                        'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        'is_active' => true,
                        'email_verified_at' => now(),
                    ]
                );
                $user->syncRoles([$role]);
            }
        }
    }
}
