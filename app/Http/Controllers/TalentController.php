<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Talent;
use App\Models\CvExperience;
use App\Models\CvFormation;
use App\Models\CvCompetence;
use App\Models\CvLangue;
use App\Models\Pole;
use App\Models\NiveauDiplome;
use App\Models\OffreEmploi;
use App\Models\TypeContrat;
use App\Models\Candidature;
use App\Models\Parrainage;


class TalentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Afficher le dashboard du talent
     */
    public function dashboard()
    {
        $user = Auth::user();
        $talent = $user->talent;
        
        // Charger les relations nécessaires pour éviter les requêtes N+1
        if ($talent) {
            $talent->load(['cvExperiences', 'cvCompetences', 'cvLangues', 'cvFormations']);
        }
        
        // Phrases motivationnelles aléatoires
        $phrases_motivationnelles = [
            "👏 Bravo pour ton parcours jusqu'ici. De grandes opportunités t'attendent !",
            "🎯 Chaque clic te rapproche de ton prochain objectif !",
            "🚀 Ta carrière avance, et ça se voit ! Continue comme ça ✨",
            "🔥 Tu es à deux doigts d'un nouveau badge. Go go go !",
            "🧠 Plus ton profil est complet, plus les bonnes offres viendront à toi !",
            "🥇 Tu fais partie des talents les plus actifs. Impressionnant !",
            "🌱 Un talent comme toi mérite de briller. On t'aide à y arriver."
        ];
        $phrase_du_jour = $phrases_motivationnelles[array_rand($phrases_motivationnelles)];
        
        // Statistiques du talent
        $stats = [
            'offres_consultees' => 0, // À implémenter avec un système de tracking
            'candidatures_envoyees' => Candidature::where('talent_id', $talent->id ?? 0)->count(),
            'offres_favorites' => 0, // À implémenter avec le système de favoris
            'entretiens_realises' => Candidature::where('talent_id', $talent->id ?? 0)
                                                ->where('statut_entreprise', 'entretien')
                                                ->count(),
            'parrainages_actifs' => Parrainage::where('talent_parrain_id', $talent->id ?? 0)
                                              ->where('statut', 'actif')
                                              ->count(),
            'profil_completude' => $this->calculerCompletudeProfil($talent)
        ];
        
        // Badges disponibles
        $badges_disponibles = $this->getBadgesDisponibles();
        
        // Badges débloqués par le talent
        $badges_debloques = $this->getBadgesDebloques($talent, $stats);
        
        return view('talent.dashboard', compact('talent', 'phrase_du_jour', 'stats', 'badges_disponibles', 'badges_debloques'));
    }
    
    /**
     * Calculer le pourcentage de complétude du profil
     */
    private function calculerCompletudeProfil($talent)
    {
        if (!$talent) return 0;
        
        $score = 0;
        $total = 8;
        
        // Informations de base (2 points)
        if ($talent->first_name && $talent->last_name) $score++;
        if ($talent->phone && $talent->email) $score++;
        
        // CV et expériences (3 points)
        if ($talent->cv_reference) $score++;
        if (CvExperience::where('talent_id', $talent->id)->exists()) $score++;
        if (CvFormation::where('talent_id', $talent->id)->exists()) $score++;
        
        // Compétences et langues (2 points)
        if (CvCompetence::where('talent_id', $talent->id)->exists()) $score++;
        if (CvLangue::where('talent_id', $talent->id)->exists()) $score++;
        
        // Pole et famille métier (1 point)
        if ($talent->pole_id && $talent->famille_metier_id) $score++;
        
        return round(($score / $total) * 100);
    }
    
    /**
     * Obtenir la liste de tous les badges disponibles
     */
    private function getBadgesDisponibles()
    {
        return [
            'premier_pas' => ['nom' => '🆕 Premier Pas', 'description' => 'Créer son compte et remplir 30% du CV'],
            'profil_complet' => ['nom' => '🧠 Profil Complet', 'description' => 'CV anonyme complété à 100%'],
            'candidat_actif' => ['nom' => '📤 Candidat Actif', 'description' => '5 candidatures envoyées'],
            'en_entretien' => ['nom' => '📈 En Entretien', 'description' => '1 entretien atteint'],
            'candidat_retenu' => ['nom' => '🏆 Candidat Retenu', 'description' => 'Candidature retenue'],
            'parrain_or' => ['nom' => '🤝 Parrain Or', 'description' => '3 talents parrainés'],
            'boost_activite' => ['nom' => '💎 Boost d\'activité', 'description' => '10 connexions en 15 jours'],
            'multisecteur' => ['nom' => '🌍 Multisecteur', 'description' => 'Candidatures dans 3 domaines différents'],
            'curieux' => ['nom' => '🔍 Curieux', 'description' => 'Consulter au moins 10 offres d\'emploi en 1 jour'],
            'engage' => ['nom' => '💬 Engagé', 'description' => 'Lire une notification ou message de l\'équipe YABARA'],
            'coup_de_coeur' => ['nom' => '❤️ Coup de cœur', 'description' => 'Ajouter au moins 10 offres à ses favoris'],
            'batisseur_reseau' => ['nom' => '🏗️ Bâtisseur de réseau', 'description' => 'Avoir 10 parrainages validés'],
            'actif_regulier' => ['nom' => '🔁 Actif régulier', 'description' => 'Se connecter au moins 10 jours différents sur un mois'],
            'a_jour' => ['nom' => '✍️ À jour', 'description' => 'Modifier son CV anonyme au moins 3 fois en 60 jours'],
            'poly_candidat' => ['nom' => '💼 Poly-candidat', 'description' => 'Postuler dans 4 secteurs d\'activité différents'],
            'pilier_communaute' => ['nom' => '🧭 Pilier de la communauté', 'description' => 'Avoir parrainé 15 talents actifs (comptes complétés à +75%)'],
            'parcours_complet' => ['nom' => '🧱 Parcours Complet', 'description' => 'Atteindre l\'étape 4 (retenu) sur 3 candidatures différentes'],
            'multi_expert' => ['nom' => '🧬 Multi-expert', 'description' => 'Postuler dans 3 familles de métiers différents'],
            'creatif_engage' => ['nom' => '💡 Créatif Engagé', 'description' => 'Avoir modifié son CV au moins 8 fois sur 90 jours'],
            'talent_legendaire' => ['nom' => '🌟 Talent Légendaire', 'description' => 'Être retenu par 3 entreprises différentes via YABARA']
        ];
    }
    
    /**
     * Déterminer quels badges sont débloqués
     */
    private function getBadgesDebloques($talent, $stats)
    {
        $badges_debloques = [];
        
        if (!$talent) return $badges_debloques;
        
        // Premier Pas - Créer son compte et remplir 30% du CV
        if ($stats['profil_completude'] >= 30) {
            $badges_debloques[] = 'premier_pas';
        }
        
        // Profil Complet - CV anonyme complété à 100%
        if ($stats['profil_completude'] >= 100) {
            $badges_debloques[] = 'profil_complet';
        }
        
        // Candidat Actif - 5 candidatures envoyées
        if ($stats['candidatures_envoyees'] >= 5) {
            $badges_debloques[] = 'candidat_actif';
        }
        
        // En Entretien - 1 entretien atteint
        if ($stats['entretiens_realises'] >= 1) {
            $badges_debloques[] = 'en_entretien';
        }
        
        // Candidat Retenu - Candidature retenue
        $candidatures_retenues = Candidature::where('talent_id', $talent->id)
                                           ->where('statut_entreprise', 'retenue')
                                           ->count();
        if ($candidatures_retenues >= 1) {
            $badges_debloques[] = 'candidat_retenu';
        }
        
        // Parrain Or - 3 talents parrainés
        if ($stats['parrainages_actifs'] >= 3) {
            $badges_debloques[] = 'parrain_or';
        }
        
        return $badges_debloques;
    }

    /**
     * Afficher la page d'importation/création de CV
     */
    public function showCvImport()
    {
        $user = Auth::user();
        $talent = $user->talent;
        
        if (!$talent && $user->user_type === 'talent') {
            // Créer automatiquement un profil talent si manquant
            $cvReference = 'CV' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
            $talent = Talent::create([
                'user_id' => $user->id,
                'first_name' => explode(' ', $user->name)[0] ?? 'Prénom',
                'last_name' => explode(' ', $user->name, 2)[1] ?? 'Nom',
                'cv_reference' => $cvReference,
                'profile_completion_percentage' => 20.00
            ]);
        }
        
        $experiences = $talent ? $talent->cvExperiences : collect();
        $formations = $talent ? $talent->cvFormations : collect();
        $competences = $talent ? $talent->cvCompetences : collect();
        $langues = $talent ? $talent->cvLangues : collect();
        
        return view('talent.cv-import', compact('talent', 'experiences', 'formations', 'competences', 'langues'));
    }

    /**
     * Traiter l'upload du CV
     */
    public function uploadCv(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $user = Auth::user();
        $talent = $user->talent;
        
        // Debug: Log des informations utilisateur
        \Log::info('Upload CV Debug:', [
            'user_id' => $user->id,
            'user_type' => $user->user_type,
            'talent_exists' => $talent ? 'yes' : 'no',
            'talent_id' => $talent ? $talent->id : null
        ]);
        
        if (!$talent) {
            // Essayer de créer un profil talent si l'utilisateur n'en a pas
            if ($user->user_type === 'talent') {
                $cvReference = 'CV' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
                $talent = Talent::create([
                    'user_id' => $user->id,
                    'first_name' => explode(' ', $user->name)[0] ?? 'Prénom',
                    'last_name' => explode(' ', $user->name, 2)[1] ?? 'Nom',
                    'cv_reference' => $cvReference,
                    'profile_completion_percentage' => 20.00
                ]);
                \Log::info('Profil talent créé automatiquement:', ['talent_id' => $talent->id]);
            } else {
                return response()->json(['error' => 'Profil talent non trouvé. Utilisateur de type: ' . $user->user_type], 404);
            }
        }

        try {
            // Créer le répertoire cv s'il n'existe pas
            if (!Storage::disk('public')->exists('cv')) {
                Storage::disk('public')->makeDirectory('cv');
            }

            // Supprimer l'ancien CV s'il existe
            if ($talent->cv_original_path && Storage::disk('public')->exists($talent->cv_original_path)) {
                Storage::disk('public')->delete($talent->cv_original_path);
            }

            // Stocker le nouveau CV
            $path = $request->file('cv_file')->store('cv', 'public');
            
            // Mettre à jour le talent
            $talent->update([
                'cv_original_path' => $path,
                'cv_original_name' => $request->file('cv_file')->getClientOriginalName(),
            ]);

            \Log::info('CV uploadé avec succès:', ['path' => $path, 'talent_id' => $talent->id]);

            return response()->json([
                'success' => true,
                'message' => 'CV importé avec succès',
                'cv_url' => route('talent.cv.view')
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur upload CV:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Erreur lors de l\'importation du CV: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Afficher le CV original
     */
    public function viewCv()
    {
        $talent = Auth::user()->talent;
        
        if (!$talent || !$talent->cv_original_path) {
            abort(404, 'CV non trouvé');
        }

        if (!Storage::disk('public')->exists($talent->cv_original_path)) {
            abort(404, 'Fichier CV non trouvé');
        }

        return Storage::disk('public')->response($talent->cv_original_path);
    }

    /**
     * Sauvegarder les données du CV anonyme
     */
    public function saveCvData(Request $request)
    {
        $user = Auth::user();
        $talent = $user->talent;
        
        if (!$talent) {
            // Essayer de créer un profil talent si l'utilisateur n'en a pas
            if ($user->user_type === 'talent') {
                $cvReference = 'CV' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
                $talent = Talent::create([
                    'user_id' => $user->id,
                    'first_name' => explode(' ', $user->name)[0] ?? 'Prénom',
                    'last_name' => explode(' ', $user->name, 2)[1] ?? 'Nom',
                    'cv_reference' => $cvReference,
                    'profile_completion_percentage' => 20.00
                ]);
            } else {
                return response()->json(['error' => 'Profil talent non trouvé. Utilisateur de type: ' . $user->user_type], 404);
            }
        }

        try {
            // Sauvegarder les expériences
            if ($request->has('experiences')) {
                $talent->cvExperiences()->delete();
                foreach ($request->experiences as $index => $exp) {
                    if (!empty($exp['poste']) && !empty($exp['entreprise'])) {
                        $talent->cvExperiences()->create([
                            'poste' => $exp['poste'],
                            'entreprise' => $exp['entreprise'],
                            'date_debut' => $exp['date_debut'] ?? null,
                            'date_fin' => $exp['date_fin'] ?? null,
                            'description' => $exp['description'] ?? null,
                            'en_cours' => $exp['en_cours'] ?? false,
                            'ordre' => $index + 1,
                        ]);
                    }
                }
            }

            // Sauvegarder les formations
            if ($request->has('formations')) {
                $talent->cvFormations()->delete();
                foreach ($request->formations as $index => $form) {
                    if (!empty($form['diplome']) && !empty($form['etablissement'])) {
                        $talent->cvFormations()->create([
                            'diplome' => $form['diplome'],
                            'etablissement' => $form['etablissement'],
                            'annee_obtention' => $form['annee_obtention'] ?? null,
                            'mention' => $form['mention'] ?? null,
                            'ordre' => $index + 1,
                        ]);
                    }
                }
            }

            // Sauvegarder les compétences
            if ($request->has('competences')) {
                $talent->cvCompetences()->delete();
                foreach ($request->competences as $index => $comp) {
                    if (!empty($comp['nom'])) {
                        $talent->cvCompetences()->create([
                            'nom' => $comp['nom'],
                            'niveau' => $comp['niveau'] ?? 'intermediaire',
                            'type' => $comp['type'] ?? 'technique',
                            'ordre' => $index + 1,
                        ]);
                    }
                }
            }

            // Sauvegarder les langues
            if ($request->has('langues')) {
                $talent->cvLangues()->delete();
                foreach ($request->langues as $index => $lang) {
                    if (!empty($lang['nom'])) {
                        $talent->cvLangues()->create([
                            'nom' => $lang['nom'],
                            'niveau' => $lang['niveau'] ?? 'intermediaire',
                            'ordre' => $index + 1,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'CV sauvegardé avec succès',
                'completion_score' => $this->calculateCompletionScore($talent)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la sauvegarde'], 500);
        }
    }

    /**
     * Calculer le score de complétion du CV
     */
    private function calculateCompletionScore($talent)
    {
        $score = 0;
        
        if ($talent->cvExperiences()->count() > 0) $score += 25;
        if ($talent->cvFormations()->count() > 0) $score += 25;
        if ($talent->cvCompetences()->count() > 0) $score += 25;
        if ($talent->cvLangues()->count() > 0) $score += 25;
        
        return $score;
    }

    /**
     * Obtenir les données du CV pour la prévisualisation
     */
    public function getCvData()
    {
        $user = Auth::user();
        $talent = $user->talent;
        
        if (!$talent) {
            // Essayer de créer un profil talent si l'utilisateur n'en a pas
            if ($user->user_type === 'talent') {
                $cvReference = 'CV' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
                $talent = Talent::create([
                    'user_id' => $user->id,
                    'first_name' => explode(' ', $user->name)[0] ?? 'Prénom',
                    'last_name' => explode(' ', $user->name, 2)[1] ?? 'Nom',
                    'cv_reference' => $cvReference,
                    'profile_completion_percentage' => 20.00
                ]);
            } else {
                return response()->json(['error' => 'Profil talent non trouvé. Utilisateur de type: ' . $user->user_type], 404);
            }
        }

        return response()->json([
            'experiences' => $talent->cvExperiences,
            'formations' => $talent->cvFormations,
            'competences' => $talent->cvCompetences,
            'langues' => $talent->cvLangues,
            'completion_score' => $this->calculateCompletionScore($talent)
        ]);
    }

    /**
     * Afficher le profil du talent
     */
    public function showProfile()
    {
        $user = Auth::user();
        $talent = $user->talent;
        
        if (!$talent) {
            // Créer un profil talent si l'utilisateur n'en a pas
            if ($user->user_type === 'talent') {
                $cvReference = 'CV' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
                $talent = Talent::create([
                    'user_id' => $user->id,
                    'first_name' => explode(' ', $user->name)[0] ?? 'Prénom',
                    'last_name' => explode(' ', $user->name)[1] ?? 'Nom',
                    'cv_reference' => $cvReference,
                    'profile_completion_percentage' => 0.00
                ]);
            } else {
                abort(403, 'Accès non autorisé');
            }
        }

        $poles = Pole::all();
        $niveauxDiplomes = NiveauDiplome::all();
        
        return view('talent.profile', compact('talent', 'poles', 'niveauxDiplomes'));
    }

    /**
     * Mettre à jour le profil du talent
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $talent = $user->talent;
        
        if (!$talent) {
            return redirect()->back()->with('error', 'Profil talent non trouvé');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'pole_id' => 'nullable|exists:poles,id',
            'niveau_diplome_id' => 'nullable|exists:niveaux_diplomes,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $talent->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'pole_id' => $request->pole_id,
                'niveau_diplome_id' => $request->niveau_diplome_id
            ]);

            // Gérer l'upload de l'avatar si fourni
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $talent->update(['avatar_type' => $avatarPath]);
            }

            return redirect()->back()->with('success', 'Profil mis à jour avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du profil talent: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du profil');
        }
    }

    /**
     * Afficher les offres d'emploi disponibles
     */
    public function showOffres(Request $request)
    {
        $query = OffreEmploi::with(['entreprise', 'typeContrat', 'pole', 'familleMetier', 'niveauDiplome'])
            ->where('statut', 'publiee')
            ->orderBy('date_publication', 'desc');

        // Filtres
        if ($request->filled('pole_id')) {
            $query->where('pole_id', $request->pole_id);
        }

        if ($request->filled('type_contrat_id')) {
            $query->where('type_contrat_id', $request->type_contrat_id);
        }

        if ($request->filled('lieu')) {
            $query->where('lieu_poste', 'like', '%' . $request->lieu . '%');
        }

        if ($request->filled('recherche')) {
            $recherche = $request->recherche;
            $query->where(function($q) use ($recherche) {
                $q->where('titre', 'like', '%' . $recherche . '%')
                  ->orWhere('descriptif', 'like', '%' . $recherche . '%')
                  ->orWhereHas('entreprise', function($eq) use ($recherche) {
                      $eq->where('nom_entreprise', 'like', '%' . $recherche . '%');
                  });
            });
        }

        $offres = $query->paginate(12)->appends($request->query());

        // Données pour les filtres
        $poles = Pole::all();
        $typesContrat = TypeContrat::all();

        return view('talent.offres', compact('offres', 'poles', 'typesContrat'));
    }

    /**
     * Afficher les détails d'une offre d'emploi
     */
    public function showOffre($id)
    {
        $offre = OffreEmploi::with(['entreprise', 'typeContrat', 'pole', 'familleMetier', 'niveauDiplome'])
            ->where('statut', 'publiee')
            ->findOrFail($id);

        // Incrémenter le nombre de vues
        $offre->increment('nb_vues');

        // Vérifier si le talent a déjà candidaté
        $talent = Auth::user()->talent;
        $aCandidature = false;
        if ($talent) {
            $aCandidature = Candidature::where('talent_id', $talent->id)
                ->where('offre_emploi_id', $offre->id)
                ->exists();
        }

        return view('talent.offre-details', compact('offre', 'aCandidature'));
    }

    /**
     * Postuler à une offre d'emploi
     */
    public function postuler(Request $request, $offreId)
    {
        $talent = Auth::user()->talent;
        
        if (!$talent) {
            return redirect()->back()->with('error', 'Vous devez compléter votre profil talent pour postuler.');
        }

        $offre = OffreEmploi::where('statut', 'publiee')->findOrFail($offreId);

        // Vérifier si le talent a déjà candidaté
        $candidatureExistante = Candidature::where('talent_id', $talent->id)
            ->where('offre_emploi_id', $offre->id)
            ->first();

        if ($candidatureExistante) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        try {
            Candidature::create([
                'talent_id' => $talent->id,
                'offre_emploi_id' => $offre->id,
                'type' => 'reponse_offre',
                'statut_entreprise' => 'candidature_recue',
                'statut_talent' => 'en_attente',
                'lettre_motivation' => $request->message_motivation
            ]);

            // Incrémenter le compteur de candidatures du talent
            $talent->increment('total_applications');

            return redirect()->back()->with('success', 'Votre candidature a été envoyée avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la candidature: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi de votre candidature.');
        }
    }

    /**
     * Afficher le suivi des candidatures du talent
     */
    public function showCandidatures(Request $request)
    {
        $talent = Auth::user()->talent;
        
        if (!$talent) {
            return redirect()->route('talent.profile')->with('error', 'Vous devez compléter votre profil pour voir vos candidatures.');
        }

        $query = Candidature::with(['offreEmploi.entreprise', 'offreEmploi.typeContrat', 'offreEmploi.pole'])
            ->where('talent_id', $talent->id)
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('statut')) {
            $query->where('statut_talent', $request->statut);
        }

        if ($request->filled('statut_entreprise')) {
            $query->where('statut_entreprise', $request->statut_entreprise);
        }

        $candidatures = $query->paginate(10)->appends($request->query());

        // Statistiques
        $stats = [
            'total' => Candidature::where('talent_id', $talent->id)->count(),
            'en_attente' => Candidature::where('talent_id', $talent->id)->where('statut_talent', 'en_attente')->count(),
            'preselectionnes' => Candidature::where('talent_id', $talent->id)->where('statut_entreprise', 'preselctionnee')->count(),
            'entretiens' => Candidature::where('talent_id', $talent->id)->where('statut_entreprise', 'entretien')->count(),
            'retenus' => Candidature::where('talent_id', $talent->id)->where('statut_entreprise', 'retenue')->count(),
        ];

        return view('talent.candidatures', compact('candidatures', 'stats'));
    }

    /**
     * Retirer une candidature
     */
    public function retirerCandidature($candidatureId)
    {
        $talent = Auth::user()->talent;
        
        if (!$talent) {
            return redirect()->back()->with('error', 'Accès non autorisé.');
        }

        $candidature = Candidature::where('id', $candidatureId)
            ->where('talent_id', $talent->id)
            ->where('statut_talent', 'en_attente')
            ->first();

        if (!$candidature) {
            return redirect()->back()->with('error', 'Candidature introuvable ou impossible à retirer.');
        }

        try {
            $candidature->update(['statut_talent' => 'retiree']);
            return redirect()->back()->with('success', 'Candidature retirée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors du retrait de candidature: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du retrait de la candidature.');
        }
    }

    /**
     * Afficher la page de parrainage
     */
    public function showParrainage()
    {
        $talent = Auth::user()->talent;
        
        if (!$talent) {
            return redirect()->route('talent.profile')
                ->with('error', 'Veuillez compléter votre profil avant d\'accéder au parrainage.');
        }

        // Statistiques de parrainage
        $stats = [
            'invites' => Parrainage::where('talent_parrain_id', $talent->id)->count(),
            'comptes_crees' => Parrainage::where('talent_parrain_id', $talent->id)
                ->whereNotNull('talent_parraine_id')
                ->count(),
            'parrainages_valides' => Parrainage::where('talent_parrain_id', $talent->id)
                ->where('statut', 'valide')
                ->count(),
        ];

        // Calcul pour le prochain badge (exemple: tous les 5 parrainages)
        $prochainBadge = 5 - ($stats['parrainages_valides'] % 5);
        if ($prochainBadge == 5 && $stats['parrainages_valides'] > 0) {
            $prochainBadge = 0; // Badge déjà débloqué
        }

        // Liste des parrainages récents
        $parrainages = Parrainage::where('talent_parrain_id', $talent->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('talent.parrainage', compact('talent', 'stats', 'prochainBadge', 'parrainages'));
    }

    /**
     * Envoyer une invitation de parrainage
     */
    public function envoyerInvitation(Request $request)
    {
        $request->validate([
            'email_filleul' => 'required|email|max:255',
            'prenom_filleul' => 'required|string|max:100',
        ], [
            'email_filleul.required' => 'L\'adresse e-mail est obligatoire.',
            'email_filleul.email' => 'Veuillez saisir une adresse e-mail valide.',
            'prenom_filleul.required' => 'Le prénom est obligatoire.',
        ]);

        try {
            $talent = Auth::user()->talent;
            
            if (!$talent) {
                return redirect()->route('talent.profile')
                    ->with('error', 'Veuillez compléter votre profil avant d\'envoyer des invitations.');
            }

            // Vérifier si une invitation n'a pas déjà été envoyée à cette adresse
            $invitationExistante = Parrainage::where('talent_parrain_id', $talent->id)
                ->where('email_entreprise', $request->email_filleul) // Utilisation temporaire du champ email_entreprise
                ->first();

            if ($invitationExistante) {
                return redirect()->route('talent.parrainage')
                    ->with('error', 'Une invitation a déjà été envoyée à cette adresse e-mail.');
            }

            // Créer le parrainage
            $parrainage = Parrainage::create([
                'talent_parrain_id' => $talent->id,
                'email_entreprise' => $request->email_filleul, // Utilisation temporaire
                'nom_entreprise' => $request->prenom_filleul, // Utilisation temporaire
                'code_parrainage' => $talent->reference_cv,
                'statut' => 'en_attente',
                'date_invitation' => now(),
                'parrain_type' => 'talent',
            ]);

            // TODO: Envoyer l'email d'invitation
            // Mail::to($request->email_filleul)->send(new InvitationParrainageMail($parrainage));

            return redirect()->route('talent.parrainage')
                ->with('success', '🎉 Invitation envoyée à ' . $request->prenom_filleul . '. Ton parrainage est lancé ! Tu seras notifié s\'il ou elle rejoint YABARA.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi d\'invitation de parrainage: ' . $e->getMessage());
            return redirect()->route('talent.parrainage')
                ->with('error', 'Une erreur est survenue lors de l\'envoi de l\'invitation.');
        }
    }
}