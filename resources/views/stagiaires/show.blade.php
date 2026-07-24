@extends('layouts.app')

@section('title', $stagiaire->nom . ' - Stagiaire')
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <section class="max-w-4xl mx-auto px-6 py-20">
        <a href="{{ route('stagiaire.index') }}" class="text-sm font-display font-semibold text-ember hover:text-ink">&larr; Retour aux Stagiaires</a>

        <span class="eyebrow block mt-6">
            {{ $stagiaire->periode_debut?->translatedFormat('d M Y') }}
            @if ($stagiaire->periode_fin) &rarr; {{ $stagiaire->periode_fin->translatedFormat('d M Y') }} @endif
        </span>
        
        <h1 class="text-4xl font-bold mt-2 mb-6">{{ $stagiaire->nom }}</h1>
        <h3 class="eyebrow block font-bold mt-2" style="font-weight:900; font-size:25px;">Thème : {{ $stagiaire->secteur }}<br></h3>
        <span class="text-4xl mb-8" style="font-weight:900; font-size:15px;">{{ $stagiaire->description }}</span>
        
        @if ($stagiaire->avatar)
            <img src="{{ asset('storage/'.$stagiaire->avatar) }}" alt="{{ $stagiaire->nom }}" class="rounded-2xl mb-8 w-full max-h-96 object-cover">
        @endif

        <div class="prose max-w-none text-slate leading-relaxed whitespace-pre-line mb-12">
            {{-- Affichage du rapport si présent --}}
            @if($stagiaire->hasRapport())
                <span class="flex items-center gap-2">
                    <i class="bi bi-file-text text-ember"></i>
                    <a href="{{ route('stagiaire.document', $stagiaire) }}"  class="text-ember hover:text-ink font-medium"  target="_blank">
                         <i class="bi bi-eye"></i> Voir Le rapport de stage
                    </a><br>
                    <a href="{{ route('stagiaire.download', $stagiaire) }}" class="text-slate hover:text-ink">
                        <i class="bi bi-download"></i> Télécharger le rapport
                    </a>
                </span>
            @endif
        </div>

        {{-- Section des statistiques des tâches --}}
        <!-- @if($totalTaches > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                <div class="bg-slate/5 rounded-xl p-6 text-center">
                    <p class="text-3xl font-bold text-ember">{{ $totalTaches }}</p>
                    <p class="text-sm text-slate">Total tâches</p>
                </div>
                <div class="bg-green-50 rounded-xl p-6 text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $tachesCompletees }}</p>
                    <p class="text-sm text-slate">Terminées</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-6 text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $tachesEnCours }}</p>
                    <p class="text-sm text-slate">En cours</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-6 text-center">
                    <p class="text-3xl font-bold text-yellow-600">{{ $tachesEnAttente }}</p>
                    <p class="text-sm text-slate">En attente</p>
                </div>
            </div>
        @endif -->

        {{-- Section des réalisations --}}
            
        @if($tachesCompletees > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6 flex items-center">
                <span>Réalisations : </span>
                @if($tachesCompletees > 0)
                        {{ $tachesCompletees }} 
                @endif
            </h2>
                <div class="space-y-4">
                    @foreach($taches as $tache)
                        @if($tache->statut == 'completed')
                        <div class="bg-white rounded-xl shadow-sm border border-slate/10 p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold">{{ $tache->nom }}</h3>
                                    </div>
                                    
                                    @if($tache->description)
                                        <p class="text-slate text-sm mb-3">{{ $tache->description }}</p>
                                    @endif
                                    
                                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate/70">
                                        <span>
                                            <i class="bi bi-calendar"></i> 
                                            Début : {{ $tache->date_debut->format('d/m/Y') }}
                                        </span>
                                        @if($tache->date_fin)
                                            <span>
                                                <i class="bi bi-calendar-check"></i> 
                                                Fin : {{ $tache->date_fin->format('d/m/Y') }}
                                            </span>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="bg-slate/5 rounded-xl p-12 text-center">
                    <i class="bi bi-clipboard text-4xl text-slate/30 mb-3"></i>
                    <p class="text-slate">Aucune tâche réalisée pour le moment</p>
                </div>
            @endif
        </div>
    </section>
@endsection