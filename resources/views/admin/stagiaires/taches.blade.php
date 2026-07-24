@extends('layouts.admin')

@section('title', 'Taches Effectués')
@section('content')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
    <a href="{{ route('admin.stagiaires.index') }}" class="text-sm mb-5 font-display font-semibold text-ember hover:text-ink">&larr; Retour </a>
    <div><h2 class="text-sm font-display font-semibold mb-7 mt-5 text-ember" style="font-weight: 700; font-size:20px;">
                Tâches de: <span class="text-ink" style="font-weight: 900; font-size:35px;"> {{ $stagiaire->nom }}</span>
            </h2></div>
    <div class="card !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">nom</th>
                    <th class="py-3 px-6">Description</th>
                    <th class="py-3 px-6">Période</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
    @forelse ($taches as $tache)
        <tr class="border-t border-slate-10">
            <td class="py-3 px-6 font-medium">{{ $tache->nom }}</td>
            
            <td class="py-3 px-6">
                {{ $tache->description }}
            </td>
            
            <td class="py-3 px-6 text-slate">
                {{ $tache->date_debut->format('d/m/Y') }}
                @if ($tache->date_fin) 
                    &rarr; {{ $tache->date_fin->format('d/m/Y') }} 
                @endif
            </td>

            <td class="py-3 px-6">
                <span class="px-2 py-1 text-xs rounded 
                    @if($tache->statut == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($tache->statut == 'in_progress') bg-blue-100 text-blue-800
                    @elseif($tache->statut == 'completed') bg-green-100 text-green-800
                    @endif">
                    {{ ucfirst($tache->statut) }}
                </span>
            </td>

            <td class="py-3 px-6 text-right">
                <a href="{{ route('admin.taches.edit', $stagiaire) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-pencil-fill"></i></a>
                            <form action="{{ route('admin.taches.destroy', $stagiaire) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce stagiaire ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash-fill"></i></button>
                            </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center py-4 text-slate-400">
                Aucune tâche trouvée pour ce stagiaire.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>
@endsection
