<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_super_admin_sees_admin_metrics_on_dashboard(): void
    {
        $superAdmin = User::factory()->create(['name' => 'Super Administrator']);
        $superAdmin->assignRole('super-admin');

        $response = $this->actingAs($superAdmin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Super Administrator!');
        $response->assertSee('Total Pengguna');
        $response->assertSee('Total Role Sistem');
        $response->assertSee('Status Sistem');
    }

    public function test_employee_sees_welcome_and_limited_dashboard(): void
    {
        $employee = User::factory()->create(['name' => 'Regular Employee']);
        $employee->assignRole('employee');

        $response = $this->actingAs($employee)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang, Regular Employee!');
        $response->assertDontSee('Total Pengguna');
        $response->assertDontSee('Total Role Sistem');
    }
}
