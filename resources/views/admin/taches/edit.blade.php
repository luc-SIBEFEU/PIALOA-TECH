@extends('layouts.admin')

@section('title', "Modifier la Tâche")

@section('content')
    <form method="POST" action="{{ route('admin.taches.update', $tache) }}" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')
        @include('admin.taches.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.taches.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
