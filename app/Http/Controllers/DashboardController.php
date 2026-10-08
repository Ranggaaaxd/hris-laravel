<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        $stats = [
            'totalUsers' => null,
            'activeUsers' => null,
            'totalRoles' => null,
        ];

        if (Gate::allows('users.view')) {
            $stats['totalUsers'] = User::count();
            $stats['activeUsers'] = User::where('is_active', true)->count();
        }

        if (Gate::allows('roles.view')) {
            $stats['totalRoles'] = Role::count();
        }

        return view('dashboard', [
            'user' => $user,
            'stats' => $stats,
        ]);
    }
}
