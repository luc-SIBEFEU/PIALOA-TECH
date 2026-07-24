
@extends('layouts.app')

@section('title', 'Stagiaires')
@section('content')

<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('bootstrap-icons/font/bootstrap-icons.css') }}">

<style>
    .text {
        text-align: center;
        margin-top: 100px;
    }
    .text h1 {
        font-size: 36px;
        margin-bottom: 20px;
        background: linear-gradient(45deg, red, blue);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    a{
        text-decoration: none;
        color:white;
    }
</style>
<section class="max-w-6xl mx-auto px-6 py-20">
        <span class="eyebrow">Stagiaires</span>
        <h1 class="text-4xl font-bold mt-2 mb-12">Nos stagiaires</h1>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
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


@endsection

