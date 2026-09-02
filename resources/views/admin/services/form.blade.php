<link rel="stylesheet" href="{{ asset('bootstrap-icons/bootstrap-icons.min.css') }}">
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
        <label for="icone" class="label-field">Icône</label>
        <div class="flex items-center gap-4">
            <select name="icone" id="icone" class="input-field">
            @php
                $selectedIcon = old('icone', $service->icone ?? '');
            @endphp

            @foreach([
                'phone-fill' => 'Téléphone',
                'code' => 'Code',
                'megaphone-fill' => 'Marketing',
                'globe' => 'Web',
                'code-slash' => 'Développement',
                'code-square' => 'Projet',
                'palette-fill' => 'Design',
                'gear-fill' => 'Paramètres',
                'cloud-fill' => 'Cloud',
                'cpu-fill' => 'Processeur',
                'shield-fill' => 'Sécurité',
                'camera-video-fill' => 'Vidéo',
                'chat-dots-fill' => 'Chat',
                'file-earmark-code-fill' => 'Code',
            ] as $value => $label)
                <option value="{{ $value }}" {{ $selectedIcon === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
            </select>
    
        <!-- Aperçu de l'icône sélectionnée -->
        <div id="icone-preview" class="text-2xl">
            <i class="bi bi-{{ $selectedIcon }}"></i>
        </div>
        </div>
    </div>
</div>


<script>
document.getElementById('icone').addEventListener('change', function() {
    const iconName = this.value;
    document.getElementById('icone-preview').innerHTML = `<i class="bi bi-${iconName}"></i>`;
});
</script>
