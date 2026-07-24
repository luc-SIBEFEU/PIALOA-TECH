<div class="grid gap-5 max-w-2xl">
    <div>
        <label for="nom" class="label-field">Nom du service</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $service->nom) }}" class="input-field" required>
    </div>

    <div>
        <label for="description" class="label-field">Description</label>
        <textarea name="description" id="description" rows="5" class="input-field" required>{{ old('description', $service->description) }}</textarea>
    </div>

    <div>
        <label for="icone" class="label-field">Icône (nom libre, optionnel)</label>
        <input type="text" name="icone" id="icone" value="{{ old('icone', $service->icone) }}" placeholder="ex : globe, code, palette..." class="input-field">
    </div>
</div>
