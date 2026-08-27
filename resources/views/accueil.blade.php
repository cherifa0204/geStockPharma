<!DOCTYPE html>
<html lang="fr" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacie THE NEWMAN - GesPharma</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    <style>
        body {
            font-family: 'Outfit', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased">

    <!-- Header / Navigation -->
    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-500 text-white shadow-md shadow-teal-500/25">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">GesPharma</span>
            </div>
            
            <nav class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center rounded-xl bg-teal-50 px-4 py-2 text-sm font-semibold text-teal-700 hover:bg-teal-100 transition-colors">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 transition-colors">
                            Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center rounded-xl bg-teal-500 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-teal-500/20 hover:bg-teal-600 transition-all hover:shadow-teal-500/30">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-tr from-teal-50 via-white to-slate-50 py-20 lg:py-28 overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto space-y-6">
                    <span class="inline-flex items-center rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700 border border-teal-100/50">
                        Bienvenue à la Pharmacie THE NEWMAN
                    </span>
                    <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Votre santé est notre priorité absolue, au quotidien.
                    </h2>
                    <p class="text-lg text-slate-500 leading-relaxed">
                        Accédez à un service de gestion et de dispensation de médicaments moderne, rapide et entièrement sécurisé avec la plateforme <span class="font-bold text-teal-600">GesPharma</span>.
                    </p>
                    <div class="flex items-center justify-center space-x-4 pt-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-teal-500 px-6 py-3 text-base font-semibold text-white shadow-lg shadow-teal-500/25 hover:bg-teal-600 hover:shadow-teal-500/35 transition-all">
                            Accéder à l'application
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Graphic decors -->
            <div class="absolute -top-12 -left-12 h-64 w-64 rounded-full bg-teal-100/30 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-emerald-100/30 blur-3xl"></div>
        </section>

        <!-- About Section -->
        <section class="py-16 sm:py-24 bg-white border-y border-slate-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h3 class="text-3xl font-bold tracking-tight text-slate-900">À propos de notre pharmacie</h3>
                        <p class="text-slate-500 leading-relaxed">
                            La Pharmacie THE NEWMAN est dédiée à fournir des soins de santé de haute qualité et des produits pharmaceutiques certifiés pour vous et votre famille. Nous sommes fiers de servir notre communauté depuis de nombreuses années en garantissant la disponibilité et la traçabilité de nos produits.
                        </p>
                        <div class="flex items-center space-x-4 text-sm font-semibold text-teal-600">
                            <span>✓ Équipe de pharmaciens certifiés</span>
                            <span>✓ Produits rigoureusement contrôlés</span>
                        </div>
                    </div>
                    <!-- Graphic Card Design -->
                    <div class="rounded-3xl bg-slate-50 border border-slate-100 p-8 shadow-inner relative overflow-hidden">
                        <div class="relative z-10 flex flex-col justify-between h-48">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-teal-600">Engagement Qualité</span>
                            <div>
                                <h4 class="text-xl font-bold text-slate-900">Service GesPharma</h4>
                                <p class="text-sm text-slate-400 mt-2">Notre outil interne pour optimiser le temps d'attente, suivre les prescriptions et sécuriser vos achats de santé.</p>
                            </div>
                        </div>
                        <div class="absolute -right-16 -bottom-16 h-48 w-48 rounded-full bg-teal-500/10"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-16 sm:py-24 bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                    <h3 class="text-3xl font-bold tracking-tight text-slate-900">Nos Services</h3>
                    <p class="text-slate-500">Nous faisons plus que simplement distribuer des médicaments. Découvrez nos services dédiés à votre bien-être.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Service 1 -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm space-y-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Conseils Pharmaceutiques</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">Nos pharmaciens d'expérience sont constamment à votre écoute pour vous conseiller et répondre à vos questions sur vos traitements.</p>
                    </div>

                    <!-- Service 2 -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm space-y-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Large Gamme de Produits</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">Nous disposons d'une très large sélection de médicaments, produits de parapharmacie, matériel médical et de premiers soins.</p>
                    </div>

                    <!-- Service 3 -->
                    <div class="rounded-2xl border border-slate-100 bg-white p-8 shadow-sm space-y-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-teal-50 text-teal-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900">Traçabilité & Digital</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">Avec GesPharma, toutes les entrées et sorties de stock sont enregistrées pour garantir un contrôle optimal de la date et de la provenance.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-400 space-y-2">
            <p>&copy; {{ date('Y') }} Pharmacie THE NEWMAN. Tous droits réservés.</p>
            <p class="font-medium text-slate-500">GesPharma - Outil interne de Gestion de Stock Pharmaceutique.</p>
        </div>
    </footer>

</body>
</html>
