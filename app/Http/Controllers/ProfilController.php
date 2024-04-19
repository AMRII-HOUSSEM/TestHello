<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateProfilRequest;
use App\Http\Requests\UpdateProfilRequest;
use App\Models\Profil;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{   
    public function index() {
        // Récupérer tous les profils avec le statut "actif"
        $profils = Profil::where('statut', 'actif')->get();

        // Retourner la liste des profils avec le code de statut 200 (OK)
        return response()->json($profils, 200);
    }

    public function store(CreateProfilRequest $request) {
        // Valider les données à nouveau même si cela a déjà été fait par le FormRequest
        $validatedData = $request->validated();

        // Créer un nouveau profil avec les données validées
        $profil = new Profil();
        $profil->nom = $validatedData['nom'];
        $profil->prenom = $validatedData['prenom'];
        $profil->image = $validatedData['image']->store('images'); // Sauvegarder l'image dans le dossier 'images'
        $profil->statut = $validatedData['statut'];
        $profil->administrateur_id = Auth::user()->Administrateur->id; // Utilisateur authentifié qui crée le profil
        $profil->save();

        // Retourner une réponse avec le profil créé et le code de statut 201 (Créé avec succès)
        return response()->json($profil, 201);
    }

    public function update(UpdateProfilRequest $request, Profil $profil) {
        // Valider les données à nouveau même si cela a déjà été fait par le FormRequest
        $validatedData = $request->validated();

        // Vérifier si l'utilisateur authentifié est autorisé à modifier ce profil
        if ($profil->administrateur_id !== Auth::user()->Administrateur->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Mettre à jour les champs du profil avec les données validées
        $updateData = [
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'statut' => $validatedData['statut'],
            'administrateur_id' => Auth::user()->Administrateur->id // Utilisateur authentifié 
        ];

        // Vérifier si une image a été incluse dans les données validées
        if (isset($validatedData['image'])) {
            // Sauvegarder l'image dans le dossier 'images' et récupérer le chemin
            $imagePath = $validatedData['image']->store('images');

            // Ajouter le chemin de l'image à mettre à jour dans les données
            $updateData['image'] = $imagePath;
        }

        // Mettre à jour le profil avec les données mises à jour
        $profil->update($updateData);

        // Retourner une réponse avec le profil mis à jour et le code de statut 200 (OK)
        return response()->json($profil, 200);
    }

    public function destroy(Profil $profil)
    {
        // Vérifier si l'utilisateur authentifié est autorisé à supprimer ce profil
        if ($profil->administrateur_id !== Auth::user()->Administrateur->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $profil->delete();
        return response()->json(null, 204);
    }
}
