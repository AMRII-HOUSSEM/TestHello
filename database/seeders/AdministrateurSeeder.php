<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Administrateur;
use App\Models\User;

class AdministrateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créez un administrateur et un utilisateur pour chaque administrateur
        $users = User::factory()->count(1)->create();
        foreach ($users as $user) {
            Administrateur::create([
                'user_id' => $user->id,
            ]);
        }
    }
}
