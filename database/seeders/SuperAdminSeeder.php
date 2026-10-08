<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmail = env('HRIS_ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('HRIS_ADMIN_PASSWORD');

        if (empty($adminPassword)) {
            // Development fallback password only in non-production
            $adminPassword = app()->isProduction() ? Str::random(32) : 'password';
        }

        $superAdmin = User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make($adminPassword),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $superAdmin->syncRoles(['super-admin']);
    }
}
