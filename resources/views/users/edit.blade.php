@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Perbarui Pengguna: {{ $user->name }}</h2>
            <p class="text-xs text-slate-500 mt-1">Ubah identitas, role akses, atau status keaktifan akun.</p>
        </div>
        <a href="{{ route('users.index') }}"
           class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">Role Akun</label>
                <select id="role"
                        name="role"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ old('role', $userRole) === $r->name ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi Baru (Opsional)</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Kosongkan jika tidak ingin mengubah sandi"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                <p class="text-xs text-slate-400 mt-1">Hanya isi kolom ini jika ingin memperbarui kata sandi akun.</p>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer mt-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-slate-700 select-none">Akun Aktif (Dapat Login)</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('users.index') }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm transition">
                    Perbarui Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
