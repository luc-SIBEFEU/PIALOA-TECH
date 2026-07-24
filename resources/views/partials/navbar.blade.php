<header class="sticky top-0 z-50 bg-paper/90 backdrop-blur border-b border-slate/10">
    <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Pialoa Tech" class="h-9 w-auto">
        </a>

        <nav id="nav-menu" class="hidden lg:flex items-center gap-8 font-display text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-ember transition-colors {{ request()->routeIs('home') ? 'text-ember' : 'text-ink' }}">Accueil</a>
            <a href="{{ route('about') }}" class="hover:text-ember transition-colors {{ request()->routeIs('about') ? 'text-ember' : 'text-ink' }}">À propos</a>
            <a href="{{ route('services.index') }}" class="hover:text-ember transition-colors {{ request()->routeIs('services.*') ? 'text-ember' : 'text-ink' }}">Services</a>
            <a href="{{ route('produits.index') }}" class="hover:text-ember transition-colors {{ request()->routeIs('produits.*') ? 'text-ember' : 'text-ink' }}">Produits</a>
            <a href="{{ route('evenements.index') }}" class="hover:text-ember transition-colors {{ request()->routeIs('evenements.*') ? 'text-ember' : 'text-ink' }}">Actualités</a>
            <a href="{{ route('avis.index') }}" class="hover:text-ember transition-colors {{ request()->routeIs('avis.*') ? 'text-ember' : 'text-ink' }}">Avis</a>
            <a href="{{ route('stagiaire.index') }}" class="hover:text-ember transition-colors {{ request()->routeIs('stagiaire.*') ? 'text-ember' : 'text-ink' }}">Stagiaires</a>
        </nav>

        <div class="hidden lg:flex items-center gap-4">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn-outline !px-5 !py-2 text-sm">Tableau de bord</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary !px-5 !py-2 text-sm">Espace admin</a>
            @endauth
        </div>

        <button id="nav-toggle" class="lg:hidden p-2" aria-label="Ouvrir le menu">
            <span class="dot-cluster"><span></span><span></span><span></span><span></span><span></span><span></span></span>
        </button>
    </div>

    <nav class="lg:hidden hidden flex-col gap-1 px-6 pb-4 font-display text-sm font-medium" id="nav-menu-mobile">
        <a href="{{ route('home') }}" class="py-2 border-b border-slate/10">Accueil</a>
        <a href="{{ route('about') }}" class="py-2 border-b border-slate/10">À propos</a>
        <a href="{{ route('services.index') }}" class="py-2 border-b border-slate/10">Services</a>
        <a href="{{ route('produits.index') }}" class="py-2 border-b border-slate/10">Produits</a>
        <a href="{{ route('evenements.index') }}" class="py-2 border-b border-slate/10">Actualités</a>
        <a href="{{ route('avis.index') }}" class="py-2 border-b border-slate/10">Avis</a>
        <a href="{{ route('stagiaire.index') }}" class="py-2 border-b border-slate/10">Stagiaires</a>
        @auth
            <a href="{{ route('admin.dashboard') }}" class="py-2 text-ember">Tableau de bord</a>
        @else
            <a href="{{ route('login') }}" class="py-2 text-ember">Espace admin</a>
        @endauth
    </nav>
</header>
