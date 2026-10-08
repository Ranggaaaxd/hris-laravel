@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{
    checkAll(group, checked) {
        document.querySelectorAll('input[data-group=\'' + group + '\']').forEach(el => el.checked = checked);
    }
}">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900">Perbarui Role: {{ $role->name }}</h2>
            <p class="text-xs text-slate-500 mt-1">Ubah nama atau distribusi hak akses modul untuk role ini.</p>
        </div>
        <a href="{{ route('roles.index') }}"
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

        @if($role->name === 'super-admin')
            <div class="mb-6 rounded-xl bg-amber-50 p-4 border border-amber-200 text-amber-900 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Role <strong>super-admin</strong> merupakan role inti sistem yang otomatis memiliki seluruh hak akses (bypass policy).</span>
            </div>
        @endif

        <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Role (Identifier Slug)</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $role->name) }}"
                       {{ $role->name === 'super-admin' ? 'readonly' : 'required' }}
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-600 {{ $role->name === 'super-admin' ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : '' }}">
                @if($role->name === 'super-admin')
                    <p class="text-xs text-amber-600 mt-1">Nama role super-admin dilindungi dan tidak dapat diubah.</p>
                @endif
            </div>

            @if($role->name !== 'super-admin')
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3">Distribusi Hak Akses (Permissions)</h3>

                <div class="space-y-4">
                    @foreach($permissions as $group => $perms)
                    <div class="rounded-xl border border-slate-200 p-4 bg-slate-50/50">
                        <div class="flex items-center justify-between mb-3 border-b border-slate-200/80 pb-2">
                            <span class="text-sm font-bold text-slate-800 uppercase tracking-wider">Modul {{ ucfirst($group) }}</span>
                            <div class="space-x-2 text-xs">
                                <button type="button" @click="checkAll('{{ $group }}', true)" class="text-indigo-600 hover:text-indigo-800 font-semibold">Pilih Semua</button>
                                <span class="text-slate-300">|</span>
                                <button type="button" @click="checkAll('{{ $group }}', false)" class="text-slate-500 hover:text-slate-700 font-semibold">Batal Semua</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2.5">
                            @foreach($perms as $perm)
                            <label class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-white transition cursor-pointer">
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $perm->name }}"
                                       data-group="{{ $group }}"
                                       {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-xs font-mono font-medium text-slate-700">{{ $perm->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                <a href="{{ route('roles.index') }}"
                   class="px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-indigo-600 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
