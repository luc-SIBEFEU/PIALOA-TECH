@extends('layouts.admin')
@section('title','Produits')
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-slate text-sm">{{ $produits->total() }} <i class="bi bi-box-seam text-sm"></i> produit(s)</p>
        <a href="{{ route('admin.produits.create') }}" class="btn-primary !px-5 !py-2.5 text-sm">+ Ajouter un produit</a>
    </div>

    <div class="card !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Image</th>
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">Site web</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produits as $produit)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6">
                            @if ($produit->image)
                                <img src="{{ asset('storage/'.$produit->image) }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-slate/10"></div>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-medium">{{ $produit->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $produit->site_web ?: '—' }}</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.produits.edit', $produit) }}" class="text-ember font-display font-semibold hover:text-ink">Modifier</a>
                            <form action="{{ route('admin.produits.destroy', $produit) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce produit ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-8 px-6 text-center text-slate">Aucun produit pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $produits->links() }}</div>
@endsection
