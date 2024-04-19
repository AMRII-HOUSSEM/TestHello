<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu', 'administrateur_id', 'profil_id'
    ];

    // Relation avec l'administrateur
    public function administrateur()
    {
        return $this->belongsTo(Administrateur::class);
    }

    // Relation avec le profil
    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

}
