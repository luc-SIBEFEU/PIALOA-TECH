@extends('layouts.admin')

@section('title', 'Tableau de bord')
<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="card">
            <span class="eyebrow"><h3><i class="bi bi-pro"></i>Produits</h3></span>
            <p class="text-3xl font-display font-bold mt-2">{{ $stats['produits'] }}</p>
        </div>
        <div class="card">
            <span class="eyebrow" style="color:#3F7D33">Services</span>
            <p class="text-3xl font-display font-bold mt-2">{{ $stats['services'] }}</p>
        </div>
        <div class="card">
            <span class="eyebrow" style="color:#7A1F3D">Événements</span>
            <p class="text-3xl font-display font-bold mt-2">{{ $stats['evenements'] }}</p>
        </div>
        <div class="card">
            <span class="eyebrow" style="color:#5B5D63"><h3><i class="bi bi-person-circle"></i>Stagiaires</h3></span>
            <p class="text-3xl font-display font-bold mt-2">{{ $stats['stagiaires'] }}</p>
        </div>
        <div class="card">
            <span class="eyebrow" style="color:#5B5D63"><h3>Avis en attente</h3></span>
            <p class="text-3xl font-display font-bold mt-2">{{ $stats['avis'] }}</p>
        </div>
        <div class="card">
            <span class="eyebrow" style="color:#5B5D63"><h3>Taches Crées</h3></span>
            <p class="text-3xl font-display font-bold mt-2">{{ $stats['taches'] }}</p>
        </div>
    </div>

    <div class="card">
        <h2 class="font-display font-semibold text-lg mb-4">Derniers événements ajoutés</h2>
        @if ($derniersEvenements->isEmpty())
            <p class="text-slate text-sm">Aucun événement pour le moment.</p>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate border-b border-slate/10">
                        <th class="py-2">Nom</th>
                        <th class="py-2">Période</th>
                        <th class="py-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($derniersEvenements as $evenement)
                        <tr class="border-b border-slate/10 last:border-0">
                            <td class="py-3 font-medium">{{ $evenement->nom }}</td>
                            <td class="py-3 text-slate">{{ $evenement->periode_debut?->format('d/m/Y') }}</td>
                            <td class="py-3 text-right">
                                <a href="{{ route('admin.evenements.edit', $evenement) }}" class="text-ember font-display font-semibold hover:text-ink">Modifier</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
