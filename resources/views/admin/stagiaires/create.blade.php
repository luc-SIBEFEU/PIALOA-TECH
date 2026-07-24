@extends('layouts.admin')

@section('title', 'Ajouter un stagiaire')

@section('content')
    <form method="POST" action="{{ route('admin.stagiaires.store') }}" enctype="multipart/form-data" class="card">
        @csrf
        @include('admin.stagiaires.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.stagiaires.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
