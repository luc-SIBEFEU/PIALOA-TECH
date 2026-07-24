@extends('layouts.admin')

@section('title', 'Événements')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-slate text-sm">{{ $evenements->total() }} événement(s)</p>
        <a href="{{ route('admin.evenements.create') }}" class="btn-primary !px-5 !py-2.5 text-sm">+ Ajouter un événement</a>
    </div>

    <div class="card !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Image</th>
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">Période</th>
                    <th class="py-3 px-6">Document</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($evenements as $evenement)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6">
                            @if ($evenement->image)
                                <img src="{{ asset('storage/'.$evenement->image) }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate/10"></div>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-medium">{{ $evenement->nom }}</td>
                        <td class="py-3 px-6 text-slate">
                            {{ $evenement->periode_debut?->format('d/m/Y') }}
                            @if ($evenement->periode_fin) &rarr; {{ $evenement->periode_fin->format('d/m/Y') }} @endif
                        </td>
                        <td class="py-3 px-6">
                            @if ($evenement->document)
                                <a href="{{ asset('storage/'.$evenement->document) }}" target="_blank" class="text-ember font-display font-semibold">Voir</a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.evenements.edit', $evenement) }}" class="text-ember font-display font-semibold hover:text-ink">Modifier</a>
                            <form action="{{ route('admin.evenements.destroy', $evenement) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet événement ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 px-6 text-center text-slate">Aucun événement pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $evenements->links() }}</div>
@endsection
