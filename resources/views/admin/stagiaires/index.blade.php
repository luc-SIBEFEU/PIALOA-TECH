@extends('layouts.admin')
<style>
    .for{
        display : flex;
    }

    li:hover{
        cursor:pointer;
    }
    li{
        list-style-type: none;
        display: inline-block;
        border : solid 1px;
        margin : 10px;
        padding: 5px;
        border-radius: 5px;
    }
    .all{
        background : rgb(236, 175, 8);
    }
</style>
@section('title', 'Stagiaires')
<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
@section('content')
    <div class="flex items-center justify-between mb-6">
        <p class="text-slate text-sm">{{ $stagiaires->total() }} stagiaire(s)</p>
        <form method="POST" action="{{ route('admin.search') }}">
            @csrf
            <div class="for">
                <div><input type="text"  name="nom" class="input-field" required placeholder="Nom"></div>
                <div><button type="submit" class="btn-primary"><i class="bi bi-search">Rechercher</i></button></div>
            </div>
        </form>
        <a href="{{ route('admin.stagiaires.create') }}" class="btn-primary !px-5 !py-2.5 text-sm">+ Ajouter un stagiaire</a> <br>
        
    </div>
    @if ($result)
        <div class="flex justify-between mb-6 items-center">
            <div><h2 class="text-sm font-display font-semibold mb-7 mt-5 text-ember" style="font-weight: 700; font-size:20px;">
                Resultats Pour: <span class="text-ink" style="font-weight: 900; font-size:35px;"> {{ $result }}</span>
            </h2></div>
            <div><a href="{{ route('admin.stagiaires.index') }}" class="text-sm font-display font-semibold text-ember hover:text-ink">Clear </a></div>
        </div>
    @endif
    <ul>
        <li id="all" class="all" onclick="display_all()">Tout</li>
        <li id="pending" onclick="display_pending()">En Cours</li>
        <li id="accepted" onclick="display_accept()">Terminés</li>
    </ul>
    <div id="table_all" class="card !p-0 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Avatar</th>
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">E-mail</th>
                    <th class="py-3 px-6">Secteur</th>
                    <th class="py-3 px-6">Période</th>
                    <th class="py-3 px-6">Description</th>
                    <th class="py-3 px-6">Rapport</th>
                    <th class="py-3 px-6">Staut</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stagiaires as $stagiaire)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6">
                            @if ($stagiaire->avatar)
                                <img src="{{ asset('storage/'.$stagiaire->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate/10"></div>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-medium">{{ $stagiaire->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $stagiaire->email }}</td>
                        <td class="py-3 px-6 text-slate">{{ $stagiaire->secteur }}</td>
                        <td class="py-3 px-6 text-slate">
                            {{ $stagiaire->periode_debut?->format('d/m/Y') }}
                            @if ($stagiaire->periode_fin) &rarr; {{ $stagiaire->periode_fin->format('d/m/Y') }} @endif
                        </td>
                        <td class="py-3 px-6 text-slate">{{ $stagiaire->description }}</td>
                         <td class="py-3 px-6">
                            @if ($stagiaire->hasRapport())
    <div class="flex items-center space-x-2">
        <i class="bi bi-file-text text-amber"></i>
        <a href="{{ route('admin.stagiaires.document', $stagiaire) }}" 
           class="text-amber hover:text-ink font-semibold" 
           target="_blank">
            <i class="bi bi-eye"></i> Voir
        </a>
        <a href="{{ route('admin.stagiaires.download', $stagiaire) }}" 
           class="text-slate hover:text-ink">
            <i class="bi bi-download"></i>
        </a>
        <form action="{{ route('admin.stagiaires.document.delete', $stagiaire) }}" 
              method="POST" 
              class="inline" 
              onsubmit="return confirm('Supprimer ce document ?');">
            @csrf @method('DELETE')
            <button type="submit" class="text-claret hover:text-ink">
                <i class="bi bi-x-circle"></i>
            </button>
        </form>
    </div>
@else
    <span class="text-slate/50 text-xs">Aucun document</span>
@endif
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 text-xs rounded 
                    @if($stagiaire->statut == 'en_cours') bg-blue-100 text-blue-800
                    @elseif($stagiaire->statut == 'termine') bg-green-100 text-green-800
                    @endif">{{ $stagiaire->statut }}</span>
                        </td>
                        <td class="py-3 px-6 text-right space-x-3">

                            <a href="{{ route('admin.taches.view', $stagiaire) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-newspaper"></i></a>
                            <a href="{{ route('admin.stagiaires.edit', $stagiaire) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-pencil-fill"></i></a>
                            <form action="{{ route('admin.stagiaires.destroy', $stagiaire) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce stagiaire ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 px-6 text-center text-slate">Aucun stagiaire pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $stagiaires->links() }}</div>

    {{-- EN COURS --}}

    <div id="table_added" class="card !p-0 overflow-hidden" style="display:none;">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Avatar</th>
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">E-mail</th>
                    <th class="py-3 px-6">Secteur</th>
                    <th class="py-3 px-6">Période</th>
                    <th class="py-3 px-6">Description</th>
                    <th class="py-3 px-6">Rapport</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pending as $pending)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6">
                            @if ($pending->avatar)
                                <img src="{{ asset('storage/'.$pending->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate/10"></div>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-medium">{{ $pending->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $pending->email }}</td>
                        <td class="py-3 px-6 text-slate">{{ $pending->secteur }}</td>
                        <td class="py-3 px-6 text-slate">
                            {{ $pending->periode_debut?->format('d/m/Y') }}
                            @if ($pending->periode_fin) &rarr; {{ $pending->periode_fin->format('d/m/Y') }} @endif
                        </td>
                        <td class="py-3 px-6 text-slate">{{ $pending->description }}</td>
                         <td class="py-3 px-6">
                            @if ($pending->hasRapport())
    <div class="flex items-center space-x-2">
        <i class="bi bi-file-text text-amber"></i>
        <a href="{{ route('admin.stagiaires.document', $pending) }}" 
           class="text-amber hover:text-ink font-semibold" 
           target="_blank">
            <i class="bi bi-eye"></i> Voir
        </a>
        <a href="{{ route('admin.stagiaires.download', $pending) }}" 
           class="text-slate hover:text-ink">
            <i class="bi bi-download"></i>
        </a>
        <form action="{{ route('admin.stagiaires.document.delete', $pending) }}" 
              method="POST" 
              class="inline" 
              onsubmit="return confirm('Supprimer ce document ?');">
            @csrf @method('DELETE')
            <button type="submit" class="text-claret hover:text-ink">
                <i class="bi bi-x-circle"></i>
            </button>
        </form>
    </div>
