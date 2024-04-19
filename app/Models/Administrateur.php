<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // Relation avec l'utilisateur (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec les profils
    public function profils()
    {
        return $this->hasMany(Profil::class);
    }

    // Relation avec les commentaires
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
    
}
