<?php

namespace Tests\Feature\Authorization;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\SuperAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_roles_and_permissions_can_be_created(): void
    {
        $this->assertDatabaseHas('roles', ['name' => 'super-admin']);
        $this->assertDatabaseHas('roles', ['name' => 'hr-admin']);
        $this->assertDatabaseHas('roles', ['name' => 'hr-staff']);
        $this->assertDatabaseHas('roles', ['name' => 'manager']);
        $this->assertDatabaseHas('roles', ['name' => 'supervisor']);
        $this->assertDatabaseHas('roles', ['name' => 'employee']);

        $this->assertDatabaseHas('permissions', ['name' => 'dashboard.view']);
        $this->assertDatabaseHas('permissions', ['name' => 'users.view']);
        $this->assertDatabaseHas('permissions', ['name' => 'users.create']);
        $this->assertDatabaseHas('permissions', ['name' => 'users.update']);
        $this->assertDatabaseHas('permissions', ['name' => 'users.delete']);
        $this->assertDatabaseHas('permissions', ['name' => 'roles.view']);
    }

    public function test_user_can_be_assigned_role(): void
    {
        $user = User::factory()->create();
        $user->assignRole('manager');

        $this->assertTrue($user->hasRole('manager'));
        $this->assertFalse($user->hasRole('super-admin'));
        $this->assertTrue($user->can('dashboard.view'));
        $this->assertFalse($user->can('users.delete'));
    }

    public function test_super_admin_can_access_user_management(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super-admin');

        $response = $this->actingAs($superAdmin)->get('/users');

        $response->assertStatus(200);
        $response->assertSee('Daftar Pengguna');
    }

    public function test_user_without_permission_cannot_access_user_management(): void
    {
        $employee = User::factory()->create();
        $employee->assignRole('employee');

        $response = $this->actingAs($employee)->get('/users');

        $response->assertStatus(403);
    }

    public function test_backend_authorization_protects_crud_actions(): void
    {
        $hrStaff = User::factory()->create();
        $hrStaff->assignRole('hr-staff'); // Has users.view, but not users.create

        // Can view users
        $this->actingAs($hrStaff)->get('/users')->assertStatus(200);

        // Cannot create users
        $this->actingAs($hrStaff)->get('/users/create')->assertStatus(403);
        $this->actingAs($hrStaff)->post('/users', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password123',
            'role' => 'employee',
        ])->assertStatus(403);
    }

    public function test_seeders_run_successfully(): void
    {
        $this->seed(SuperAdminSeeder::class);

        $adminEmail = env('HRIS_ADMIN_EMAIL', 'admin@example.com');
        $this->assertDatabaseHas('users', ['email' => $adminEmail]);

        $adminUser = User::where('email', $adminEmail)->first();
        $this->assertNotNull($adminUser);
        $this->assertTrue($adminUser->hasRole('super-admin'));
    }
}
