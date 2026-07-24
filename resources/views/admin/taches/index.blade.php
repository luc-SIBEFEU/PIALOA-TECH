@extends('layouts.admin')

@section('title', 'Tâches')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-slate text-sm">{{ $taches->total() }} tâche(s)</p>
        <a href="{{ route('admin.taches.create') }}" class="btn-primary !px-5 !py-2.5 text-sm">+ Ajouter une tâche</a>
    </div>

    <div class="card !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">nom</th>
                    <th class="py-3 px-6">Description</th>
                    <th class="py-3 px-6">Période</th>
                    <th class="py-3 px-6">Rapport</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($taches as $tache)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6 font-medium">{{ $tache->nom }}</td>
                        <td class="py-3 px-6 font-medium">{{ $tache->description}}</td>
                        <td class="py-3 px-6 text-slate">
                            {{ $tache->date_debut?->format('d/m/Y') }}
                            @if ($tache->date_fin) &rarr; {{ $tache->date_fin->format('d/m/Y') }} @endif
                        </td>
                        <td>
                        @if ($tache->hasRapport())
    <div class="flex items-center space-x-2">
        <i class="bi bi-file-text text-amber"></i>
        <a href="{{ route('admin.taches.document', $tache) }}" 
           class="text-amber hover:text-ink font-semibold" 
           target="_blank">
            <i class="bi bi-eye"></i> Voir
        </a>
        <a href="{{ route('admin.taches.download', $tache) }}" 
           class="text-slate hover:text-ink">
            <i class="bi bi-download"></i>
        </a>
        <form action="{{ route('admin.taches.document.delete', $tache) }}" 
              method="POST" 
              class="inline" 
              onsubmit="return confirm('Supprimer ce document ?');">
            @csrf @method('DELETE')
            <button type="submit" class="text-claret hover:text-ink">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
@else
    <span class="text-slate/50 text-xs">Aucun document</span>
@endif
</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.taches.edit', $tache) }}" class="text-ember font-display font-semibold hover:text-ink">Modifier</a>
                            <form action="{{ route('admin.taches.destroy', $tache) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette tâche ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 px-6 text-center text-slate">Aucune tâche pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
