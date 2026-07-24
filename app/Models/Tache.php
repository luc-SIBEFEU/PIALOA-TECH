<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tache extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'statut',
        'rapport',
        'stagiaire_id'
    ];

protected $casts = [
    'date_debut' => 'date',
    'date_fin' => 'date',
];
 public function stagiaire()
    {
        return $this->belongsTo(Stagiaire::class, 'stagiaire_id');
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
