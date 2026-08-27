@extends('layouts.base')
@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <nav class="mb-3 flex items-center space-x-2 text-sm text-slate-500">
        <a href="{{ route('users.index') }}" class="hover:text-teal-600 transition-colors">Utilisateurs</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="font-medium text-slate-700">Attribuer un rôle</span>
    </nav>
    <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Rôles & Droits d'accès</h1>
            <p class="text-sm text-slate-500">Associez un rôle à un utilisateur pour définir ses permissions</p>
        </div>
    </div>
</div>

<div class="max-w-2xl">

    {{-- Info Banner --}}
    <div class="mb-6 flex items-start space-x-3 rounded-xl bg-amber-50 border border-amber-100 p-4">
        <svg class="h-5 w-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <p class="text-sm text-amber-700">
            Attribuer un rôle définit les <strong>droits d'accès</strong> de l'utilisateur dans l'application. Un utilisateur ne peut avoir qu'un seul rôle actif.
        </p>
    </div>

    {{-- Form Card --}}
    <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">
        <form action="{{ route('users.store') }}" method="post" class="space-y-6">
            @csrf

            {{-- Sélection utilisateur --}}
            <div>
                <label for="user_id" class="block text-sm font-semibold text-slate-700 mb-2">
                    <span class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Utilisateur</span>
                    </span>
                </label>
                <select
                    id="user_id"
                    name="user_id"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20 appearance-none cursor-pointer"
                >
                    <option value="-">— Sélectionner un utilisateur —</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Séparateur --}}
            <div class="relative">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-100"></div></div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">puis</span>
                </div>
            </div>

            {{-- Sélection rôle --}}
            <div>
                <label for="role_id" class="block text-sm font-semibold text-slate-700 mb-2">
                    <span class="flex items-center space-x-2">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Rôle à attribuer</span>
                    </span>
                </label>

                {{-- Role Cards --}}
                <div class="grid grid-cols-1 gap-3">
                    @foreach ($roles as $role)
                        @php
                            $roleName = strtolower($role->name);
                            $isAdmin = str_contains($roleName, 'admin');
                            $isPharmacien = str_contains($roleName, 'pharmac');
                            $cardStyle = $isAdmin
                                ? 'border-rose-200 bg-rose-50 hover:border-rose-300'
                                : ($isPharmacien ? 'border-teal-200 bg-teal-50 hover:border-teal-300' : 'border-slate-200 bg-slate-50 hover:border-slate-300');
                            $iconStyle = $isAdmin ? 'text-rose-500' : ($isPharmacien ? 'text-teal-500' : 'text-slate-400');
                            $labelStyle = $isAdmin ? 'text-rose-700' : ($isPharmacien ? 'text-teal-700' : 'text-slate-600');
                        @endphp
                        <label class="flex items-center space-x-3 rounded-xl border-2 {{ $cardStyle }} p-4 cursor-pointer transition-all">
                            <input type="radio" name="role_id" value="{{ $role->id }}" class="sr-only peer">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white shadow-sm {{ $iconStyle }}">
                                @if ($isAdmin)
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @elseif ($isPharmacien)
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                @else
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold {{ $labelStyle }} capitalize">{{ $role->name }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    @if ($isAdmin) Accès complet à toutes les fonctionnalités
                                    @elseif ($isPharmacien) Gestion des ventes, produits et stocks
                                    @else Accès restreint selon les permissions
                                    @endif
                                </p>
                            </div>
                            <div class="h-4 w-4 rounded-full border-2 border-slate-300 peer-checked:border-teal-500 peer-checked:bg-teal-500 flex items-center justify-center">
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Hidden select pour fallback --}}
            <select name="role_id" id="role_id_hidden" class="hidden">
                <option value="-">Sélectionner</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            {{-- Actions --}}
            <div class="flex items-center space-x-3 pt-2">
                <button type="submit" id="btn_ajouter"
                    class="inline-flex items-center space-x-2 rounded-xl bg-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-sm shadow-teal-500/20 transition hover:bg-teal-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Attribuer le rôle</span>
                </button>
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Sync radio buttons to hidden select
document.querySelectorAll('input[type="radio"][name="role_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('role_id_hidden').value = this.value;
    });
});
</script>

@endsection