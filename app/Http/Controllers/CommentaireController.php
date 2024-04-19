<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateCommentaireRequest;
use App\Models\Profil;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function store(CreateCommentaireRequest $request, Profil $profil)
    {   
        if ($profil->administrateur_id !== Auth::user()->Administrateur->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $validatedData = $request->validated();

        $commentaire = new Commentaire([
            'contenu' => $validatedData['contenu'],
            'administrateur_id' => Auth::user()->Administrateur->id
        ]);

        $profil->commentaires()->save($commentaire);

        return response()->json($commentaire, 201);
    }
}
