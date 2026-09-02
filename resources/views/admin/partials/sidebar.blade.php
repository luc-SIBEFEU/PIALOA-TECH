<aside class="w-64 bg-ink text-white flex flex-col shrink-0">
    <div class="h-16 flex items-center px-6 border-b border-white/10">
       <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Pialoa Tech" class="w-auto"></a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1 font-display text-sm font-medium">
        @php
            $links = [
                ['route' => 'admin.dashboard', 'label' => 'Tableau de bord', 'icon' => 'bi-clipboard'],
                ['route' => 'admin.produits.index', 'label' => 'Produits', 'icon' => 'bi-box-seam'],
                ['route' => 'admin.services.index', 'label' => 'Services', 'icon' => 'bi-tools'],
                ['route' => 'admin.evenements.index', 'label' => 'Événements', 'icon' => 'bi-calendar-event'],
                ['route' => 'admin.stagiaires.index', 'label' => 'Stages', 'icon' => 'bi-people'],
                ['route' => 'admin.taches.index', 'label' => 'Taches', 'icon' => 'bi-newspaper'],
                ['route' => 'admin.avi.index', 'label' => 'Avis', 'icon' => 'bi-envelope-paper-fill'],
            ];
        @endphp

        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-colors
                      {{ request()->routeIs(str_replace('.index', '', $link['route']).'*') || request()->routeIs($link['route'])
                            ? 'bg-ember text-white'
                            : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <i class="bi {{ $link['icon'] }} text-sm"></i>
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>

    <div class="p-4 border-t border-white/10 text-xs text-white/40">
        Pialoa Tech &copy; {{ now()->year }}
    </div>
</aside>
