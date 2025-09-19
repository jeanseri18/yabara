<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Talent;
use App\Models\Entreprise;
use App\Models\OffreEmploi;
use App\Models\Candidature;
use App\Models\Pole;
use App\Models\TypeContrat;
use App\Models\NiveauDiplome;
use App\Models\FamilleMetier;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $periode = $request->get('periode', 'mois');
        
        // Statistiques globales
        $stats = $this->getGlobalStats();
        
        // Données pour les graphiques
        $evolutionData = $this->getEvolutionData($periode);
        $repartitionData = $this->getRepartitionData();
        $alertes = $this->getAlertes();
        $insights = $this->getInsights();
        
        return view('admin.dashboard', compact(
            'stats', 
            'evolutionData', 
            'repartitionData', 
            'alertes', 
            'insights',
            'periode'
        ));
    }
    
    private function getGlobalStats()
    {
        $totalOffres = OffreEmploi::count();
        $offresAvecCandidatures = OffreEmploi::has('candidatures')->count();
        $totalCandidatures = Candidature::count();
        $candidaturesAcceptees = Candidature::where('statut_entreprise', 'retenue')->count();
        
        return [
            'talents_inscrits' => Talent::count(),
            'entreprises_actives' => Entreprise::whereHas('offresEmploi')->count(),
            'offres_publiees' => OffreEmploi::count(),
            'candidatures_deposees' => Candidature::count(),
            'recrutements_realises' => $candidaturesAcceptees,
            'taux_transformation' => $totalOffres > 0 ? round(($candidaturesAcceptees / $totalOffres) * 100, 1) : 0,
            'delai_moyen_recrutement' => $this->getDelaiMoyenRecrutement(),
            'entretiens_total' => Candidature::where('statut_entreprise', 'entretien')->count(),
            'coordonnees_partagees' => Candidature::whereIn('statut_entreprise', ['entretien', 'retenue'])->count(),
            'taux_offres_zero_candidature' => $totalOffres > 0 ? round((($totalOffres - $offresAvecCandidatures) / $totalOffres) * 100, 1) : 0,
            'utilisateurs_semaine' => User::where('last_login_at', '>=', Carbon::now()->subWeek())->count(),
            'utilisateurs_mois' => User::where('last_login_at', '>=', Carbon::now()->subMonth())->count()
        ];
    }
    
    private function getDelaiMoyenRecrutement()
    {
        $recrutementsAvecDelai = DB::table('candidatures')
            ->join('offres_emploi', 'candidatures.offre_emploi_id', '=', 'offres_emploi.id')
            ->where('candidatures.statut_entreprise', 'retenue')
            ->whereNotNull('offres_emploi.created_at')
            ->whereNotNull('candidatures.updated_at')
            ->select(
                DB::raw('DATEDIFF(candidatures.updated_at, offres_emploi.created_at) as delai_jours')
            )
            ->get();
            
        if ($recrutementsAvecDelai->count() > 0) {
            return round($recrutementsAvecDelai->avg('delai_jours'), 0);
        }
        
        return 0;
    }
    
    private function getEvolutionData($periode)
    {
        // Données d'évolution des candidatures sur les 7 derniers jours
        $candidatures = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateKey = $date->format('d/m');
            $candidatures[$dateKey] = Candidature::whereDate('created_at', $date)->count();
        }
        
        return [
            'candidatures' => $candidatures
        ];
    }
    
    private function getRepartitionData()
    {
        // Répartition par pôles métiers (basée sur les offres d'emploi)
        $repartitionPoles = DB::table('offres_emploi')
            ->join('familles_metiers', 'offres_emploi.famille_metier_id', '=', 'familles_metiers.id')
            ->join('poles', 'familles_metiers.pole_id', '=', 'poles.id')
            ->select('poles.nom', DB::raw('count(*) as count'))
            ->groupBy('poles.id', 'poles.nom')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();
            
        // Répartition par types de contrats
        $repartitionContrats = DB::table('offres_emploi')
            ->join('types_contrats', 'offres_emploi.type_contrat_id', '=', 'types_contrats.id')
            ->select('types_contrats.nom', DB::raw('count(*) as count'))
            ->groupBy('types_contrats.id', 'types_contrats.nom')
            ->orderBy('count', 'desc')
            ->get();
            
        return [
            'poles' => $repartitionPoles,
            'contrats' => $repartitionContrats
        ];
    }
    
    private function getAlertes()
    {
        $alertes = [];
        
        // Offres sans candidatures depuis 7 jours
        $offresSansCandidatures = OffreEmploi::whereDoesntHave('candidatures')
            ->where('created_at', '<=', Carbon::now()->subDays(7))
            ->where('statut', 'active')
            ->count();
            
        if ($offresSansCandidatures > 0) {
            $alertes[] = [
                'message' => $offresSansCandidatures . ' offres sans candidatures depuis 7 jours',
                'action' => 'Vérifier la visibilité des offres'
            ];
        }
        
        // Talents en entretien
        $talentsEntretien = Candidature::where('statut_entreprise', 'entretien')->count();
        if ($talentsEntretien > 0) {
            $alertes[] = [
                'message' => $talentsEntretien . ' talents en entretien sans coordonnées partagées',
                'action' => 'Faciliter les échanges'
            ];
        }
        
        // Profils en attente (talents récents avec profils incomplets)
        $profilsAttente = Talent::where('created_at', '>=', Carbon::now()->subDays(30))
            ->where('profile_completion_percentage', '<', 100)
            ->count();
            
        if ($profilsAttente > 0) {
            $alertes[] = [
                'message' => $profilsAttente . ' profils en attente d\'étude YABARA',
                'action' => 'Valider les profils en attente'
            ];
        }
        
        return $alertes;
    }
    
    private function getInsights()
    {
        $insights = [];
        
        // Entreprises avec offres anciennes sans activité
        $entreprisesInactives = DB::table('offres_emploi')
            ->join('entreprises', 'offres_emploi.entreprise_id', '=', 'entreprises.id')
            ->leftJoin('candidatures', 'offres_emploi.id', '=', 'candidatures.offre_emploi_id')
            ->where('offres_emploi.created_at', '<=', Carbon::now()->subDays(14))
            ->whereNull('candidatures.id')
            ->where('offres_emploi.statut', 'active')
            ->select('entreprises.nom_entreprise', 'offres_emploi.id')
            ->limit(3)
            ->get();
            
        foreach ($entreprisesInactives as $entreprise) {
            $insights[] = [
                'message' => 'Relancer ' . $entreprise->nom_entreprise . ' pour l\'offre #' . $entreprise->id,
                'action' => 'Contacter l\'entreprise'
            ];
        }
        
        // Candidatures en attente de réponse
        $candidaturesAttente = Candidature::where('statut_entreprise', 'en_attente')
            ->where('created_at', '<=', Carbon::now()->subDays(7))
            ->count();
            
        if ($candidaturesAttente > 0) {
            $insights[] = [
                'message' => $candidaturesAttente . ' candidatures en attente de réponse depuis plus de 7 jours',
                'action' => 'Relancer les entreprises'
            ];
        }
        
        // Talents avec profils incomplets
        $talentsIncomplets = Talent::where('profile_completion_percentage', '<', 100)
            ->orWhereNull('phone')
            ->count();
            
        if ($talentsIncomplets > 0) {
            $insights[] = [
                'message' => $talentsIncomplets . ' talents avec profils incomplets',
                'action' => 'Encourager la finalisation des profils'
            ];
        }
        
        return $insights;
    }
    
    public function exportData(Request $request)
    {
        $periode = $request->get('periode', 'mois');
        $format = $request->get('format', 'pdf');
        
        $stats = $this->getGlobalStats();
        $evolutionData = $this->getEvolutionData($periode);
        
        if ($format === 'excel') {
            // Logique d'export Excel
            return response()->json(['message' => 'Export Excel en cours de développement']);
        } else {
            // Logique d'export PDF
            return response()->json(['message' => 'Export PDF en cours de développement']);
        }
    }
    
    public function listAdmins()
    {
        $admins = User::where('user_type', 'admin')
                     ->orderBy('created_at', 'desc')
                     ->paginate(15);
        
        return view('admin.users.admins', compact('admins'));
    }
    
    public function listEntreprises()
    {
        $entreprises = User::where('user_type', 'entreprise')
                          ->with('entreprise')
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);
        
        return view('admin.users.entreprises', compact('entreprises'));
    }
    
    public function listTalents(Request $request)
    {
        $query = User::where('user_type', 'talent')
                    ->with(['talent.pole', 'talent.familleMetier', 'talent.niveauDiplome'])
                    ->whereHas('talent');
        
        // Filtrer par pôle
        if ($request->filled('pole') && $request->pole !== '') {
            $query->whereHas('talent', function($q) use ($request) {
                $q->where('pole_id', $request->pole);
            });
        }
        
        // Filtrer par famille de métier
        if ($request->filled('famille') && $request->famille !== '') {
            $query->whereHas('talent', function($q) use ($request) {
                $q->where('famille_metier_id', $request->famille);
            });
        }
        
        // Filtrer par expérience
        if ($request->filled('experience') && $request->experience !== '') {
            $experienceMin = (int) $request->experience;
            
            if ($experienceMin === 0) {
                // 0-2 ans d'expérience
                $query->whereHas('talent.experiencesProfessionnelles', function($q) {
                    $q->selectRaw('talent_id, SUM(TIMESTAMPDIFF(YEAR, date_debut, COALESCE(date_fin, NOW()))) as total_experience')
                      ->groupBy('talent_id')
                      ->havingRaw('total_experience <= 2');
                });
            } else {
                // Expérience minimale requise
                $query->whereHas('talent.experiencesProfessionnelles', function($q) use ($experienceMin) {
                    $q->selectRaw('talent_id, SUM(TIMESTAMPDIFF(YEAR, date_debut, COALESCE(date_fin, NOW()))) as total_experience')
                      ->groupBy('talent_id')
                      ->havingRaw('total_experience >= ?', [$experienceMin]);
                });
            }
        }
        
        // Filtrer par diplôme
        if ($request->filled('diplome') && $request->diplome !== '') {
            $query->whereHas('talent', function($q) use ($request) {
                $q->where('niveau_diplome_id', $request->diplome);
            });
        }
        
        $talents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Récupérer les données pour les filtres
        $poles = \App\Models\Pole::orderBy('ordre_affichage')->get();
        $famillesMetiers = \App\Models\FamilleMetier::orderBy('ordre_affichage')->get();
        $niveauxDiplomes = \App\Models\NiveauDiplome::where('is_active', true)->orderBy('niveau')->get();
        
        return view('admin.users.talents', compact('talents', 'poles', 'famillesMetiers', 'niveauxDiplomes'));
    }
    
    public function createAdmin()
    {
        return view('admin.users.create-admin');
    }
    
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        
        return redirect()->route('admin.users.admins')->with('success', 'Administrateur créé avec succès.');
    }
    
    public function editAdmin($id)
    {
        $admin = User::where('user_type', 'admin')->findOrFail($id);
        return view('admin.users.edit-admin', compact('admin'));
    }
    
    public function updateAdmin(Request $request, $id)
    {
        $admin = User::where('user_type', 'admin')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        if ($request->filled('password')) {
            $admin->update(['password' => Hash::make($request->password)]);
        }
        
        return redirect()->route('admin.users.admins')->with('success', 'Administrateur modifié avec succès.');
    }
    
    public function deleteAdmin($id)
    {
        $admin = User::where('user_type', 'admin')->findOrFail($id);
        $admin->delete();
        
        return redirect()->route('admin.users.admins')->with('success', 'Administrateur supprimé avec succès.');
    }
    
    public function createEntreprise()
    {
        return view('admin.users.create-entreprise');
    }
    
    public function storeEntreprise(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nom_entreprise' => 'required|string|max:255',
            'secteur' => 'nullable|string|max:255',
            'effectif' => 'nullable|string|max:50',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'entreprise',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        
        Entreprise::create([
            'user_id' => $user->id,
            'nom_entreprise' => $request->nom_entreprise,
            'secteur' => $request->secteur,
            'effectif' => $request->effectif,
            'responsable_rh_nom' => $request->name,
            'responsable_rh_email' => $request->email,
        ]);
        
        return redirect()->route('admin.users.entreprises')->with('success', 'Entreprise créée avec succès.');
    }
    
    public function editEntreprise($id)
    {
        $user = User::where('user_type', 'entreprise')->with('entreprise')->findOrFail($id);
        return view('admin.users.edit-entreprise', compact('user'));
    }
    
    public function updateEntreprise(Request $request, $id)
    {
        $user = User::where('user_type', 'entreprise')->with('entreprise')->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'nom_entreprise' => 'required|string|max:255',
            'secteur' => 'nullable|string|max:255',
            'effectif' => 'nullable|string|max:50',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        
        if ($user->entreprise) {
            $user->entreprise->update([
                'nom_entreprise' => $request->nom_entreprise,
                'secteur' => $request->secteur,
                'effectif' => $request->effectif,
                'responsable_rh_nom' => $request->name,
                'responsable_rh_email' => $request->email,
            ]);
        }
        
        return redirect()->route('admin.users.entreprises')->with('success', 'Entreprise modifiée avec succès.');
    }
    
    public function deleteEntreprise($id)
    {
        $user = User::where('user_type', 'entreprise')->with('entreprise')->findOrFail($id);
        
        if ($user->entreprise) {
            $user->entreprise->delete();
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.entreprises')->with('success', 'Entreprise supprimée avec succès.');
    }
    
    public function settings()
    {
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        return view('admin.settings', compact('user', 'admin'));
    }
    
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        $admin = Admin::where('user_id', $user->id)->first();
        
        // Mise à jour des informations utilisateur
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        // Gestion de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar s'il existe
            if ($admin && $admin->avatar) {
                Storage::disk('public')->delete('avatars/' . $admin->avatar);
            }
            
            // Sauvegarder le nouvel avatar
            $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('avatars', $avatarName, 'public');
            
            // Créer ou mettre à jour le profil admin
            if ($admin) {
                $admin->update(['avatar' => $avatarName]);
            } else {
                Admin::create([
                    'user_id' => $user->id,
                    'avatar' => $avatarName,
                    'nom' => explode(' ', $request->name)[1] ?? '',
                    'prenom' => explode(' ', $request->name)[0] ?? $request->name,
                    'role' => 'admin',
                ]);
            }
        }
        
        return redirect()->route('admin.settings')->with('success', 'Profil mis à jour avec succès.');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $admin = Auth::user();
        
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }
        
        $admin->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('admin.settings')->with('success', 'Mot de passe modifié avec succès.');
    }
    
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'notifications' => 'array',
            'weekly_recap' => 'boolean',
            'display_mode' => 'in:extended,condensed',
            'dark_mode' => 'boolean',
        ]);
        
        $admin = Auth::user();
        
        // Stocker les préférences dans un champ JSON ou une table séparée
        $preferences = [
            'notifications' => $request->notifications ?? [],
            'weekly_recap' => $request->boolean('weekly_recap'),
            'display_mode' => $request->display_mode ?? 'extended',
            'dark_mode' => $request->boolean('dark_mode'),
        ];
        
        $admin->update(['preferences' => json_encode($preferences)]);
        
        return redirect()->route('admin.settings')->with('success', 'Préférences mises à jour avec succès.');
    }
    
    public function logoutAllDevices()
    {
        Auth::logoutOtherDevices(request('password'));
        
        return redirect()->route('admin.settings')->with('success', 'Déconnexion effectuée sur tous les autres appareils.');
    }
}