<?php

namespace App\Http\Controllers;

use App\Models\Stagiaires;
use App\Models\Tache;
use Illuminate\Http\Request;

class StagiairesController extends Controller
{
    public function index()
    {
        $stagiaires = Stagiaires::all();

        return view('stagiaires.index', compact('stagiaires'));
    }
    public function show(Stagiaires $stagiaire)
    {
        // Charger les tâches avec le stagiaire
        $stagiaire->load('taches');
        
        // Statistiques des tâches
        $totalTaches = $stagiaire->taches->count();
        $tachesCompletees = $stagiaire->taches->where('statut', 'completed')->count();
        $tachesEnCours = $stagiaire->taches->where('statut', 'in_progress')->count();
        $tachesEnAttente = $stagiaire->taches->where('statut', 'pending')->count();
        
        // Trier les tâches par date (les plus récentes d'abord)
        $taches = $stagiaire->taches->sortByDesc('date_debut');

        return view('stagiaires.show', compact(
            'stagiaire', 
            'taches', 
            'totalTaches', 
            'tachesCompletees', 
            'tachesEnCours', 
            'tachesEnAttente'
        ));
    }
    // Afficher le document
    public function showDocument(Stagiaires $stagiaire)
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
    public function downloadDocument(Stagiaires $stagiaire)
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
    public function deleteDocument(Stagiaires $stagiaire)
    {
        if ($stagiaire->rapport && Storage::disk('public')->exists($stagiaire->rapport)) {
            Storage::disk('public')->delete($stagiaire->rapport);
            $stagiaire->update(['rapport' => null]);
        }

        return redirect()->back()->with('success', 'Document supprimé avec succès');
    }

}
