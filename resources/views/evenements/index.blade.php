@extends('layouts.app')

@section('title', 'Actualités')

@section('content')
    <section class="max-w-6xl mx-auto px-6 py-20">
        <span class="eyebrow">Restez informés</span>
        <h1 class="text-4xl font-bold mt-2 mb-12">Actualités &amp; événements</h1>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse ($evenements as $evenement)
                <a href="{{ route('evenements.show', $evenement) }}" class="card block">
                    @if ($evenement->image)
                        <img src="{{ asset('storage/'.$evenement->image) }}" alt="{{ $evenement->nom }}" class="rounded-xl mb-4 h-40 w-full object-cover">
                    @endif
                    <span class="text-xs font-display font-semibold text-claret">
                        {{ $evenement->periode_debut?->translatedFormat('d M Y') }}
                        @if ($evenement->periode_fin) &rarr; {{ $evenement->periode_fin->translatedFormat('d M Y') }} @endif
                    </span>
                    <h3 class="font-display font-semibold text-lg mt-2">{{ $evenement->nom }}</h3>
                    <p class="text-slate text-sm leading-relaxed mt-2">{{ Str::limit($evenement->description, 100) }}</p>
                </a>
            @empty
                <p class="text-slate">Aucune actualité pour le moment.</p>
            @endforelse
        </div>

        {{ $evenements->links() }}
    </section>
@endsection
