<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Stagiaires extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'periode_debut',
        'periode_fin',
        'secteur',
        'description',
        'rapport',
        'avatar',
        'statut',
    ];

    protected $casts = [
        'periode_debut' => 'date',
        'periode_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // Relation avec les tâches
    public function taches()
    {
        return $this->hasMany(Tache::class, 'stagiaire_id');
    }

    // Méthode pour vérifier si le stagiaire a des tâches
    public function hasTaches()
    {
        return $this->taches()->count() > 0;
    }

    // Méthode pour obtenir les tâches complétées
    public function getTachesCompletees()
    {
        return $this->taches()->where('statut', 'completed')->get();
    }

    // Méthode pour obtenir les tâches en cours
    public function getTachesEnCours()
    {
        return $this->taches()->where('statut', 'in_progress')->get();
    }

    // Méthode pour obtenir les tâches en attente
    public function getTachesEnAttente()
    {
        return $this->taches()->where('statut', 'pending')->get();
    }



    public function hasRapport()
    {
        return $this->rapport && Storage::disk('public')->exists($this->rapport);
    }

    // Obtenir le contenu du rapport
    public function getRapportContenu()
    {
        if ($this->hasRapport()) {
            return Storage::disk('public')->get($this->rapport);
        }
        return null;
    }

    // Obtenir le type MIME du rapport
    public function getRapportMimeType()
    {
        if ($this->hasRapport()) {
            return Storage::disk('public')->mimeType($this->rapport);
        }
        return null;
    }

    // Obtenir le nom du fichier
    public function getRapportNom()
    {
        if ($this->rapport) {
            return basename($this->rapport);
        }
        return null;
    }

    // Obtenir la taille du fichier
    public function getRapportTaille()
    {
        if ($this->hasRapport()) {
            return Storage::disk('public')->size($this->rapport);
        }
        return null;
    }
}
