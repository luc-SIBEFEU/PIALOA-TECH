@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-ink text-white">
        <div class="max-w-6xl mx-auto px-6 py-24 lg:py-32 grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="dot-cluster"><span></span><span></span><span></span><span></span><span></span><span></span></span>
                    <span class="eyebrow">Pialoa Tech &mdash; Expert technologique</span>
                </div>
                <h1 class="text-4xl lg:text-6xl font-display font-bold leading-[1.05] mb-6">
                    Entreprise de <span class="text-ember">solutions</span> digitales
                </h1>
                <p class="text-white/70 text-lg leading-relaxed max-w-lg mb-10">
                    Pialoa Tech est spécialisée dans le développement de solutions digitales et électroniques
                    en météorologie&nbsp;: sites web, applications, automatisme et stations météo connectées.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('services.index') }}" class="btn-primary">Découvrir nos services</a>
                    <a href="{{ route('about') }}" class="btn-outline !border-white !text-white hover:!bg-white hover:!text-ink">À propos de nous</a>
                </div>
            </div>

            <div class="relative hidden lg:flex justify-center">
                <div class="absolute -inset-8 bg-ember/10 rounded-full blur-3xl"></div>
                <div class="relative grid grid-cols-3 gap-4 p-8">
                    @foreach (['bg-ember', 'bg-moss', 'bg-slate', 'bg-claret', 'bg-ember/60', 'bg-moss/60', 'bg-slate/60', 'bg-claret/60', 'bg-ember/30'] as $c)
                        <span class="w-10 h-10 rounded-full {{ $c }}"></span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="eyebrow">Ce que nous faisons</span>
                <h2 class="text-3xl font-bold mt-2">Nos services</h2>
            </div>
            <a href="{{ route('services.index') }}" class="hidden sm:inline-block text-sm font-display font-semibold text-ember hover:text-ink transition">Tout voir &rarr;</a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($services as $service)
                <div class="card">
                    <div class="w-10 h-10 rounded-lg bg-ember/10 flex items-center justify-center mb-4">
                        <!-- <span class="w-3 h-3 rounded-full bg-ember"></span> -->
                        <i class="bi bi-{{ $service->icone }}"></i>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">{{ $service->nom }}</h3>
                    <p class="text-slate text-sm leading-relaxed">{{ Str::limit($service->description, 100) }}</p>
                </div>
            @empty
                <p class="text-slate">Aucun service pour le moment.</p>
            @endforelse
        </div>
    </section>

    {{-- PRODUITS --}}
    <section class="bg-white border-y border-slate/10">
        <div class="max-w-6xl mx-auto px-6 py-20">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <span class="eyebrow">Nos réalisations</span>
                    <h2 class="text-3xl font-bold mt-2">Produits</h2>
                </div>
                <a href="{{ route('produits.index') }}" class="hidden sm:inline-block text-sm font-display font-semibold text-ember hover:text-ink transition">Tout voir &rarr;</a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($produits as $produit)
                    <div class="card flex flex-col">
                        @if ($produit->image)
                            <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" class="rounded-xl mb-4 h-40 w-full object-cover">
                        @endif
                        <h3 class="font-display font-semibold text-lg mb-2">{{ $produit->nom }}</h3>
                        <p class="text-slate text-sm leading-relaxed mb-4">{{ Str::limit($produit->description, 90) }}</p>
                        @if ($produit->site_web)
                            <a href="{{ $produit->site_web }}" target="_blank" class="mt-auto text-sm font-display font-semibold text-ember hover:text-ink">Visiter le site &rarr;</a>
                        @endif
                    </div>
                @empty
                    <p class="text-slate">Aucun produit pour le moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ACTUALITES --}}
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="eyebrow">Restez informés</span>
                <h2 class="text-3xl font-bold mt-2">Actualités &amp; événements</h2>
            </div>
            <a href="{{ route('evenements.index') }}" class="hidden sm:inline-block text-sm font-display font-semibold text-ember hover:text-ink transition">Tout voir &rarr;</a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($evenements as $evenement)
                <a href="{{ route('evenements.show', $evenement) }}" class="card block">
                    @if ($evenement->image)
                        <img src="{{ asset('storage/'.$evenement->image) }}" alt="{{ $evenement->nom }}" class="rounded-xl mb-4 h-40 w-full object-cover">
                    @endif
                    <span class="text-xs font-display font-semibold text-claret">{{ $evenement->periode_debut?->translatedFormat('d M Y') }}</span>
                    <h3 class="font-display font-semibold text-lg mt-2">{{ $evenement->nom }}</h3>
                    <p class="text-slate text-sm leading-relaxed mt-2">{{ Str::limit($evenement->description, 90) }}</p>
                </a>
            @empty
                <p class="text-slate">Aucune actualité pour le moment.</p>
            @endforelse
        </div>
    </section>


    {{-- STAGIAIRES --}}
    <section class="bg-white border-y border-slate/10 max-w-6xl mx-auto px-6 py-20">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="eyebrow">Formations</span>
                <h2 class="text-3xl font-bold mt-2">Nos stagiaires</h2>
            </div>
            <a href="{{ route('stagiaire.index') }}" class="hidden sm:inline-block text-sm font-display font-semibold text-ember hover:text-ink transition">Tout voir &rarr;</a>
        </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($stagiaires as $stagiaire)

                <a href="{{ route('stagiaire.show',$stagiaire) }}">
                <div class="card flex flex-col">
                    @php
                        $imagePath = $stagiaire->avatar ?? $stagiaire->image;
                    @endphp
                    @if ($imagePath)
                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $stagiaire->nom }}" class=" mb-4 h-40  object-cover ">
                    @endif
                    <h3 class="font-display font-semibold text-lg" style="font-weight: 700; font-size:30px;">{{ $stagiaire->nom }}
                    <p class="text-slate text-sm leading-relaxed">{{ $stagiaire->email }}</p></h3>

                    <h5 class="text-ink" style="font-weight: 700; font-size:20px;">{{ $stagiaire->secteur }}</h5>
                    <p class="font-display font-semibold mb-7 text-ember leading-relaxed mb-4"><i class="bi bi-calendar-fill"></i> {{ $stagiaire->periode_debut->translatedFormat('d M Y') }} - {{ $stagiaire->periode_fin->translatedFormat('d M Y') }}</p>
<!-- 
                    <h5 class="text-slate text-sm leading-relaxed">{{ $stagiaire->description }}</h5> -->
                
                </div></a>
            @empty
                <p class="text-slate">Aucun stagiaire disponible pour le moment.</p>
            @endforelse
        </div>
</section>

    {{-- CTA --}}
    <section class="bg-ember">
        <div class="max-w-6xl mx-auto px-6 py-16 flex flex-col lg:flex-row items-center justify-between gap-6 text-center lg:text-left">
            <h2 class="text-2xl lg:text-3xl font-display font-bold text-white max-w-xl">
                Un projet digital en tête&nbsp;? Parlons-en.
            </h2>
            <a href="mailto:pialoatech@gmail.com" class="btn-outline !border-white !text-white hover:!bg-white hover:!text-ember shrink-0">
                pialoatech@gmail.com
            </a>
        </div>
    </section>

@endsection
