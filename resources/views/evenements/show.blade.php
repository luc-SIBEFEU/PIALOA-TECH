@extends('layouts.app')

@section('title', $evenement->nom)

@section('content')
    <section class="max-w-3xl mx-auto px-6 py-20">
        <a href="{{ route('evenements.index') }}" class="text-sm font-display font-semibold text-ember hover:text-ink">&larr; Retour aux actualités</a>

        <span class="eyebrow block mt-6">
            {{ $evenement->periode_debut?->translatedFormat('d M Y') }}
            @if ($evenement->periode_fin) &rarr; {{ $evenement->periode_fin->translatedFormat('d M Y') }} @endif
        </span>
        <h1 class="text-4xl font-bold mt-2 mb-8">{{ $evenement->nom }}</h1>

        @if ($evenement->image)
            <img src="{{ asset('storage/'.$evenement->image) }}" alt="{{ $evenement->nom }}" class="rounded-2xl mb-8 w-full max-h-96 object-cover">
        @endif

        <div class="prose max-w-none text-slate leading-relaxed whitespace-pre-line">
            {{ $evenement->description }}
        </div>

        @if ($evenement->document)
            <a href="{{ asset('storage/'.$evenement->document) }}" target="_blank" class="btn-primary mt-8">
                Télécharger le document
            </a>
        @endif
    </section>
@endsection
