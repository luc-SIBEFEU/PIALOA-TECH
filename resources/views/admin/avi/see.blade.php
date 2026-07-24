@extends('layouts.admin')

@section('title', 'Avis')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-slate text-sm">Détail de l'avis</p>
</div>

<div>
    <p><strong>Client :</strong> {{ $avis->nom }}</p>
    <p><strong>Email :</strong> {{ $avis->email }}</p>
    <p><strong>Message :</strong></p>
    <p>{{ $avis->message }}</p>
    <p><strong>Statut :</strong> {{ $avis->statut }}</p>
    <p><strong>Date :</strong> {{ $avis->created_at->format('d/m/Y H:i') }}</p>
</div>

<a href="{{ route('admin.avi.index') }}" class="text-ember font-display font-semibold hover:text-ink">Retour</a>
@endsection