<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrepriseController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/entreprise/familles-metiers/{pole}', [EntrepriseController::class, 'getFamillesMetiers'])->name('api.entreprise.familles-metiers');
Route::get('/entreprise/mes-offres', [EntrepriseController::class, 'getMesOffres'])->name('api.entreprise.mes-offres');
