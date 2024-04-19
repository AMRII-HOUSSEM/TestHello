<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminIds = \App\Models\Administrateur::pluck('id')->toArray(); 

        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'image' => $this->faker->imageUrl(),
            'statut' => $this->faker->randomElement(['inactif', 'en attente', 'actif']),
            'administrateur_id' => $this->faker->randomElement($adminIds)
        ];
    }
}
