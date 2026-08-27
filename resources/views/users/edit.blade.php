@extends("layouts.base")
@section("content")

@php
    $isEdit = ($user ?? null) != null;
    $title = $isEdit ? "Modifier l'utilisateur" : "Nouvel utilisateur";
    $subtitle = $isEdit ? "Modifiez les informations de " . $user->name : "Créez un nouveau compte utilisateur";
@endphp

{{-- Page Header --}}
<div class="mb-8">
    <nav class="mb-3 flex items-center space-x-2 text-sm text-slate-500">
        <a href="{{ route('users.index') }}" class="hover:text-teal-600 transition-colors">Utilisateurs</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        <span class="font-medium text-slate-700">{{ $title }}</span>
    </nav>
    <div class="flex items-center space-x-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $title }}</h1>
            <p class="text-sm text-slate-500">{{ $subtitle }}</p>
        </div>
    </div>
</div>

{{-- Form Card --}}
<div class="max-w-2xl">
    <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm">

        {{-- Avatar preview (edit mode) --}}
        @if ($isEdit)
        <div class="mb-6 flex items-center space-x-4 pb-6 border-b border-slate-100">
            @php
                $initials = strtoupper(substr($user->name, 0, 2));
                $colors = ['bg-teal-100 text-teal-700','bg-violet-100 text-violet-700','bg-amber-100 text-amber-700','bg-rose-100 text-rose-700','bg-sky-100 text-sky-700'];
                $color = $colors[$user->id % count($colors)];
            @endphp
            <div class="flex h-16 w-16 items-center justify-center rounded-full text-xl font-bold {{ $color }} flex-shrink-0">
                {{ $initials }}
            </div>
            <div>
                <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                @if($user->role)
                <span class="mt-1 inline-flex items-center rounded-lg bg-teal-50 border border-teal-100 px-2 py-0.5 text-xs font-semibold text-teal-600 capitalize">
                    {{ $user->role }}
                </span>
                @endif
            </div>
        </div>
        @endif

        <form action="{{ route('users.update', $user ?? '') }}" method="post" class="space-y-5">
            @if ($isEdit)
                @method('PUT')
            @endif
            @csrf

            {{-- Nom --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                    Nom complet
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ $user->name ?? '' }}"
                        placeholder="Nom et prénom"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 py-3 text-sm text-slate-800 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                    >
                </div>
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                    Adresse email
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ $user->email ?? '' }}"
                        placeholder="exemple@email.com"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 py-3 text-sm text-slate-800 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                    >
                </div>
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Mot de passe --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                    Mot de passe
                    @if ($isEdit)
                        <span class="ml-1 text-xs font-normal text-slate-400">(laisser vide pour ne pas modifier)</span>
                    @endif
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="{{ $isEdit ? 'Nouveau mot de passe' : 'Mot de passe' }}"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-4 py-3 text-sm text-slate-800 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/20"
                    >
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center space-x-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center space-x-2 rounded-xl bg-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-sm shadow-teal-500/20 transition hover:bg-teal-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ $isEdit ? 'Enregistrer les modifications' : 'Créer l\'utilisateur' }}</span>
                </button>
                <a href="{{ route('users.index') }}"
                    class="inline-flex items-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection