<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CommentaireController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Endpoint pour l'authentification (utilisation de Laravel Sanctum)
Route::post('/login', [AuthController::class, 'login']); // Exemple de route pour la connexion

// Routes pour les endpoints de gestion des profils
Route::middleware('auth:sanctum')->group(function () {
    // Création de profil 
    Route::post('/profil', [ProfilController::class, 'store']);

    // Ajout de commentaire 
    Route::post('/profil/{profil}/commentaire', [CommentaireController::class, 'store']);

    // Modification de profil 
    Route::put('/profil/{profil}', [ProfilController::class, 'update']);

    // Suppression de profil 
    Route::delete('/profil/{profil}', [ProfilController::class, 'destroy']);

});

// Liste des profils actifs 
Route::get('/profils/actifs', [ProfilController::class, 'index']); // Exemple de route pour obtenir la liste des profils actifs