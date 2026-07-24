{{-- resources/views/admin/stagiaires/document.blade.php --}}
@extends('layouts.admin')

@section('title', 'Document - ' . $stagiaire->nom)

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Document de {{ $stagiaire->nom }}</h1>
            <p class="text-slate text-sm">{{ $nomFichier }} ({{ $mimeType }})</p>
        </div>
        <div class="space-x-3">
            <a href="{{ route('admin.stagiaires.download', $stagiaire) }}" 
               class="btn-primary !px-5 !py-2.5 text-sm">
                <i class="bi bi-download"></i> Télécharger
            </a>
            <a href="{{ route('admin.stagiaires.index') }}" 
               class="btn-secondary !px-5 !py-2.5 text-sm">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <div class="card p-6">
        <div class="bg-slate/5 p-6 rounded-lg max-h-[600px] overflow-auto">
            <pre class="whitespace-pre-wrap font-mono text-sm">{{ $contenu }}</pre>
        </div>
    </div>

    <div class="mt-4 flex justify-end space-x-3">
        <form action="{{ route('admin.stagiaires.document.delete', $stagiaire) }}" 
              method="POST" 
              onsubmit="return confirm('Supprimer ce document ?');">
            @csrf @method('DELETE')
            <button type="submit" class="text-claret hover:text-ink">
                <i class="bi bi-trash"></i> Supprimer le document
            </button>
        </form>
    </div>
@endsection