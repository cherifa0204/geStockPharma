<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GesPharma - Gestion de Pharmacie</title>
    
    <!-- Google Fonts - Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS & JS Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="h-full text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Header/Navbar -->
    <div class="flex items-center justify-between border-b border-slate-100 bg-white px-4 py-3 sm:hidden">
        <div class="flex items-center space-x-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-teal-500 text-white shadow-md shadow-teal-500/20">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <span class="text-lg font-bold tracking-tight text-slate-800">GesPharma</span>
        </div>
        <button type="button" @click="sidebarOpen = true" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-teal-500/20">
            <span class="sr-only">Ouvrir le menu</span>
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar overlay for Mobile -->
    <div x-show="sidebarOpen" x-transition:opacity class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm sm:hidden" @click="sidebarOpen = false" style="display: none;"></div>

    <!-- Sidebar container -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed bottom-0 top-0 left-0 z-50 w-64 border-r border-slate-100 bg-white transition-transform duration-300 ease-in-out sm:translate-x-0">
        <div class="flex h-full flex-col justify-between p-5">
            
            <!-- Top Part -->
            <div>
                <!-- Brand Logo / Header -->
                <div class="flex items-center justify-between pb-6 border-b border-slate-50">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-500 text-white shadow-lg shadow-teal-500/20">
                            <!-- Stethoscope/Pharmacy dynamic icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block text-lg font-bold tracking-tight text-slate-800">GesPharma</span>
                            <span class="block text-[10px] font-semibold uppercase tracking-wider text-teal-600">Pharmacie</span>
                        </div>
                    </a>
                    <button type="button" @click="sidebarOpen = false" class="sm:hidden text-slate-400 hover:text-slate-600">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 space-y-1">
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">Gestion</span>
                    
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span>Tableau de bord</span>
                    </a>

                    <!-- Ventes -->
                    <a href="{{ route('ventes.index') }}" class="flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('ventes.*') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <span>Ventes</span>
                    </a>

                    <!-- Produits -->
                    <a href="{{ route('produits.index') }}" class="flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('produits.*') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span>Produits</span>
                    </a>

                    <!-- Achats -->
                    @can('create achat')
                    <a href="{{ route('achats.index') }}" class="flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('achats.*') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span>Achats / Stock</span>
                    </a>
                    @endcan

                    <!-- Inventaire -->
                    <a href="{{ route('create_inventaire') }}" class="flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('create_inventaire') || request()->routeIs('inventaire') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Inventaires</span>
                    </a>

                    <!-- Admin Parameters -->
                    @can('user view')
                    <div class="pt-4 mt-4 border-t border-slate-50">
                        <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">Paramètres</span>
                        
                        <!-- Utilisateurs -->
                        <a href="{{ route('users.index') }}" class="mt-2 flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('users.index') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Utilisateurs</span>
                        </a>

                        <!-- Roles/Permissions -->
                        <a href="{{ route('users.assign_role') }}" class="flex items-center space-x-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('users.assign_role') ? 'bg-teal-50 text-teal-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Rôles & Droits</span>
                        </a>
                    </div>
                    @endcan
                </nav>
            </div>

            <!-- Bottom Part - User Profile & Logout -->
            <div class="border-t border-slate-100 pt-4">
                @auth
                <div class="flex items-center space-x-3 px-3 py-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 font-semibold text-slate-600 border border-slate-200">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="block text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</span>
                        <span class="block text-[11px] text-slate-400 capitalize truncate">
                            {{ Auth::user()->getRoleNames()->first() ?? 'Utilisateur' }}
                        </span>
                    </div>
                </div>
                @endauth
                
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center space-x-3 rounded-xl px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <svg class="h-5 w-5 opacity-75" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Déconnexion</span>
                    </a>
                </form>
            </div>
            
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex flex-col min-h-screen sm:pl-64">
        
        <!-- Main Panel -->
        <main class="flex-1 p-6 md:p-8">
            <div class="mx-auto max-w-7xl">
                
                <!-- Alert/Flash Info Banner -->
                @if(session('info') || session('success') || session('alerte') || session('echec'))
                <div class="mb-6 rounded-2xl p-4 flex items-start space-x-3 transition-all duration-300 {{ session('alerte') || session('echec') ? 'bg-red-50 text-red-800 border border-red-100' : 'bg-emerald-50 text-emerald-800 border border-emerald-100' }}">
                    <div class="flex-shrink-0 mt-0.5">
                        @if(session('alerte') || session('echec'))
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        @else
                        <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        @endif
                    </div>
                    <div class="flex-1 text-sm font-medium">
                        {{ session('info') ?? session('success') ?? session('alerte') ?? session('echec') }}
                    </div>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="border-t border-slate-100 bg-white py-4 px-6 md:px-8">
            <div class="mx-auto max-w-7xl text-center sm:text-left flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} GesPharma. Tous droits réservés.</p>
                <p class="mt-1 sm:mt-0 font-medium text-slate-500">Votre santé, notre engagement.</p>
            </div>
        </footer>
    </div>
</body>
</html>