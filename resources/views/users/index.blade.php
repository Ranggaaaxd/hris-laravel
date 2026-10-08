@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6" x-data="{ resetModalOpen: false, resetUserId: null, resetUserName: '' }">
    <!-- Header with Actions -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Daftar Pengguna</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data akun login dan hak akses karyawan HRIS.</p>
        </div>
        @can('users.create')
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('users.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pengguna Baru
            </a>
        </div>
        @endcan
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80">
        <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="sm:col-span-2">
                <label for="search" class="block text-xs font-semibold text-slate-600 mb-1">Cari Nama / Email</label>
                <div class="relative">
                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Ketik nama atau email..."
                           class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                </div>
            </div>

            <div>
                <label for="role" class="block text-xs font-semibold text-slate-600 mb-1">Filter Role</label>
                <select id="role"
                        name="role"
                        class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <option value="">Semua Role</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ request('role') === $r->name ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-xs font-semibold text-slate-600 mb-1">Status Akun</label>
                <div class="flex gap-2">
                    <select id="status"
                            name="status"
                            class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <button type="submit"
                            class="rounded-xl bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 text-xs font-semibold transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'role', 'status']))
                        <a href="{{ route('users.index') }}"
                           class="rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-2 text-xs font-semibold flex items-center justify-center transition">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50/80 text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Nama & Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $user->name }}</div>
                            <div class="text-xs text-slate-400 font-mono">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_active)
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-600/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $user->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @can('users.update')
                            <a href="{{ route('users.edit', $user) }}"
                               class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs">
                                Edit
                            </a>

                            <!-- Toggle Status Form -->
                            <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin mengubah status aktif pengguna ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs font-semibold {{ $user->is_active ? 'text-amber-600 hover:text-amber-800' : 'text-emerald-600 hover:text-emerald-800' }}">
                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <!-- Reset Password Button -->
                            <button type="button"
                                    @click="resetModalOpen = true; resetUserId = '{{ $user->id }}'; resetUserName = '{{ addslashes($user->name) }}'"
                                    class="text-xs font-semibold text-slate-600 hover:text-slate-900">
                                Reset Password
                            </button>
                            @endcan

                            @can('users.delete')
                            <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline-block" onsubmit="return confirm('Hapus permanen pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-400">
                            Tidak ada data pengguna yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- Reset Password Modal -->
    <div x-show="resetModalOpen"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="resetModalOpen = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl border border-slate-100" @click.stop>
                <h3 class="text-lg font-bold text-slate-900">Reset Kata Sandi</h3>
                <p class="text-xs text-slate-500 mt-1">Masukkan kata sandi baru untuk <strong x-text="resetUserName"></strong>.</p>

                <form :action="'{{ url('users') }}/' + resetUserId + '/reset-password'" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru</label>
                        <input type="password"
                               name="password"
                               required
                               placeholder="Minimal 8 karakter"
                               class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                        <input type="password"
                               name="password_confirmation"
                               required
                               placeholder="Ulangi kata sandi"
                               class="w-full px-3.5 py-2 text-sm rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="resetModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 rounded-xl shadow-sm">
                            Simpan Sandi Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
