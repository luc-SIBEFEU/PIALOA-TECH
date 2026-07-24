<div class="grid gap-5 max-w-2xl">
    <div>
        <label for="nom" class="label-field">Nom de la tâche</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $tache->nom) }}" class="input-field" required>
    </div>

    <div>
        <label for="description" class="label-field">Description</label>
        <textarea name="description" id="description" rows="5" class="input-field" required>{{ old('description', $tache->description) }}</textarea>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="periode_debut" class="label-field">Date de début</label>
            <input type="date" name="date_debut" id="periode_debut"
                   value="{{ old('date_debut', optional($tache->date_debut)->format('Y-m-d')) }}"
                   class="input-field" required>
        </div>
        <div>
            <label for="periode_fin" class="label-field">Date de fin</label>
            <input type="date" name="date_fin" id="periode_fin"
                   value="{{ old('date_fin', optional($tache->date_fin)->format('Y-m-d')) }}"
                   class="input-field" required>
        </div>
        <div>
            <label for="periode_fin" class="label-field">Statut</label>
            <select name="statut" id="statut" class="input-field" required>
                <option value="pending" {{ old('statut', $tache->statut) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('statut', $tache->statut) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('statut', $tache->statut) == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div>
    <label for="rapport" class="label-field">Rapport (document)</label>
    
    {{-- Afficher le document existant s'il y en a un --}}
    @if ($tache->hasRapport())
        <div class="mb-3 flex items-center space-x-3 bg-slate/5 p-3 rounded-lg">
            <i class="bi bi-file-text text-ember"></i>
            <span class="text-sm font-medium">{{ $tache->getRapportNom() }}</span>
            <span class="text-xs text-slate">
                ({{ number_format($tache->getRapportTaille() / 1024, 2) }} KB)
            </span>
            <a href="{{ route('admin.taches.document', $tache) }}" 
               class="text-ember hover:text-ink text-sm" target="_blank">
                <i class="bi bi-eye"></i> Voir
            </a>
            <form action="{{ route('admin.taches.document.delete', $tache) }}" 
                  method="POST" 
                  class="inline" 
                  onsubmit="return confirm('Supprimer ce document ?');">
                @csrf @method('DELETE')
                <button type="submit" class="text-claret hover:text-ink text-sm">
                    <i class="bi bi-x-circle"></i> Supprimer
                </button>
            </form>
        </div>
    @endif

    {{-- Champ d'upload --}}
    <input type="file" 
           name="rapport" 
           id="rapport" 
           accept=".pdf,.doc,.docx,.txt,.xlsx,.xls,.ppt,.pptx" 
           class="input-field">
    <p class="text-xs text-slate mt-1">Formats acceptés : PDF, DOC, DOCX, TXT, XLSX, XLS, PPT, PPTX (max 10MB)</p>
</div>
        <div>
        <label for="stagiaire_id" class="label-field">Stagiaire concerné</label>
        <select name="stagiaire_id" id="stagiaire_id" class="input-field" required>
            <!-- <option value="">-- Sélectionnez un stagiaire --</option> -->
            @foreach($stagiaires as $id => $nom)
                <option value="{{ $id }}" {{ old('stagiaire_id') == $id ? 'selected' : '' }}>
                    {{ $nom }}
                </option>
            @endforeach
        </select>
        </div>
        @error('stagiaire_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
