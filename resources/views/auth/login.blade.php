@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="bg-white rounded-2xl shadow-2xl border border-slate-100/80 overflow-hidden">
    <div class="px-8 pt-10 pb-6 text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-slate-900">HRIS Portal</h2>
        <p class="mt-1 text-sm text-slate-500">Human Resource Information System</p>
    </div>

    <div class="px-8 pb-10">
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200/80 text-red-800 text-sm">
                <div class="flex items-center gap-2 font-semibold mb-1">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Terjadi kesalahan autentikasi:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-red-700 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <input id="email"
                           name="email"
                           type="email"
                           autocomplete="email"
                           required
                           value="{{ old('email') }}"
                           placeholder="nama@perusahaan.com"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent text-sm transition">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <input id="password"
                           name="password"
                           type="password"
                           autocomplete="current-password"
                           required
                           placeholder="••••••••"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent text-sm transition">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox"
                           name="remember"
                           value="1"
                           {{ old('remember') ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-xs text-slate-600 select-none">Ingat saya di perangkat ini</span>
                </label>
            </div>

            <div>
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-600/30 transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                    Masuk ke Sistem
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">
                Aplikasi internal terproteksi. Hubungi Tim HR jika Anda mengalami kendala akses akun.
            </p>
        </div>
    </div>
</div>
@endsection
