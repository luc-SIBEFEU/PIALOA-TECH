@extends('layouts.admin')

@section('title', 'Ajouter un service')
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.min.css') }}">
@section('content')
    <form method="POST" action="{{ route('admin.services.store') }}" class="card">
        @csrf
        @include('admin.services.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Enregistrer</button>
            <a href="{{ route('admin.services.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
