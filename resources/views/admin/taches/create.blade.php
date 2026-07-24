@extends('layouts.admin')

@section('title', 'Ajouter une Tâche')

@section('content')
    <form method="POST" action="{{ route('admin.taches.store') }}" enctype="multipart/form-data" class="card">
        @csrf
        @include('admin.taches.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.taches.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
