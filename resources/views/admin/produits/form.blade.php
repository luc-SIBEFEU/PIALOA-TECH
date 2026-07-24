<div class="grid gap-5 max-w-2xl">
    <div>
        <label for="nom" class="label-field">Nom du produit</label>
        <input type="text" name="nom" id="nom" value="{{ old('nom', $produit->nom) }}" class="input-field" required>
    </div>

    <div>
        <label for="description" class="label-field">Description</label>
        <textarea name="description" id="description" rows="5" class="input-field" required>{{ old('description', $produit->description) }}</textarea>
    </div>

    <div>
        <label for="site_web" class="label-field">Site web</label>
        <input type="url" name="site_web" id="site_web" value="{{ old('site_web', $produit->site_web) }}" placeholder="https://..." class="input-field">
    </div>

    <div>
        <label for="image" class="label-field">Image</label>
        @if ($produit->image)
            <img src="{{ asset('storage/'.$produit->image) }}" class="w-24 h-24 rounded-lg object-cover mb-3">
        @endif
        <input type="file" name="image" id="image" accept="image/*" class="input-field">
    </div>
</div>
