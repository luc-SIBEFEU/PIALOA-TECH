<div class="grid gap-5 max-w-2xl">
    <div>
        <label for="nom" class="label-field">Nom de l'événement</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $evenement->nom) }}" class="input-field" required>
    </div>

    <div>
        <label for="description" class="label-field">Description</label>
        <textarea name="description" id="description" rows="5" class="input-field" required>{{ old('description', $evenement->description) }}</textarea>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
        <div>
            <label for="periode_debut" class="label-field">Date de début</label>
            <input type="date" name="periode_debut" id="periode_debut"
                   value="{{ old('periode_debut', optional($evenement->periode_debut)->format('Y-m-d')) }}"
                   class="input-field" required>
        </div>
        <div>
            <label for="periode_fin" class="label-field">Date de fin (optionnel)</label>
            <input type="date" name="periode_fin" id="periode_fin"
                   value="{{ old('periode_fin', optional($evenement->periode_fin)->format('Y-m-d')) }}"
                   class="input-field">
        </div>
    </div>

    <div>
        <label for="image" class="label-field">Image</label>
        @if ($evenement->image)
            <img src="{{ asset('storage/'.$evenement->image) }}" class="w-24 h-24 rounded-lg object-cover mb-3">
        @endif
        <input type="file" name="image" id="image" accept="image/*" class="input-field">
    </div>

    <div>
        <label for="document" class="label-field">Document (PDF, DOC, DOCX)</label>
        @if ($evenement->document)
            <p class="text-sm mb-2"><a href="{{ asset('storage/'.$evenement->document) }}" target="_blank" class="text-ember font-semibold">Document actuel</a></p>
        @endif
        <input type="file" name="document" id="document" accept=".pdf,.doc,.docx" class="input-field">
    </div>
</div>
