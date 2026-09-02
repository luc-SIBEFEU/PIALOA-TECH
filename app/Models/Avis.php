<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'id',
        'nom',
        'email',
        'message',
        'statut',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function getDateCreationFormateeAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y à H:i') : 'Date non disponible';
    }

    // ✅ Accesseur pour la date courte
    public function getDateCourteAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y') : 'N/A';
    }

    // ✅ Accesseur pour le statut avec badge CSS
    public function getStatutBadgeAttribute()
    {
        $badges = [
            'approuvé' => 'bg-green-100 text-green-700',
            'en attente' => 'bg-yellow-100 text-yellow-700',
            'rejeté' => 'bg-red-100 text-red-700',
        ];

        return $badges[$this->statut] ?? 'bg-gray-100 text-gray-700';
    }

    // ✅ Accesseur pour le statut avec icône
    public function getStatutLibelleAttribute()
    {
        $libelles = [
            'approuvé' => '✅ Approuvé',
            'en attente' => '⏳ En attente',
            'rejeté' => '❌ Rejeté',
        ];

        return $libelles[$this->statut] ?? $this->statut;
    }

    // ✅ Accesseur pour le statut en couleur (texte)
    public function getStatutCouleurAttribute()
    {
        $couleurs = [
            'approuvé' => 'text-green-600',
            'en attente' => 'text-yellow-600',
            'rejeté' => 'text-red-600',
        ];

        return $couleurs[$this->statut] ?? 'text-gray-600';
    }

    // ✅ Méthode pour vérifier si l'avis est en attente
    public function isEnAttente()
    {
        return $this->statut === 'en attente';
    }

    // ✅ Méthode pour vérifier si l'avis est approuvé
    public function isApprouve()
    {
        return $this->statut === 'approuvé';
    }

    // ✅ Méthode pour vérifier si l'avis est rejeté
    public function isRejete()
    {
        return $this->statut === 'rejeté';
    }
}
