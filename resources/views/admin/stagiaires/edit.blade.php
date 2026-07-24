@extends('layouts.admin')

@section('title', 'Modifier le stagiaire')
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <form method="POST" action="{{ route('admin.stagiaires.update', $stagiaire) }}" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')
        @include('admin.stagiaires.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.stagiaires.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
