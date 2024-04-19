<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profil;
use App\Models\Administrateur;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminIds = Administrateur::pluck('id')->toArray(); 
        $profilIds = Profil::pluck('id')->toArray(); 

        return [
            'contenu' => $this->faker->paragraph,
            'administrateur_id' => $this->faker->randomElement($adminIds),
            'profil_id' => $this->faker->randomElement($profilIds)
        ];
    }
}
