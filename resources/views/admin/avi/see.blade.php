@extends('layouts.admin')

@section('title', 'Détail de l\'avis')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-slate text-sm">Détail de l'avis</p>
    <a href="{{ route('admin.avi.index') }}" class="text-ember font-display font-semibold hover:text-ink">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card p-6">
    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <p class="text-sm text-slate mb-1"><i class="bi bi-person"></i> Client</p>
            <p class="font-semibold text-lg">{{ $avis->nom }}</p>
        </div>
        <div>
            <p class="text-sm text-slate mb-1"><i class="bi bi-envelope"></i> Email</p>
            <p class="font-semibold">{{ $avis->email }}</p>
        </div>
        <div>
            <p class="text-sm text-slate mb-1"><i class="bi bi-clipboard"></i> Statut</p>
            <p class="font-semibold">
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $avis->statut_badge }}">
                    {{ $avis->statut_libelle }}
                </span>
            </p>
        </div>
        <div>
            <p class="text-sm text-slate mb-1">
                <i class="bi bi-calendar3"></i> Reçu le</p>
            <p class="font-semibold">
                {{ $avis->date_creation_formatee }}
            </p>
        </div>
    </div>
    
    <div class="mt-6">
        <p class="text-sm text-slate mb-3"><i class="fa-solid fa-comments"></i> Message</p>
        <div class="bg-slate/5 p-5 rounded-lg border border-slate/10">
            <p class="text-slate leading-relaxed whitespace-pre-line">{{ $avis->message }}</p>
        </div>
    </div>

    @if($avis->isEnAttente())
        <div class="mt-6 flex gap-3">
            <form action="{{ route('admin.avi.validate', $avis) }}" method="POST">
                @csrf
                <button type="submit" class="btn-success">
                    <i class="bi bi-check-circle"></i> Approuver
                </button>
            </form>
            <form action="{{ route('admin.avi.cancel', $avis) }}" method="POST">
                @csrf
                <button type="submit" class="btn-danger">
                    <i class="bi bi-x-circle"></i> Rejeter
                </button>
            </form>
        </div>
    @endif
</div>
@endsection