<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\RoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index(): View
    {
        Gate::authorize('roles.view');

        $roles = Role::with(['permissions', 'users'])->get();
        $permissionsCount = Permission::count();

        return view('roles.index', compact('roles', 'permissionsCount'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        Gate::authorize('roles.create');

        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        Gate::authorize('roles.create');

        $role = Role::create([
            'name' => $request->validated('name'),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions', []));
        }

        return redirect()->route('roles.index')->with('success', "Role {$role->name} berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        Gate::authorize('roles.update');

        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        Gate::authorize('roles.update');

        // Prevent renaming super-admin role
        if ($role->name === 'super-admin' && $request->validated('name') !== 'super-admin') {
            return back()->withInput()->with('error', 'Nama role super-admin tidak dapat diubah.');
        }

        $role->update([
            'name' => $request->validated('name'),
        ]);

        // Keep all permissions synced for super-admin
        if ($role->name === 'super-admin') {
            $role->syncPermissions(Permission::all());
        } else {
            $role->syncPermissions($request->input('permissions', []));
        }

        return redirect()->route('roles.index')->with('success', "Role {$role->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        Gate::authorize('roles.delete');

        if ($role->name === 'super-admin') {
            return back()->with('error', 'Role super-admin merupakan role sistem inti dan tidak dapat dihapus.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Role {$role->name} tidak dapat dihapus karena masih memiliki {$role->users()->count()} pengguna terkait.");
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('roles.index')->with('success', "Role {$roleName} berhasil dihapus.");
    }
}
