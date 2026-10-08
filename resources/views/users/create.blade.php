@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Tambah Akun Pengguna</h2>
            <p class="text-xs text-slate-500 mt-1">Daftarkan akun staf/karyawan baru untuk mengakses sistem.</p>
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

        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       placeholder="Contoh: Ahmad Fauzi"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       placeholder="ahmad.fauzi@perusahaan.com"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi Awal</label>
                <input type="password"
                       id="password"
                       name="password"
                       required
                       placeholder="Minimal 8 karakter"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">Role Akun</label>
                <select id="role"
                        name="role"
                        required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-600">
                    <option value="">Pilih Role Akses</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ old('role') === $r->name ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="flex items-center gap-2 cursor-pointer mt-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm font-medium text-slate-700 select-none">Aktifkan akun ini segera</span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('users.index') }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm transition">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
