@extends('layouts.app')

@section('title', 'Manajemen Role & Hak Akses')

@section('content')
<div class="space-y-6">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Daftar Role Sistem</h2>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi peran dan matrik otorisasi izin pengguna dalam HRIS.</p>
        </div>
        @can('roles.create')
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('roles.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Role Baru
            </a>
        </div>
        @endcan
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Role Identifier</th>
                        <th class="px-6 py-4">Jumlah Pengguna</th>
                        <th class="px-6 py-4">Hak Akses (Permissions)</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($roles as $role)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900 font-mono">{{ $role->name }}</span>
                                @if($role->name === 'super-admin')
                                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-[11px] font-bold text-amber-800 ring-1 ring-inset ring-amber-600/20">
                                        System Core
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                {{ $role->users->count() }} Pengguna
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($role->name === 'super-admin')
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    Semua Hak Akses ({{ $permissionsCount }}/{{ $permissionsCount }})
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                    {{ $role->permissions->count() }} dari {{ $permissionsCount }} Hak Akses
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @can('roles.update')
                            <a href="{{ route('roles.edit', $role) }}"
                               class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">
                                Edit Izin
                            </a>
                            @endcan

                            @can('roles.delete')
                            @if($role->name !== 'super-admin')
                            <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </form>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
