<div class="grid gap-5 max-w-2xl">
    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="nom" class="label-field">Nom complet</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom', $stagiaire->nom) }}" class="input-field" required>
        </div>
        <div>
            <label for="email" class="label-field">Adresse e-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email', $stagiaire->email) }}" class="input-field" required>
        </div>
    </div>

    <!-- <div>
        <label for="password" class="label-field">
            Mot de passe
            @if ($stagiaire->exists) <span class="text-slate font-normal">(laisser vide pour ne pas modifier)</span> @endif
        </label>
        <input type="password" name="password" id="password" class="input-field" {{ $stagiaire->exists ? '' : 'required' }}>
    </div> -->

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="periode_debut" class="label-field">Date de début</label>
            <input type="date" name="periode_debut" id="periode_debut"
                   value="{{ old('periode_debut', optional($stagiaire->periode_debut)->format('Y-m-d')) }}"
                   class="input-field" required>
        </div>
        <div>
            <label for="periode_fin" class="label-field">Date de fin (optionnel)</label>
            <input type="date" name="periode_fin" id="periode_fin"
                   value="{{ old('periode_fin', optional($stagiaire->periode_fin)->format('Y-m-d')) }}"
                   class="input-field">
        </div>
    </div>

    <div>
        <label for="secteur" class="label-field">Theme</label>
        <input type="text" name="secteur" id="secteur" value="{{ old('secteur', $stagiaire->secteur) }}" placeholder="ex : Développement web" class="input-field" required>
    </div>
    <div>
        <label for="description" class="label-field">Description</label>
        <input type="text" name="description" id="description" class="input-field" value="{{ old('description', $stagiaire->description) }}" placeholder="Description du theme ou du projet de stage" required>
    </div>
    <div>
        <div>
            <label for="periode_fin" class="label-field">Statut</label>
            <select name="statut" id="statut" class="input-field" required>
                <option value="termine" {{ old('statut', $stagiaire->statut) == 'termine' ? 'selected' : '' }}>Terminé</option>
                <option selected value="en_cours" {{ old('statut', $stagiaire->statut) == 'en_cours' ? 'selected' : '' }}>En Cours</option>
            </select>
        </div>
    <label for="rapport" class="label-field">Rapport (document)</label>
    
    {{-- Afficher le document existant s'il y en a un --}}
    @if ($stagiaire->hasRapport())
        <div class="mb-3 flex items-center space-x-3 bg-slate/5 p-3 rounded-lg">
            <i class="bi bi-file-text text-ember"></i>
            <span class="text-sm font-medium">{{ $stagiaire->getRapportNom() }}</span>
            <span class="text-xs text-slate">
                ({{ number_format($stagiaire->getRapportTaille() / 1024, 2) }} KB)
            </span>
            <a href="{{ route('admin.stagiaires.document', $stagiaire) }}" 
               class="text-ember hover:text-ink text-sm" target="_blank">
                <i class="bi bi-eye"></i> Voir
            </a>
            <form action="{{ route('admin.stagiaires.document.delete', $stagiaire) }}" 
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
        <label for="avatar" class="label-field">Avatar</label>
        @if ($stagiaire->avatar)
            <img src="{{ asset('storage/'.$stagiaire->avatar) }}" class="w-20 h-20 rounded-full object-cover mb-3">
        @endif
        <input type="file" name="avatar" id="avatar" accept="image/*" class="input-field">
    </div>
</div>
