@extends('layouts.admin')

@section('title', 'Services')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-slate text-sm">{{ $services->total() }} service(s)</p>
        <a href="{{ route('admin.services.create') }}" class="btn-primary !px-5 !py-2.5 text-sm">+ Ajouter un service</a>
    </div>

    <div class="card !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">Description</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6 font-medium">{{ $service->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ Str::limit($service->description, 60) }}</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-ember font-display font-semibold hover:text-ink">Modifier</a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce service ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="py-8 px-6 text-center text-slate">Aucun service pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $services->links() }}</div>
@endsection
