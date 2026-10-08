<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);

        $this->superAdmin = User::factory()->create(['is_active' => true]);
        $this->superAdmin->assignRole('super-admin');
    }

    public function test_super_admin_can_view_roles(): void
    {
        $response = $this->actingAs($this->superAdmin)->get('/roles');

        $response->assertStatus(200);
        $response->assertSee('super-admin');
        $response->assertSee('hr-admin');
    }

    public function test_super_admin_can_create_new_role(): void
    {
        $response = $this->actingAs($this->superAdmin)->post('/roles', [
            'name' => 'auditor',
            'permissions' => ['dashboard.view', 'users.view'],
        ]);

        $response->assertRedirect('/roles');
        $this->assertDatabaseHas('roles', ['name' => 'auditor']);

        $role = Role::findByName('auditor');
        $this->assertTrue($role->hasPermissionTo('dashboard.view'));
        $this->assertTrue($role->hasPermissionTo('users.view'));
    }

    public function test_super_admin_cannot_delete_super_admin_role(): void
    {
        $superAdminRole = Role::findByName('super-admin');

        $response = $this->actingAs($this->superAdmin)->delete("/roles/{$superAdminRole->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('roles', ['name' => 'super-admin']);
    }
}
