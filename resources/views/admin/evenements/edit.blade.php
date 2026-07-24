@extends('layouts.admin')

@section('title', "Modifier l'événement")

@section('content')
    <form method="POST" action="{{ route('admin.evenements.update', $evenement) }}" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')
        @include('admin.evenements.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.evenements.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
