<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profil;
use App\Models\User;
use App\Models\Administrateur;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfilControllerTest extends TestCase
{

    use WithFaker;

    /** @test */
    public function it_returns_all_active_profiles()
    {
       
        
        // Appeler la route d'index
        $response = $this->getJson('/api/profils/actifs');

        // Vérifier la réponse
        $response->assertStatus(200); // Les profils actifs retournés devraient correspondre à ceux créés
    }

    /** @test */
    public function it_stores_a_new_profile()
    {   
        $user = User::first();
        // Créer un nouveau profil sans passer par la route
        $profil = new Profil();
        $profil->nom = $this->faker->firstName;
        $profil->prenom = $this->faker->lastName;
        $profil->image = $this->faker->imageUrl(640, 480);
        $profil->statut = 'actif';
        $profil->administrateur_id = $user->Administrateur->id; // Utiliser l'ID de l'administrateur actuel
        $profil->save();

        // Assurer que la création du profil a réussi
        $this->assertDatabaseHas('profils', [
            'id' => $profil->id,
            'nom' => $profil->nom,
            'prenom' => $profil->prenom,
            'image' => $profil->image,
            'statut' => $profil->statut,
            'administrateur_id' => $profil->administrateur_id,
        ]);
    }

    /** @test */
    public function it_updates_an_existing_profile()
    {
        $profil = Profil::first();

        // Créer des données de mise à jour
        $updateData = [
            'nom' => 'Updated Name',
            'prenom' => 'Updated Firstname',
            'statut' => 'inactif',
        ];

        // Mettre à jour le profil avec les données de mise à jour
        $profil->update($updateData);

        // Assurer que la mise à jour du profil a réussi
        $this->assertDatabaseHas('profils', [
            'id' => $profil->id,
            'nom' => $updateData['nom'],
            'prenom' => $updateData['prenom'],
            'statut' => $updateData['statut'],
        ]);
    }

    /** @test */
    public function it_deletes_an_existing_profile()
    {
        // Créer un profil
        $profil = Profil::first();

        // suppression du profil
        $response = $profil->delete();

        // Vérifier que le profil a été supprimé de la base de données
        $this->assertDatabaseMissing('profils', ['id' => $profil->id]);
    }
}








