<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EntrepriseController;

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
    Route::get('/entreprise/dashboard', [EntrepriseController::class, 'dashboard'])->name('entreprise.dashboard');
    Route::get('/entreprise/dashboard/data', [EntrepriseController::class, 'getDashboardData'])->name('entreprise.dashboard.data');
    Route::get('/entreprise/dashboard/export', [EntrepriseController::class, 'exportDashboard'])->name('entreprise.dashboard.export');
    
    // WF-E02: Publication Offre d'Emploi
    Route::prefix('entreprise/offres')->name('entreprise.offres.')->group(function () {
        Route::get('/', [EntrepriseController::class, 'indexOffres'])->name('index');
        Route::get('/create', function () {
            return redirect()->route('entreprise.offres.publier.step1');
        })->name('create');
        Route::get('/{offre}/edit', [EntrepriseController::class, 'showPublishJobStep1'])->name('edit');
        Route::get('/publier/etape1', [EntrepriseController::class, 'showPublishJobStep1'])->name('publier.step1');
        Route::post('/publier/etape1', [EntrepriseController::class, 'saveJobStep1'])->name('save.step1');
        Route::get('/publier/etape2/{offre}', [EntrepriseController::class, 'showPublishJobStep2'])->name('publier.step2');
        Route::post('/publier/etape2/{offre}', [EntrepriseController::class, 'saveJobStep2'])->name('save.step2');
        Route::get('/publier/etape3/{offre}', [EntrepriseController::class, 'showPublishJobStep3'])->name('publier.step3');
        Route::post('/publier/{offre}', [EntrepriseController::class, 'publishJob'])->name('publish');
    });
    
    // WF-E03: Recherche de Talents
    Route::prefix('entreprise/talents')->name('entreprise.talents.')->group(function () {
        Route::get('/recherche', [EntrepriseController::class, 'showTalentSearch'])->name('search');
        Route::post('/recherche', [EntrepriseController::class, 'searchTalents'])->name('search.post');
        Route::post('/lier-offre', [EntrepriseController::class, 'linkTalentToOffer'])->name('link');
    });
    
    // Route pour la recherche de talents (alias)
    Route::get('/entreprise/talent-search', [EntrepriseController::class, 'showTalentSearch'])->name('entreprise.talent-search');
    
    // WF-E04: Suivi Candidatures KANBAN
    Route::prefix('entreprise/candidatures')->name('entreprise.candidatures.')->group(function () {
        Route::get('/kanban', [EntrepriseController::class, 'showKanban'])->name('kanban');
        Route::get('/data', [EntrepriseController::class, 'getCandidaturesData'])->name('data');
        Route::get('/details/{id}', [EntrepriseController::class, 'getCandidatureDetails'])->name('details');
        Route::post('/update-status', [EntrepriseController::class, 'updateCandidatureStatus'])->name('update.status');
    });
    
    // WF-E06: Badges Entreprise
    Route::prefix('entreprise/badges')->name('entreprise.badges.')->group(function () {
        Route::get('/', [EntrepriseController::class, 'showBadges'])->name('index');
        Route::get('/check-new', [EntrepriseController::class, 'checkNewBadges'])->name('check-new');
    });
    
    // Route pour les badges (alias)
    Route::get('/entreprise/badges-alias', [EntrepriseController::class, 'showBadges'])->name('entreprise.badges');
    
    // WF-E07: Parrainage Entreprise
    Route::prefix('entreprise/parrainage')->name('entreprise.parrainage.')->group(function () {
        Route::get('/', [EntrepriseController::class, 'showReferral'])->name('index');
        Route::post('/envoyer', [EntrepriseController::class, 'sendReferral'])->name('send');
        Route::post('/invite', [EntrepriseController::class, 'sendInvitation'])->name('invite');
        Route::post('/resend/{id}', [EntrepriseController::class, 'renvoyerInvitation'])->name('resend');
        Route::get('/details/{id}', [EntrepriseController::class, 'detailsParrainage'])->name('details');
    });
    
    // Route pour le parrainage (alias)
    Route::get('/entreprise/parrainage-alias', [EntrepriseController::class, 'showReferral'])->name('entreprise.parrainage');
    
    // WF-E08: Profil Entreprise
    Route::prefix('entreprise/profile')->name('entreprise.profile.')->group(function () {
        Route::get('/', [EntrepriseController::class, 'showProfile'])->name('index');
        Route::put('/update', [EntrepriseController::class, 'updateProfile'])->name('update');
        Route::put('/notifications', [EntrepriseController::class, 'updateNotifications'])->name('notifications');
    });
    
    // API Routes pour entreprise
    Route::get('/api/entreprise/familles-metiers/{pole}', [EntrepriseController::class, 'getFamillesMetiers']);
    Route::get('/api/entreprise/mes-offres', [EntrepriseController::class, 'getMesOffres']);
    
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
