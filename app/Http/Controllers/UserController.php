<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        Gate::authorize('users.view');

        $query = User::with('roles')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $role = $request->input('role');
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        Gate::authorize('users.create');

        $roles = Role::all();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(CreateUserRequest $request): RedirectResponse
    {
        Gate::authorize('users.create');

        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->validated('role'));

        return redirect()->route('users.index')->with('success', "Pengguna {$user->name} berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        Gate::authorize('users.update');

        $roles = Role::all();
        $userRole = $user->roles->first()?->name;

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('users.update');

        // Protect last active super-admin from losing role or deactivation
        if ($user->hasRole('super-admin')) {
            $otherActiveSuperAdmins = User::role('super-admin')
                ->where('is_active', true)
                ->where('id', '!=', $user->id)
                ->count();

            if ($otherActiveSuperAdmins === 0) {
                if ($request->validated('role') !== 'super-admin') {
                    return back()->withInput()->with('error', 'Tidak dapat mengubah role Super Admin terakhir dalam sistem.');
                }
                if (! $request->boolean('is_active', true)) {
                    return back()->withInput()->with('error', 'Tidak dapat menonaktifkan Super Admin terakhir dalam sistem.');
                }
            }
        }

        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'is_active' => $request->boolean('is_active', true),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->validated('password'));
        }

        $user->update($data);
        $user->syncRoles([$request->validated('role')]);

        return redirect()->route('users.index')->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Toggle active/inactive status of the user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        Gate::authorize('users.update');

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        if ($user->hasRole('super-admin') && $user->is_active) {
            $otherActiveSuperAdmins = User::role('super-admin')
                ->where('is_active', true)
                ->where('id', '!=', $user->id)
                ->count();

            if ($otherActiveSuperAdmins === 0) {
                return back()->with('error', 'Tidak dapat menonaktifkan Super Admin terakhir.');
            }
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Pengguna {$user->name} berhasil {$statusText}.");
    }

    /**
     * Reset user password.
     */
    public function resetPassword(ResetPasswordRequest $request, User $user): RedirectResponse
    {
        Gate::authorize('users.update');

        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return back()->with('success', "Password untuk {$user->name} berhasil direset.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        Gate::authorize('users.delete');

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->hasRole('super-admin')) {
            $otherSuperAdmins = User::role('super-admin')
                ->where('id', '!=', $user->id)
                ->count();

            if ($otherSuperAdmins === 0) {
                return back()->with('error', 'Tidak dapat menghapus Super Admin terakhir.');
            }
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('success', "Pengguna {$userName} berhasil dihapus.");
    }
}
