@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-700 via-indigo-600 to-indigo-800 p-8 text-white shadow-lg">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold backdrop-blur-md mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Sesi Aktif
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $user->name }}!</h2>
            <p class="mt-2 text-indigo-100 text-sm leading-relaxed">
                Anda masuk sebagai role <span class="font-bold underline decoration-indigo-300">{{ $user->roles->first()?->name ?? 'User' }}</span>.
                Sistem HRIS siap digunakan untuk pengelolaan sumber daya manusia perusahaan.
            </p>
        </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Metrics Cards (Displayed according to authorization) -->
    @if(isset($stats['totalUsers']) || isset($stats['totalRoles']))
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @if(isset($stats['totalUsers']))
        <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['totalUsers'] }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Pengguna Aktif: <strong class="text-emerald-600">{{ $stats['activeUsers'] }}</strong></span>
                @can('users.view')
                <a href="{{ route('users.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Kelola &rarr;</a>
                @endcan
            </div>
        </div>
        @endif

        @if(isset($stats['totalRoles']))
        <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Role Sistem</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $stats['totalRoles'] }}</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Access Control Roles</span>
                @can('roles.view')
                <a href="{{ route('roles.index') }}" class="text-purple-600 hover:text-purple-800 font-medium">Lihat &rarr;</a>
                @endcan
            </div>
        </div>
        @endif

        <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/80">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.75 5.1a3 3 0 012.35-1.1h7.8a3 3 0 012.35 1.1l2.1 3.45a4.5 4.5 0 01.9 2.7" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Status Sistem</p>
                    <p class="text-xl font-bold text-slate-900">Operasional</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Laravel {{ app()->version() }} (PHP {{ phpversion() }})</span>
                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Normal</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Role & Quick Actions Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Account Info Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Informasi Akun Anda</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Nama Lengkap</span>
                    <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Email</span>
                    <span class="font-semibold text-slate-800">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-slate-100">
                    <span class="text-slate-500">Role Utama</span>
                    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-0.5 text-xs font-bold text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                        {{ $user->roles->first()?->name ?? 'None' }}
                    </span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-slate-500">Status Akun</span>
                    <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-0.5 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                        Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Permissions Card -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Aksi Cepat & Hak Akses</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
                @can('users.create')
                <a href="{{ route('users.create') }}"
                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-indigo-500 hover:bg-indigo-50/50 transition group">
                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Tambah Pengguna</p>
                        <p class="text-xs text-slate-400">Buat akun login staf baru</p>
                    </div>
                </a>
                @endcan

                @can('roles.create')
                <a href="{{ route('roles.create') }}"
                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 hover:border-purple-500 hover:bg-purple-50/50 transition group">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-800">Tambah Role</p>
                        <p class="text-xs text-slate-400">Konfigurasi hak akses baru</p>
                    </div>
                </a>
                @endcan
            </div>

            <div>
                <p class="text-xs font-semibold text-slate-500 mb-2">Daftar Hak Akses (Permissions) Terkait Role Anda:</p>
                <div class="flex flex-wrap gap-1.5">
                    @forelse($user->getAllPermissions() as $permission)
                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-mono font-medium text-slate-700">
                            {{ $permission->name }}
                        </span>
                    @empty
                        @if($user->hasRole('super-admin'))
                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-0.5 text-xs font-bold text-amber-800 ring-1 ring-inset ring-amber-600/20">
                                Super Admin Bypass (Seluruh Hak Akses Sistem)
                            </span>
                        @else
                            <span class="text-xs text-slate-400">Belum ada izin khusus.</span>
                        @endif
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