@else
    <span class="text-slate/50 text-xs">Aucun document</span>
@endif
                        </td>
                        <td class="py-3 px-6 text-right space-x-3">

                            <a href="{{ route('admin.taches.view', $pending) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-newspaper"></i></a>
                            <a href="{{ route('admin.stagiaires.edit', $pending) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-pencil-fill"></i></a>
                            <form action="{{ route('admin.stagiaires.destroy', $pending) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce stagiaire ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 px-6 text-center text-slate">Aucun stagiaire pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- TERMINÉs --}}

    <div id="table_validate" class="card !p-0 overflow-hidden" style="display:none;">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Avatar</th>
                    <th class="py-3 px-6">Nom</th>
                    <th class="py-3 px-6">E-mail</th>
                    <th class="py-3 px-6">Secteur</th>
                    <th class="py-3 px-6">Période</th>
                    <th class="py-3 px-6">Description</th>
                    <th class="py-3 px-6">Rapport</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ended as $ended)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6">
                            @if ($ended->$ended)
                                <img src="{{ asset('storage/'.$ended->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate/10"></div>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-medium">{{ $ended->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $ended->email }}</td>
                        <td class="py-3 px-6 text-slate">{{ $ended->secteur }}</td>
                        <td class="py-3 px-6 text-slate">
                            {{ $ended->periode_debut?->format('d/m/Y') }}
                            @if ($ended->periode_fin) &rarr; {{ $ended->periode_fin->format('d/m/Y') }} @endif
                        </td>
                        <td class="py-3 px-6 text-slate">{{ $ended->description }}</td>
                         <td class="py-3 px-6">
                            @if ($ended->hasRapport())
    <div class="flex items-center space-x-2">
        <i class="bi bi-file-text text-amber"></i>
        <a href="{{ route('admin.stagiaires.document', $ended) }}" 
           class="text-amber hover:text-ink font-semibold" 
           target="_blank">
            <i class="bi bi-eye"></i> Voir
        </a>
        <a href="{{ route('admin.stagiaires.download', $ended) }}" 
           class="text-slate hover:text-ink">
            <i class="bi bi-download"></i>
        </a>
        <form action="{{ route('admin.stagiaires.document.delete', $ended) }}" 
              method="POST" 
              class="inline" 
              onsubmit="return confirm('Supprimer ce document ?');">
            @csrf @method('DELETE')
            <button type="submit" class="text-claret hover:text-ink">
                <i class="bi bi-x-circle"></i>
            </button>
        </form>
    </div>
@else
    <span class="text-slate/50 text-xs">Aucun document</span>
@endif
                        </td>
                        <td class="py-3 px-6 text-right space-x-3">

                            <a href="{{ route('admin.taches.view', $ended) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-newspaper"></i></a>
                            <a href="{{ route('admin.stagiaires.edit', $ended) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-pencil-fill"></i></a>
                            <form action="{{ route('admin.stagiaires.destroy', $ended) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce stagiaire ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="py-8 px-6 text-center text-slate">Aucun stagiaire pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>

         /* tableaux */
            let table_all = document.getElementById('table_all');
            let table_validate = document.getElementById('table_validate');
            let table_added = document.getElementById('table_added');

            /*boutons*/
            let all = document.getElementById('all');
            let accepted = document.getElementById('accepted');
            let pending = document.getElementById('pending');

        function display_pending(){
            if(table_added.style.display = "none"){
                table_all.style.display = "none";
                table_added.style.display = "block";
                table_validate.style.display = "none";

                pending.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                all.style = accepted.style = "background : white; color : black; border: solid 1px black; margin : 10px; padding: 5px; border-radius: 5px;";

            }
        }
        function display_all(){
            if(table_all.style.display = "none"){
                table_all.style.display = "block";
                table_added.style.display = "none";
                table_validate.style.display = "none";

                all.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                pending.style = accepted.style = "background : white; color : black; border: solid 1px black; margin : 10px; padding: 5px; border-radius: 5px;";

            }
        }
        function display_accept(){
            if(table_validate.style.display="none"){
                table_all.style.display = "none";
                table_added.style.display = "none";
                table_validate.style.display = "block";

                accepted.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                all.style = pending.style = "background : white; color : black; border: solid 1px; margin : 10px; padding: 5px; border-radius: 5px;";
            }
        }
    </script>
@endsection
