@extends('layouts.admin')

@section('title', 'Modifier le service')

@section('content')
    <form method="POST" action="{{ route('admin.services.update', $service) }}" class="card">
        @csrf
        @method('PUT')
        @include('admin.services.form')
        <div class="flex gap-3 mt-8">
            <button type="submit" class="btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.services.index') }}" class="btn-outline">Annuler</a>
        </div>
    </form>
@endsection
