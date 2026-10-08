<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
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

    public function test_super_admin_can_create_new_user(): void
    {
        $response = $this->actingAs($this->superAdmin)->post('/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'employee',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
            'is_active' => true,
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertTrue($user->hasRole('employee'));
    }

    public function test_super_admin_can_update_user(): void
    {
        $user = User::factory()->create();
        $user->assignRole('employee');

        $response = $this->actingAs($this->superAdmin)->put("/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'role' => 'manager',
            'is_active' => '1',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $this->assertTrue($user->fresh()->hasRole('manager'));
    }

    public function test_super_admin_can_toggle_user_status(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $user->assignRole('employee');

        $response = $this->actingAs($this->superAdmin)->patch("/users/{$user->id}/toggle-status");

        $response->assertRedirect();
        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_super_admin_cannot_deactivate_self(): void
    {
        $response = $this->actingAs($this->superAdmin)->patch("/users/{$this->superAdmin->id}/toggle-status");

        $response->assertRedirect();
        $this->assertTrue($this->superAdmin->fresh()->is_active);
    }
}
