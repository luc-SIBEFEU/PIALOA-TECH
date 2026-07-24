<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stagiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StagiaireController extends Controller
{
    public function index()
    {   
        $result = '';
        $stagiaires = Stagiaire::latest()->paginate(10);
        $ended = Stagiaire::where('statut','termine')->paginate(10);
        $pending = Stagiaire::where('statut', 'en_cours')->paginate(10);
        return view('admin.stagiaires.index', compact('stagiaires','result', 'pending', 'ended'));
    }

    public function create()
    {
        $stagiaire = new Stagiaire();

        return view('admin.stagiaires.create', compact('stagiaire'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        Stagiaire::create($data);

        return redirect()->route('admin.stagiaires.index')->with('success', 'Stagiaire ajouté avec succès.');
    }

    public function edit(Stagiaire $stagiaire)
    {
        return view('admin.stagiaires.edit', compact('stagiaire'));
    }

    public function search(Request $request)
    {   
        $result = $request->input('nom', '');
        $stagiaires = Stagiaire::where('nom', 'like', '%'.$result.'%')->paginate(10);
        $pending = Stagiaire::where('nom', 'like', '%'.$result.'%')->where('statut', 'en_cours')->paginate(10);
        $ended = Stagiaire::where('nom', 'like', '%'.$result.'%')->where('statut', 'termine')->paginate(10);
        return view('admin.stagiaires.index', compact('stagiaires', 'result', 'pending', 'ended'));
    }
    
    public function update(Request $request, Stagiaire $stagiaire)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:stagiaires,email,' . $stagiaire->id,
            'periode_debut' => 'required|date',
            'periode_fin' => 'nullable|date|after:periode_debut',
            'secteur' => 'required|string|max:255',
            'description' => 'required|string',
            'rapport' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240', // 10MB
            'avatar' => 'nullable|image|max:2048',
            'statut' => ['required', 'in:termine,en_cours'],
        ]);

        $data = $request->except(['rapport', 'avatar']);

        // Gérer le rapport
        if ($request->hasFile('rapport')) {
            // Supprimer l'ancien fichier
            if ($stagiaire->rapport && Storage::disk('public')->exists($stagiaire->rapport)) {
                Storage::disk('public')->delete($stagiaire->rapport);
            }
            
            $path = $request->file('rapport')->store('rapports', 'public');
            $data['rapport'] = $path;
        }

        // Gérer l'avatar
        if ($request->hasFile('avatar')) {
            if ($stagiaire->avatar && Storage::disk('public')->exists($stagiaire->avatar)) {
                Storage::disk('public')->delete($stagiaire->avatar);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $stagiaire->update($data);

        return redirect()->route('admin.stagiaires.index')
            ->with('success', 'Stagiaire mis à jour avec succès');
    }


    public function destroy(Stagiaire $stagiaire)
    {
        if ($stagiaire->avatar) {
            Storage::disk('public')->delete($stagiaire->avatar);
        }

        $stagiaire->delete();

        return redirect()->route('admin.stagiaires.index')->with('success', 'Stagiaire supprimé avec succès.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $passwordRule = $ignoreId ? ['nullable', 'string', 'min:6'] : ['required', 'string', 'min:6'];

        return $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                'unique:stagiaires,email' . ($ignoreId ? ",{$ignoreId}" : ''),
            ],
            'periode_debut' => ['required', 'date'],
            'periode_fin' => ['nullable', 'date', 'after_or_equal:periode_debut'],
            'secteur' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'rapport' => 'nullable|file|mimes:pdf,doc,docx,txt,xlsx,xls,ppt,pptx|max:10240', // 10M
            'avatar' => ['nullable', 'image', 'max:2048'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'email.required' => "L'adresse e-mail est obligatoire.",
            'email.email' => "L'adresse e-mail n'est pas valide.",
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'periode_debut.required' => 'La date de début est obligatoire.',
            'periode_fin.after_or_equal' => 'La date de fin doit être après la date de début.',
            'secteur.required' => 'Le secteur est obligatoire.',
            'avatar.image' => "Le fichier doit être une image.",
            'statut' => ['required', 'in:termine,en_cours'],
        ]);
    }

    // Afficher le document
    public function showDocument(Stagiaire $stagiaire)
    {
        if (!$stagiaire->hasRapport()) {
            abort(404, 'Document non trouvé');
        }

        $contenu = $stagiaire->getRapportContenu();
        $mimeType = $stagiaire->getRapportMimeType();
        $nomFichier = $stagiaire->getRapportNom();

        // Pour les PDF, images, etc. - affichage en ligne
        if (in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'])) {
            return response($contenu)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $nomFichier . '"');
        }

        // Pour les textes - affichage dans une vue
        if (str_starts_with($mimeType, 'text/')) {
            return view('admin.stagiaires.document', [
                'stagiaire' => $stagiaire,
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
    public function downloadDocument(Stagiaire $stagiaire)
    {
        if (!$stagiaire->hasRapport()) {
            abort(404, 'Document non trouvé');
        }

        $contenu = $stagiaire->getRapportContenu();
        $mimeType = $stagiaire->getRapportMimeType();
        $nomFichier = $stagiaire->getRapportNom();

        return response($contenu)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $nomFichier . '"');
    }
    // Supprimer le document
    public function deleteDocument(Stagiaire $stagiaire)
    {
        if ($stagiaire->rapport && Storage::disk('public')->exists($stagiaire->rapport)) {
            Storage::disk('public')->delete($stagiaire->rapport);
            $stagiaire->update(['rapport' => null]);
        }

        return redirect()->back()->with('success', 'Document supprimé avec succès');
    }
}
