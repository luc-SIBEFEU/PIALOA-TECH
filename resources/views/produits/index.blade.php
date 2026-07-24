@extends('layouts.app')

@section('title', 'Produits')

@section('content')
    <section class="max-w-6xl mx-auto px-6 py-20">
        <span class="eyebrow">Nos réalisations</span>
        <h1 class="text-4xl font-bold mt-2 mb-12">Nos produits</h1>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse ($produits as $produit)
                <div class="card flex flex-col">
                    @if ($produit->image)
                        <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}" class="rounded-xl mb-4 ">
                    @endif
                    <h3 class="font-display font-semibold text-lg mb-2">{{ $produit->nom }}</h3>
                    <p class="text-slate text-sm leading-relaxed mb-4">{{ $produit->description }}</p>
                    @if ($produit->site_web)
                        <a href="{{ $produit->site_web }}" target="_blank" class="mt-auto text-sm font-display font-semibold text-ember hover:text-ink">Visiter le site &rarr;</a>
                    @endif
                </div>
            @empty
                <p class="text-slate">Aucun produit disponible pour le moment.</p>
            @endforelse
        </div>

        {{ $produits->links() }}
    </section>
@endsection
