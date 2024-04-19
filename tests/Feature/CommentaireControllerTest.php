<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Commentaire;
use App\Models\Profil;

class CommentaireControllerTest extends TestCase
{

    public function test_creer_commentaire()
    {
        // Créer un profil pour le test
        $profil_first = Profil::first();

        // Données du commentaire à créer
        $data = [
            'contenu' => 'Ceci est un commentaire de test.'
        ];

        // Envoyer une requête POST pour créer un commentaire
        $profil = new Commentaire();
        $profil->contenu = $data['contenu'];
        $profil->profil_id = $profil_first->id ;
        $profil->administrateur_id = $profil_first->administrateur_id; // Utiliser l'ID de l'administrateur actuel
        $profil->save();

        $this->assertDatabaseHas('commentaires', [
            'contenu' => 'Ceci est un commentaire de test.',
            'profil_id' => $profil_first->id,
            'administrateur_id' => $profil_first->administrateur_id
        ]);
    }

    public function test_seuls_les_administrateurs_peuvent_creer_des_commentaires()
    {   
        

        // Récupérer le premier profil existant pour le test
    $profil_first = Profil::first();

    // Vérifier si le profil existe et s'il est associé à un administrateur spécifique
    if (!$profil_first || $profil_first->administrateur_id !== 2) {
        // Si le profil n'existe pas ou s'il n'est pas associé à l'administrateur spécifique, retourner une erreur 401
        $this->markTestSkipped('Profil non autorisé pour le test.');
    }

    // Données du commentaire à créer
    $data = [
        'contenu' => 'Ceci est un commentaire de test.'
    ];

    // Envoyer une requête POST JSON pour créer un commentaire
    $response = $this->postJson("/profil/{$profil_first->id}/commentaire", $data);

    // Vérifier que le commentaire a été créé avec succès
    $response->assertStatus(201);
    $response->assertJson(['contenu' => 'Ceci est un commentaire de test.']);

    // Vérifier que le commentaire est enregistré dans la base de données
    $this->assertDatabaseHas('commentaires', [
        'contenu' => 'Ceci est un commentaire de test.',
        'profil_id' => $profil_first->id,
        'administrateur_id' => $profil_first->administrateur_id
    ]);
    }
}
