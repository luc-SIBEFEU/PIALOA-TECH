@extends('layouts.admin')

@section('title', 'Avis')

<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.css') }}">
<style>
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
@section('content')
<div class="flex items-center justify-between mb-6">
        <p class="text-slate text-sm">{{ $avis->total() }}  Avis</p>
    </div>
    <ul>
        <li id="all" class="all" onclick="display_all()">Tout</li>
        <li id="pending" onclick="display_pending()">En attente</li>
        <li id="accepted" onclick="display_accept()">Acceptés</li>
        <li id="rejected" onclick="display_rejected()">Rejétés</li>
    </ul>
    <div id="table_all" class="card !p-0 overflow-hidden all">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Client</th>
                    <th class="py-3 px-6">mail</th>
                    <th class="py-3 px-6">statut</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($avis as $avis)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6 font-medium">{{ $avis->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $avis->email }}</td>
                        <td class="py-3 px-6">{{ $avis->statut }}</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.avi.see', $avis) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-eye-fill"></i></a>
                            <!-- Valider -->
                             @if ($avis->statut == 'en attente')
                            <a href="#" onclick="event.preventDefault(); document.getElementById('validate-form-{{ $avis->id }}').submit();" class="text-green-600 font-display font-semibold hover:text-green-800">
                                <i class="bi bi-check-circle-fill"></i>
                            </a>
                                <form id="validate-form-{{ $avis->id }}" action="{{ route('admin.avi.validate', $avis) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            <!-- Rejeter -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('cancel-form-{{ $avis->id }}').submit();" class="text-red-600 font-display font-semibold hover:text-red-800">
                                <i class="bi bi-x-circle-fill"></i>
                            </a>
                                <form id="cancel-form-{{ $avis->id }}" action="{{ route('admin.avi.cancel', $avis) }}" method="POST" style="display: none;">
                                @csrf
                                </form>
                            @endif
                            <form action="{{ route('admin.avi.destroy', $avis) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 px-6 text-center text-slate">Aucun Avis pour le moment.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
<!-- AVIS ACCEPTÉs -->
 <div id="table_validate" class="card !p-0 overflow-hidden" style="display:none;">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Client</th>
                    <th class="py-3 px-6">mail</th>
                    <th class="py-3 px-6">statut</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($avis_accepted as $avis_accepted)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6 font-medium">{{ $avis_accepted->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $avis_accepted->email }}</td>
                        <td class="py-3 px-6">{{ $avis_accepted->statut }}</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.avi.see', $avis_accepted) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-eye-fill"></i></a>
                            <form action="{{ route('admin.avi.destroy', $avis_accepted) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 px-6 text-center text-slate">Aucun Avis Accepté trouvé </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <!-- AVIS REJÉTÉS -->
      <div id="table_denided" class="card !p-0 overflow-hidden" style="display:none;">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Client</th>
                    <th class="py-3 px-6">mail</th>
                    <th class="py-3 px-6">statut</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($avis_denided as $avis_denided)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6 font-medium">{{ $avis_denided->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $avis_denided->email }}</td>
                        <td class="py-3 px-6">{{ $avis_denided->statut }}</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.avi.see', $avis_denided) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-eye-fill"></i></a>
                            <form action="{{ route('admin.avi.destroy', $avis_denided) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 px-6 text-center text-slate">Aucun Avis Rejété Trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- AVIS AJOUTÉS -->
     <div id="table_added" class="card !p-0 overflow-hidden" style="display:none">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left bg-slate/5 text-slate">
                    <th class="py-3 px-6">Client</th>
                    <th class="py-3 px-6">mail</th>
                    <th class="py-3 px-6">statut</th>
                    <th class="py-3 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($avis_added as $avis_added)
                    <tr class="border-t border-slate/10">
                        <td class="py-3 px-6 font-medium">{{ $avis_added->nom }}</td>
                        <td class="py-3 px-6 text-slate">{{ $avis_added->email }}</td>
                        <td class="py-3 px-6">{{ $avis_added->statut }}</td>
                        <td class="py-3 px-6 text-right space-x-3">
                            <a href="{{ route('admin.avi.see', $avis_added) }}" class="text-ember font-display font-semibold hover:text-ink"><i class="bi bi-eye-fill"></i></a>
                            <!-- Valider -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('validate-form-{{ $avis_added->id }}').submit();" class="text-green-600 font-display font-semibold hover:text-green-800">
                                <i class="bi bi-check-circle-fill"></i>
                            </a>
                                <form id="validate-form-{{ $avis_added->id }}" action="{{ route('admin.avi.validate', $avis_added) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            <!-- Rejeter -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('cancel-form-{{ $avis_added->id }}').submit();" class="text-red-600 font-display font-semibold hover:text-red-800">
                                <i class="bi bi-x-circle-fill"></i>
                            </a>
                                <form id="cancel-form-{{ $avis_added->id }}" action="{{ route('admin.avi.cancel', $avis_added) }}" method="POST" style="display: none;">
                                @csrf
                                </form>
                            <form action="{{ route('admin.avi.destroy', $avis_added) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-claret font-display font-semibold hover:text-ink"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-8 px-6 text-center text-slate">Aucun Avis en attente de Validation trouvé</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
            /* tableaux */
            let table_all = document.getElementById('table_all');
            let table_validate = document.getElementById('table_validate');
            let table_denided = document.getElementById('table_denided');
            let table_added = document.getElementById('table_added');

            /*boutons*/
            let all = document.getElementById('all');
            let accepted = document.getElementById('accepted');
            let pending = document.getElementById('pending');
            let rejected = document.getElementById('rejected');

        function display_accept(){
            if(table_validate.style.display="none"){
                table_all.style.display = "none";
                table_denided.style.display = "none";
                table_added.style.display = "none";
                table_validate.style.display = "block";

                accepted.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                all.style = pending.style = rejected.style = "background : white; color : black; border: solid 1px; margin : 10px; padding: 5px; border-radius: 5px;";
            }
        }
        function display_pending(){
            if(table_added.style.display = "none"){
                table_all.style.display = "none";
                table_denided.style.display = "none";
                table_added.style.display = "block";
                table_validate.style.display = "none";

                pending.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                all.style = accepted.style = rejected.style = "background : white; color : black; border: solid 1px black; margin : 10px; padding: 5px; border-radius: 5px;";

            }
        }
        function display_all(){
            if(table_all.style.display = "none"){
                table_all.style.display = "block";
                table_denided.style.display = "none";
                table_added.style.display = "none";
                table_validate.style.display = "none";

                all.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                pending.style = accepted.style = rejected.style = "background : white; color : black; border: solid 1px black; margin : 10px; padding: 5px; border-radius: 5px;";

            }

        }
        function display_rejected(){
            if(table_denided.style.display = "none"){
                table_all.style.display = "none";
                table_denided.style.display = "block";
                table_added.style.display = "none";
                table_validate.style.display = "none";

                rejected.style = "background : rgb(236, 175, 8); color : black; border:solid 1px black;";
                all.style = accepted.style = pending.style = "background : white; color : black; border: solid 1px black; margin : 10px; padding: 5px; border-radius: 5px;";

            }

        }
    </script>
@endsection