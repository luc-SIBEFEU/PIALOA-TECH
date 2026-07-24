@extends('layouts.app')

@section('title', 'Services')

@section('content')
    <section class="max-w-6xl mx-auto px-6 py-20">
        <span class="eyebrow">Ce que nous faisons</span>
        <h1 class="text-4xl font-bold mt-2 mb-12">Nos services</h1>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($services as $service)
                <div class="card">
                    <div class="w-10 h-10 rounded-lg bg-ember/10 flex items-center justify-center mb-4">
                        <span class="w-3 h-3 rounded-full bg-ember"></span>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">{{ $service->nom }}</h3>
                    <p class="text-slate text-sm leading-relaxed">{{ $service->description }}</p>
                </div>
            @empty
                <p class="text-slate">Aucun service disponible pour le moment.</p>
            @endforelse
        </div>
    </section>
@endsection
