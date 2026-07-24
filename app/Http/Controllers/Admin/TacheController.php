<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::latest()->paginate(10);

        return view('admin.taches.index', compact('taches'));
    }

    public function create()
    {
        $tache = new Tache();

        $stagiaires = Stagiaire::orderBy('nom')->pluck('nom', 'id');
    return view('admin.taches.create', compact('tache', 'stagiaires'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Tache::create($data);

        return redirect()->route('admin.taches.index')->with('success', 'Tâche ajoutée avec succès.');
    }

    public function edit(Tache $tache)
{
    // On récupère les stagiaires pour le select du formulaire
    $stagiaires = Stagiaire::orderBy('nom')->pluck('nom', 'id');
    
    // On passe bien les deux variables à la vue
    return view('admin.taches.edit', compact('tache', 'stagiaires'));
}

    // public function update(Request $request, Tache $tache)
    // {
    //     $data = $this->validateData($request, $tache->id);

    //     $tache->update($data);

    //     return redirect()->route('admin.taches.index')->with('success', 'Tâche modifiée avec succès.');
    // }

    public function destroy(Tache $tache)
    {
        $tache->delete();

        return redirect()->route('admin.taches.index')->with('success', 'Tâche supprimée avec succès.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
{
    return $request->validate([
        'nom' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        'date_debut' => ['required', 'date'],
        'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
        'statut' => ['required', 'in:pending,in_progress,completed'],
        'rapport' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240', // 10MB
        'stagiaire_id' => ['required', 'exists:stagiaires,id'], // <-- AJOUT IMPORTANT
    ], [
        'nom.required' => 'Le nom est obligatoire.',
        'date_debut.required' => 'La date de début est obligatoire.',
        'date_fin.after_or_equal' => 'La date de fin doit être après la date de début.',
        'status.required' => "Le statut est obligatoire.",
        'stagiaire_id.required' => "Veuillez sélectionner un stagiaire.",
        'stagiaire_id.exists' => "Le stagiaire sélectionné n'existe pas.",
    ]);
}
    public function view($stagiaireId)
{
    $stagiaire = Stagiaire::findOrFail($stagiaireId);
    $taches = $stagiaire->taches;

    return view('admin.stagiaires.taches', compact('stagiaire', 'taches'));
}
public function showDocument(Tache $tache)
    {
        if (!$tache->hasRapport()) {
            abort(404, 'Document non trouvé');
        }

        $contenu = $tache->getRapportContenu();
        $mimeType = $tache->getRapportMimeType();
        $nomFichier = $tache->getRapportNom();

        // Pour les PDF, images, etc. - affichage en ligne
        if (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'])) {
            return response($contenu)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $nomFichier . '"');
        }

        // Pour les textes - affichage dans une vue
        if (str_starts_with($mimeType, 'text/')) {
            return view('admin.stagiaires.document', [
                'Tache' => $tache,
                'contenu' => $contenu,
                'mimeType' => $mimeType,
                'nomFichier' => $nomFichier
            ]);
        }

        // Autres types - téléchargement
        return response($contenu)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $nomFichier . '"');
    }

    // Télécharger le document
    public function downloadDocument(Tache $tache)
    {
        if (!$tache->hasRapport()) {
            abort(404, 'Document non trouvé');
        }

        $contenu = $tache->getRapportContenu();
        $mimeType = $tache->getRapportMimeType();
        $nomFichier = $tache->getRapportNom();

        return response($contenu)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $nomFichier . '"');
    }

    // Upload du document dans le formulaire d'édition
    public function update(Request $request, Tache $tache)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date|after:periode_debut',
            'rapport' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240', // 10MB
        ]);

        $data = $request->except(['rapport']);

        // Gérer le rapport
        if ($request->hasFile('rapport')) {
            // Supprimer l'ancien fichier
            if ($tache->rapport && Storage::disk('public')->exists($tache->rapport)) {
                Storage::disk('public')->delete($tache->rapport);
            }
            
            $path = $request->file('rapport')->store('rapports', 'public');
            $data['rapport'] = $path;
        }

        $tache->update($data);

        return redirect()->route('admin.taches.index')
            ->with('success', 'Tache mis à jour avec succès');
    }

    // Supprimer le document
    public function deleteDocument(Tache $tache)
    {
        if ($tache->rapport && Storage::disk('public')->exists($tache->rapport)) {
            Storage::disk('public')->delete($tache->rapport);
            $tache->update(['rapport' => null]);
        }

        return redirect()->back()->with('success', 'Document supprimé avec succès');
    }
}