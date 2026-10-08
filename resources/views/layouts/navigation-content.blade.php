<div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-800">
    <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-600/30">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
    </div>
    <div>
        <span class="text-base font-bold text-white tracking-tight">HRIS Portal</span>
        <span class="block text-[11px] text-slate-400 font-medium leading-none">Enterprise Platform</span>
    </div>
</div>

<nav class="flex flex-1 flex-col justify-between mt-4">
    <ul role="list" class="flex flex-1 flex-col gap-y-6">
        <!-- Main Navigation -->
        <li>
            <div class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase mb-2">Menu Utama</div>
            <ul role="list" class="-mx-2 space-y-1">
                @can('dashboard.view')
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="group flex gap-x-3 rounded-xl p-2.5 text-sm font-semibold leading-6 transition {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                @endcan
            </ul>
        </li>

        <!-- Administration -->
        @if(auth()->user()->can('users.view') || auth()->user()->can('roles.view'))
        <li>
            <div class="text-[11px] font-semibold tracking-wider text-slate-400 uppercase mb-2">Administrasi</div>
            <ul role="list" class="-mx-2 space-y-1">
                @can('users.view')
                <li>
                    <a href="{{ route('users.index') }}"
                       class="group flex gap-x-3 rounded-xl p-2.5 text-sm font-semibold leading-6 transition {{ request()->routeIs('users.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                        Pengguna (Users)
                    </a>
                </li>
                @endcan

                @can('roles.view')
                <li>
                    <a href="{{ route('roles.index') }}"
                       class="group flex gap-x-3 rounded-xl p-2.5 text-sm font-semibold leading-6 transition {{ request()->routeIs('roles.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/40' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        Role & Izin (Roles)
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endif
    </ul>

    <!-- User Section Bottom -->
    <div class="pt-4 border-t border-slate-800 -mx-2">
        <div class="px-2.5 py-2 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 rounded-full bg-slate-800 text-indigo-400 border border-slate-700 flex items-center justify-center font-bold text-xs uppercase flex-shrink-0">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->roles->first()?->name ?? 'User' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout" class="p-1.5 text-slate-400 hover:text-red-400 rounded-lg hover:bg-slate-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</nav>
