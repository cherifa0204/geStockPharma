@extends('layouts.base')
@section('content')

{{-- Scripts DataTables --}}
<script src="{{ asset('DataTables/jquery.js') }}"></script>
<script src="{{ asset('DataTables/moncss.js') }}"></script>

{{-- Page Header --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Gestion des utilisateurs</h1>
            <p class="text-sm text-slate-500">{{ ($users ?? collect())->count() }} utilisateur(s) enregistré(s)</p>
        </div>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('register') }}"
            class="inline-flex items-center space-x-2 rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-teal-500/20 transition hover:bg-teal-700 hover:shadow-md">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Ajouter un utilisateur</span>
        </a>
        <a href="{{ route('users.assign_role') }}"
            class="inline-flex items-center space-x-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>Gérer les rôles</span>
        </a>
    </div>
</div>

{{-- Success Flash Alert --}}
@if (session('success'))
    <div class="mb-6 flex items-center justify-between rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 shadow-sm">
        <div class="flex items-center space-x-3">
            <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    </div>
@endif

{{-- Table Card --}}
<div class="rounded-2xl border border-slate-100 bg-white shadow-sm overflow-hidden">

    {{-- Search Bar --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
        <h2 class="text-sm font-semibold text-slate-700">Liste des utilisateurs</h2>
        <div id="search-users"></div>
    </div>

    <div class="overflow-x-auto">
        <table id="tble" class="w-full text-sm text-left">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">#</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Utilisateur</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Email</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500">Rôle</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($users ?? [] as $user)
                    @php
                        $initials = strtoupper(substr($user->name, 0, 2));
                        $colors = ['bg-teal-100 text-teal-700','bg-violet-100 text-violet-700','bg-amber-100 text-amber-700','bg-rose-100 text-rose-700','bg-sky-100 text-sky-700'];
                        $color = $colors[$user->id % count($colors)];
                        $role = strtolower($user->role ?? '');
                        $roleBadge = match(true) {
                            str_contains($role, 'admin') => 'bg-rose-50 text-rose-600 border border-rose-100',
                            str_contains($role, 'pharmac') => 'bg-teal-50 text-teal-600 border border-teal-100',
                            str_contains($role, 'caiss') => 'bg-amber-50 text-amber-600 border border-amber-100',
                            default => 'bg-slate-100 text-slate-500 border border-slate-200',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 text-slate-400 font-mono text-xs">{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full text-sm font-bold {{ $color }} flex-shrink-0">
                                    {{ $initials }}
                                </div>
                                <span class="font-semibold text-slate-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-500">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold capitalize {{ $roleBadge }}">
                                {{ $user->role ?? 'Non défini' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <form action="{{ route('users.edit', $user) }}" method="get">
                                    <button type="submit"
                                        class="inline-flex items-center space-x-1.5 rounded-lg border border-teal-200 bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-700 transition hover:bg-teal-100">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Éditer</span>
                                    </button>
                                </form>
                                <form action="{{ route('users.destroy', $user) }}" method="post"
                                    onsubmit="return confirm('Supprimer définitivement {{ $user->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center space-x-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>Supprimer</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center space-y-3">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                    <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-slate-500">Aucun utilisateur trouvé</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    #search-users input[type="search"] {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 7px 14px;
        font-size: 0.875rem;
        color: #475569;
        background-color: #f8fafc;
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        width: 260px;
    }
    #search-users input[type="search"]:focus {
        border-color: #14b8a6;
        box-shadow: 0 0 0 3px rgba(20,184,166,0.12);
        background-color: #fff;
    }
    .dataTables_empty { text-align: center; }
</style>

<script>
    new DataTable('#tble', {
        lengthChange: false,
        info: false,
        dom: '<"#search-users"f>t',
        paging: false,
        language: {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
            "search": "",
            "searchPlaceholder": "🔍  Rechercher un utilisateur..."
        }
    });
</script>

@endsection
