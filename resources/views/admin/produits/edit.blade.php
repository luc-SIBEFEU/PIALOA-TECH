@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
    <form method="POST" action="{{ route('admin.produits.update', $produit) }}" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')
        @include('admin.produits.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.produits.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
