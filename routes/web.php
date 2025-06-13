<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes d'inscription
Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');

// Routes d'inscription talent
Route::get('/register/talent', [RegistrationController::class, 'showTalentForm'])->name('register.talent.form');
Route::post('/register/talent', [RegistrationController::class, 'registerTalent'])->name('register.talent');

// Routes d'inscription entreprise
Route::get('/register/entreprise', [RegistrationController::class, 'showEntrepriseForm'])->name('register.entreprise.form');
Route::post('/register/entreprise', [RegistrationController::class, 'registerEntreprise'])->name('register.entreprise');

// API pour les familles de métiers
Route::get('/api/familles-metiers/{poleId}', [RegistrationController::class, 'getFamillesMetiers']);

// Route de succès d'inscription
Route::get('/registration/success', [RegistrationController::class, 'showRegistrationSuccess'])->name('registration.success');

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    // Talent dashboard
    Route::get('/talent/dashboard', function () {
        return view('talent.dashboard');
    })->name('talent.dashboard');
    
    // Entreprise dashboard
    Route::get('/entreprise/dashboard', function () {
        return view('entreprise.dashboard');
    })->name('entreprise.dashboard');
    
    // Legacy route for profile dashboard (redirect to talent)
    Route::get('/profile/dashboard', function () {
        return redirect()->route('talent.dashboard');
    })->name('profile.dashboard');
});

// Routes temporaires pour les sections de profil (à implémenter)
Route::get('/profile/experiences', function () {
    return redirect()->route('profile.dashboard')->with('info', 'Section expériences à implémenter');
})->name('profile.experiences');

Route::get('/profile/formations', function () {
    return redirect()->route('profile.dashboard')->with('info', 'Section formations à implémenter');
})->name('profile.formations');

Route::get('/profile/competences', function () {
    return redirect()->route('profile.dashboard')->with('info', 'Section compétences à implémenter');
})->name('profile.competences');

Route::get('/profile/langues', function () {
    return redirect()->route('profile.dashboard')->with('info', 'Section langues à implémenter');
})->name('profile.langues');

// Route pour la page d'accueil
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
