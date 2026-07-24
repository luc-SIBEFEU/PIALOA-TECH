<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Stagiaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
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

    protected $hidden = [
        'password',
    ];

public function taches() {
    return $this->hasMany(Tache::class);
}

    protected function casts(): array
    {
        return [
            'periode_debut' => 'date',
            'periode_fin' => 'date',
        ];
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
