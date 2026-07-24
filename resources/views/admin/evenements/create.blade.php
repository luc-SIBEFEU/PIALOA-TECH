@extends('layouts.admin')

@section('title', 'Ajouter un événement')

@section('content')
    <form method="POST" action="{{ route('admin.evenements.store') }}" enctype="multipart/form-data" class="card">
        @csrf
        @include('admin.evenements.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.evenements.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
