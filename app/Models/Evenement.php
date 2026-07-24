<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'periode_debut',
        'periode_fin',
        'image',
        'document',
    ];

    protected function casts(): array
    {
        return [
            'periode_debut' => 'date',
            'periode_fin' => 'date',
        ];
    }

    public function estAVenir(): bool
    {
        return $this->periode_debut?->isFuture() ?? false;
    }
}
