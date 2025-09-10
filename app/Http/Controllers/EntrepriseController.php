<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Entreprise;
use App\Models\OffreEmploi;
use App\Models\Talent;
use App\Models\Candidature;
use App\Models\Pole;
use App\Models\FamilleMetier;
use App\Models\TypeContrat;
use App\Models\NiveauDiplome;
use App\Models\Parrainage;
use Illuminate\Support\Str;

class EntrepriseController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // WF-E02: Publication Offre d'Emploi
    public function showPublishJobStep1($offreId = null)
    {
        $entreprise = Auth::user()->entreprise;
        $poles = Pole::all();
        $typesContrat = TypeContrat::all();
        
        $offre = null;
        if ($offreId) {
            $offre = OffreEmploi::with(['typeContrat', 'pole', 'familleMetier'])->findOrFail($offreId);
        }
        
        return view('entreprise.publish-job.step1', compact('entreprise', 'poles', 'typesContrat', 'offre'));
    }

    public function saveJobStep1(Request $request)
    {
        try {
            $request->validate([
                'titre' => 'required|string|max:255',
                'descriptif' => 'required|string|min:150',
                'type_contrat_id' => 'required|exists:types_contrats,id',
                'pole_id' => 'required|exists:poles,id',
                'famille_metier_id' => 'required|exists:familles_metiers,id'
            ]);

            // Vérifier que l'utilisateur a bien un profil entreprise
            $user = Auth::user();
            if (!$user || !$user->entreprise) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil entreprise non trouvé. Veuillez compléter votre inscription.'
                ], 422);
            }

            $offre = OffreEmploi::updateOrCreate(
                ['entreprise_id' => $user->entreprise->id, 'statut' => 'brouillon'],
                $request->only(['titre', 'descriptif', 'type_contrat_id', 'pole_id', 'famille_metier_id'])
            );

            return response()->json(['success' => true, 'offre_id' => $offre->id]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la sauvegarde de l\'étape 1: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la sauvegarde. Veuillez réessayer.'
            ], 500);
        }
    }

    public function showPublishJobStep2(Request $request, $offreId = null)
    {
        if ($offreId) {
            // Mode édition
            $offre = OffreEmploi::findOrFail($offreId);
            $request->session()->put('offre_id', $offreId);
        } else {
            // Mode création
            $offreId = $request->session()->get('offre_id');
            if (!$offreId) {
                return redirect()->route('entreprise.publish-job.step1')->with('error', 'Veuillez d\'abord compléter l\'étape 1.');
            }
            $offre = OffreEmploi::findOrFail($offreId);
        }

        $niveauxDiplome = NiveauDiplome::all();
        
        return view('entreprise.publish-job.step2', compact('offre', 'niveauxDiplome'));
    }

    public function saveJobStep2(Request $request, $offreId)
    {
        $request->validate([
            'niveau_diplome_requis' => 'required|exists:niveaux_diplomes,id',
            'experience_minimum' => 'required|string|in:0-2,3-5,6-10,10+',
            'remuneration' => 'nullable|numeric|min:0',
            'lieu_poste' => 'required|string|max:255',
            'teletravail' => 'boolean',
            'mobilite_requise' => 'boolean',
            'competences_recherchees' => 'nullable|string|max:2000'
        ]);

        $offre = OffreEmploi::findOrFail($offreId);
        $offre->update($request->all());

        return response()->json(['success' => true]);
    }

    public function showPublishJobStep3(Request $request, $offreId = null)
    {
        if ($offreId) {
            // Mode édition
            $offre = OffreEmploi::with(['pole', 'familleMetier', 'typeContrat', 'niveauDiplome'])->findOrFail($offreId);
            $request->session()->put('offre_id', $offreId);
        } else {
            // Mode création
            $offreId = $request->session()->get('offre_id');
            if (!$offreId) {
                return redirect()->route('entreprise.publish-job.step1')->with('error', 'Veuillez d\'abord compléter les étapes précédentes.');
            }
            $offre = OffreEmploi::with(['pole', 'familleMetier', 'typeContrat', 'niveauDiplome'])->findOrFail($offreId);
        }
        
        return view('entreprise.publish-job.step3', compact('offre'));
    }

    public function publishJob(Request $request, $offreId)
    {
        $offre = OffreEmploi::findOrFail($offreId);
        
        if ($request->action === 'publier') {
            $offre->update([
                'statut' => 'publiee',
                'date_publication' => now(),
                'reference_offre' => 'YB' . strtoupper(Str::random(5))
            ]);
            
            // Incrémenter le compteur d'offres publiées
            Auth::user()->entreprise->increment('total_offres_publiees');
            
            return response()->json(['success' => true, 'message' => 'Offre publiée avec succès!']);
        }
        
        return response()->json(['success' => true, 'message' => 'Offre sauvegardée en brouillon']);
    }

    // Liste des offres d'emploi de l'entreprise
    public function indexOffres()
    {
        $entreprise = Auth::user()->entreprise;
        
        $offres = $entreprise->offresEmploi()
            ->with(['typeContrat', 'pole', 'familleMetier', 'candidatures'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        // Ajouter des statistiques pour chaque offre
        $offres->getCollection()->transform(function ($offre) {
            $offre->nb_candidatures = $offre->candidatures->count();
            $offre->nb_candidatures_nouvelles = $offre->candidatures->where('statut_entreprise', 'candidature_recue')->count();
            $offre->nb_preselections = $offre->candidatures->where('statut_entreprise', 'preselctionnee')->count();
            $offre->nb_entretiens = $offre->candidatures->where('statut_entreprise', 'entretien')->count();
            $offre->nb_recrutes = $offre->candidatures->where('statut_entreprise', 'retenue')->count();
            return $offre;
        });
        
        return view('entreprise.offres.index', compact('offres'));
    }

    // Page de sélection des offres pour le suivi des candidatures
    public function showOffresSelection()
    {
        $entreprise = Auth::user()->entreprise;
        
        $offres = $entreprise->offresEmploi()
            ->with(['typeContrat', 'pole', 'familleMetier', 'candidatures', 'entreprise'])
            ->where('statut', 'publiee')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        // Ajouter des statistiques pour chaque offre
        $offres->getCollection()->transform(function ($offre) {
            $offre->candidatures_count = $offre->candidatures->count();
            return $offre;
        });
        
        return view('entreprise.offres-selection', compact('offres'));
    }

    // WF-E03: Recherche de Talents
    public function showTalentSearch()
    {
        $poles = Pole::all();
        $niveauxDiplome = NiveauDiplome::all();
        
        return view('entreprise.talent-search', compact('poles', 'niveauxDiplome'));
    }

    public function searchTalents(Request $request)
    {
        $query = Talent::with(['pole', 'familleMetier', 'user', 'experiencesProfessionnelles', 'niveauDiplome'])
            ->whereHas('user', function($q) {
                $q->where('status', 'active');
            });

        // Filtrer par pôle (seulement si spécifié)
        if ($request->filled('pole_id') && $request->pole_id !== '') {
            $query->where('pole_id', $request->pole_id);
        }
        
        // Filtrer par famille de métier (seulement si spécifié)
        if ($request->filled('famille_metier_id') && $request->famille_metier_id !== '') {
            $query->where('famille_metier_id', $request->famille_metier_id);
        }
        
        // Filtrer par expérience minimum (seulement si spécifié)
        if ($request->filled('experience_min') && $request->experience_min !== '') {
            $experienceMin = (int) $request->experience_min;
            
            if ($experienceMin === 0) {
                // 0-2 ans : inclure tous les talents avec 0 à 2 ans d'expérience
                $query->whereHas('experiencesProfessionnelles', function($q) {
                    $q->selectRaw('talent_id, SUM(TIMESTAMPDIFF(YEAR, date_debut, COALESCE(date_fin, NOW()))) as total_experience')
                      ->groupBy('talent_id')
                      ->havingRaw('total_experience <= 2');
                }, '<=', 1); // Au moins une expérience qui respecte la condition
            } else {
                // Pour les autres tranches, calculer l'expérience totale
                $query->whereHas('experiencesProfessionnelles', function($q) use ($experienceMin) {
                    $q->selectRaw('talent_id, SUM(TIMESTAMPDIFF(YEAR, date_debut, COALESCE(date_fin, NOW()))) as total_experience')
                      ->groupBy('talent_id')
                      ->havingRaw('total_experience >= ?', [$experienceMin]);
                });
            }
        }
        
        // Filtrer par niveau de diplôme (seulement si spécifié)
        if ($request->filled('niveau_diplome') && $request->niveau_diplome !== '') {
            $query->where('niveau_diplome_id', $request->niveau_diplome);
        }

        // Ordonner par pertinence (profil complété, puis par date de création)
        $query->orderByDesc('profile_completion_percentage')
              ->orderByDesc('created_at');

        $talents = $query->paginate(12);
        
        // Ajouter des données calculées pour chaque talent
        $talents->getCollection()->transform(function ($talent) {
            // Calculer l'expérience totale
            $totalExperience = 0;
            foreach ($talent->experiencesProfessionnelles as $exp) {
                $dateDebut = \Carbon\Carbon::parse($exp->date_debut);
                $dateFin = $exp->date_fin ? \Carbon\Carbon::parse($exp->date_fin) : \Carbon\Carbon::now();
                $totalExperience += $dateDebut->diffInYears($dateFin);
            }
            $talent->total_experience_years = $totalExperience;
            
            // S'assurer que les compteurs sont définis
            $talent->total_applications = $talent->total_applications ?? 0;
            $talent->total_interviews = $talent->total_interviews ?? 0;
            $talent->total_offers_viewed = $talent->total_offers_viewed ?? 0;
            
            return $talent;
        });
        
        return response()->json($talents);
    }

    public function linkTalentToOffer(Request $request)
    {
        $request->validate([
            'talent_id' => 'required|exists:talents,id',
            'offre_id' => 'required|exists:offres_emploi,id'
        ]);

        Candidature::create([
            'talent_id' => $request->talent_id,
            'offre_emploi_id' => $request->offre_id,
            'type' => 'reponse_offre',
            'statut_entreprise' => 'candidature_recue',
            'statut_talent' => 'en_attente'
        ]);

        return response()->json(['success' => true, 'message' => 'Talent lié à l\'offre avec succès']);
    }

    // WF-E04: Suivi Candidatures KANBAN
    public function showKanban(Request $request)
    {
        $entreprise = Auth::user()->entreprise;
        $offreId = $request->get('offre');
        
        $candidaturesQuery = Candidature::with(['talent.user', 'offreEmploi'])
            ->whereHas('offreEmploi', function($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            });
            
        // Filtrer par offre si spécifiée
        if ($offreId) {
            $candidaturesQuery->where('offre_emploi_id', $offreId);
        }
        
        $candidatures = $candidaturesQuery->get()->groupBy('statut_entreprise');

        // Statistiques pour le kanban
        $stats = [
            'candidatures_recues' => $candidatures->get('candidature_recue', collect())->count(),
            'preselections' => $candidatures->get('preselctionnee', collect())->count(),
            'entretiens' => $candidatures->get('entretien', collect())->count(),
            'recrutes' => $candidatures->get('retenue', collect())->count()
        ];

        // Offres pour le filtre
        $offres = $entreprise->offresEmploi()->where('statut', 'publiee')->get();
        
        // Offre sélectionnée pour affichage
        $offreSelectionnee = $offreId ? $entreprise->offresEmploi()->find($offreId) : null;
        
        // Familles métiers pour le filtre
        $famillesMetiers = FamilleMetier::all();

        return view('entreprise.candidatures-kanban', compact('candidatures', 'stats', 'offres', 'famillesMetiers', 'offreSelectionnee'));
    }

    public function updateCandidatureStatus(Request $request, $candidatureId = null)
    {
        // Support pour les deux formats d'appel
        $candidatureId = $candidatureId ?? $request->candidature_id;
        $nouveauStatut = $request->statut ?? $request->new_status;
        
        $request->validate([
            'statut' => 'nullable|in:candidature_recue,preselctionnee,entretien,retenue,refusee',
            'new_status' => 'nullable|in:candidature_recue,preselctionnee,entretien,retenue,refusee',
            'candidature_id' => 'nullable|integer|exists:candidatures,id'
        ]);

        $entreprise = Auth::user()->entreprise;
        $candidature = $entreprise->candidatures()->findOrFail($candidatureId);
        
        $ancienStatut = $candidature->statut_entreprise;
        $candidature->update(['statut_entreprise' => $nouveauStatut]);

        // Messages de confirmation
        $messages = [
            'preselctionnee' => 'Candidature présélectionnée avec succès',
            'entretien' => 'Entretien programmé avec succès',
            'retenue' => 'Candidature retenue avec succès',
            'refusee' => 'Candidature marquée comme refusée'
        ];

        // Logique selon le nouveau statut
        switch ($nouveauStatut) {
            case 'preselctionnee':
                $candidature->update(['statut_talent' => 'en_attente']);
                // Envoyer notifications
                break;
            case 'entretien':
                $candidature->update(['statut_talent' => 'en_attente']);
                // Envoyer notifications
                break;
            case 'retenue':
                $candidature->update(['statut_talent' => 'acceptee']);
                $candidature->offreEmploi->increment('nb_recrutes');
                Auth::user()->entreprise->increment('total_recrutements_finalises');
                // Envoyer emails de félicitations
                break;
            case 'refusee':
                $candidature->update(['statut_talent' => 'refusee']);
                break;
        }

        // Calculer les statistiques mises à jour
        $stats = [
            'candidatures_recues' => $entreprise->candidatures()->where('statut_entreprise', 'candidature_recue')->count(),
            'preselections' => $entreprise->candidatures()->where('statut_entreprise', 'preselctionnee')->count(),
            'entretiens' => $entreprise->candidatures()->where('statut_entreprise', 'entretien')->count(),
            'recrutes' => $entreprise->candidatures()->where('statut_entreprise', 'retenue')->count()
        ];

        return response()->json([
            'success' => true,
            'message' => $messages[$nouveauStatut] ?? 'Statut mis à jour avec succès',
            'stats' => $stats
        ]);
    }

    // WF-E01: Page d'accueil entreprise
    public function accueil()
    {
        $entreprise = Auth::user()->entreprise;
        
        // Statistiques de base pour l'accueil
        $stats = [
            'offres_publiees' => $entreprise->offresEmploi()->count(),
            'vues_totales' => $entreprise->offresEmploi()->sum('nb_vues'),
            'candidatures_mois' => $entreprise->candidatures()
                ->whereMonth('candidatures.created_at', now()->month)
                ->whereYear('candidatures.created_at', now()->year)
                ->count(),
            'taux_reponse' => $this->calculerTauxReponse($entreprise)
        ];
        
        // Candidatures en attente
        $candidatures_attente = $entreprise->candidatures()
            ->where('statut_entreprise', 'candidature_recue')
            ->count();
            
        // Offres expirées
        $offres_expirees = $entreprise->offresEmploi()
            ->where('date_expiration', '<', now())
            ->where('statut', 'active')
            ->count();
            
        // Performances par offre (top 5 offres récentes)
        $offres_performance = $entreprise->offresEmploi()
            ->with(['candidatures'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($offre) {
                return [
                    'titre' => $offre->titre,
                    'vues' => $offre->nb_vues ?? 0,
                    'candidatures' => $offre->candidatures->count(),
                    'entretiens' => $offre->candidatures->where('statut_entreprise', 'entretien')->count(),
                    'recrutes' => $offre->candidatures->where('statut_entreprise', 'retenue')->count()
                ];
            });
        
        return view('entreprise.accueil', compact('entreprise', 'stats', 'candidatures_attente', 'offres_expirees', 'offres_performance'));
    }
    
    private function calculerTauxReponse($entreprise)
    {
        $totalCandidatures = $entreprise->candidatures()->count();
        $candidaturesTraitees = $entreprise->candidatures()
            ->whereIn('statut_entreprise', ['preselctionnee', 'entretien', 'retenue', 'refusee'])
            ->count();
            
        return $totalCandidatures > 0 ? round(($candidaturesTraitees / $totalCandidatures) * 100) : 0;
    }

    // WF-E05: Dashboard & Statistiques
    public function dashboard()
    {
        $entreprise = Auth::user()->entreprise;
        $periode = request('periode', 'mois');
        
        // Calculer les KPIs
        $kpis = $this->calculerKPIs($entreprise, $periode);
        
        // Données pour les graphiques
        $evolutionData = $this->getEvolutionData($entreprise, $periode);
        $repartitionCandidatures = $this->getRepartitionCandidatures($entreprise, $periode);
        
        // Performance par offre
        $offresPerformance = $this->getOffresPerformance($entreprise, $periode);
        
        return view('entreprise.dashboard-stats', [
            'entreprise' => $entreprise,
            'kpis' => $kpis,
            'evolutionData' => $evolutionData,
            'repartition_candidatures' => $repartitionCandidatures,
            'offres_performance' => $offresPerformance
        ] + $evolutionData);
    }
    
    public function getDashboardData(Request $request)
    {
        $entreprise = Auth::user()->entreprise;
        $periode = $request->get('periode', 'mois');
        
        $kpis = $this->calculerKPIs($entreprise, $periode);
        $evolutionData = $this->getEvolutionData($entreprise, $periode);
        $repartitionCandidatures = $this->getRepartitionCandidatures($entreprise, $periode);
        $offresPerformance = $this->getOffresPerformance($entreprise, $periode);
        
        return response()->json([
            'kpis' => $kpis,
            'repartition_candidatures' => $repartitionCandidatures,
            'offres_performance' => $offresPerformance
        ] + $evolutionData);
    }
    
    public function exportDashboard(Request $request)
    {
        $format = $request->get('format', 'pdf');
        $periode = $request->get('periode', 'mois');
        $entreprise = Auth::user()->entreprise;
        
        $data = [
            'entreprise' => $entreprise,
            'periode' => $periode,
            'kpis' => $this->calculerKPIs($entreprise, $periode),
            'offres_performance' => $this->getOffresPerformance($entreprise, $periode),
            'date_export' => now()->format('d/m/Y H:i')
        ];
        
        if ($format === 'pdf') {
            return $this->exportToPDF($data);
        } else {
            return $this->exportToExcel($data);
        }
    }
    
    private function exportToPDF($data)
    {
        try {
            // Générer le contenu HTML pour le PDF
            $html = view('entreprise.exports.dashboard-pdf', $data)->render();
            
            // Pour l'instant, retourner le HTML directement
            // TODO: Intégrer une bibliothèque PDF comme dompdf ou wkhtmltopdf
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'inline; filename="dashboard_' . $data['periode'] . '_' . date('Y-m-d') . '.html"');
                
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la génération du PDF: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du PDF: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function exportToExcel($data)
    {
        try {
            // Préparer les données pour Excel
            $offres = $data['offres_performance'];
            $kpis = $data['kpis'];
            
            // Créer le contenu CSV
            $csvContent = "Rapport Dashboard - " . $data['entreprise']->nom_entreprise . "\n";
            $csvContent .= "Période: " . ucfirst($data['periode']) . "\n";
            $csvContent .= "Date d'export: " . $data['date_export'] . "\n\n";
            
            // KPIs
            $csvContent .= "=== INDICATEURS CLÉS ===\n";
            $csvContent .= "Offres publiées," . $kpis['offres_publiees'] . "\n";
            $csvContent .= "Offres actives," . $kpis['offres_actives'] . "\n";
            $csvContent .= "Vues totales," . $kpis['vues_offres'] . "\n";
            $csvContent .= "Candidatures reçues," . $kpis['candidatures_recues'] . "\n";
            $csvContent .= "Entretiens programmés," . $kpis['entretiens_programmes'] . "\n";
            $csvContent .= "Recrutements finalisés," . $kpis['recrutements_finalises'] . "\n\n";
            
            // Performance par offre
            $csvContent .= "=== PERFORMANCE PAR OFFRE ===\n";
            $csvContent .= "Titre,Référence,Date publication,Vues,Candidatures,Entretiens,Recrutés,Taux conversion,Statut\n";
            
            foreach ($offres as $offre) {
                $taux = $offre->nb_candidatures > 0 ? round(($offre->nb_recrutes / $offre->nb_candidatures) * 100, 1) : 0;
                $csvContent .= '"' . $offre->titre . '","' . $offre->reference_offre . '","' . $offre->date_publication . '",';
                $csvContent .= $offre->nb_vues . ',' . $offre->nb_candidatures . ',' . $offre->nb_entretiens . ',';
                $csvContent .= $offre->nb_recrutes . ',' . $taux . '%,"' . ucfirst($offre->statut) . '"\n';
            }
            
            $filename = 'dashboard_' . $data['entreprise']->id . '_' . $data['periode'] . '_' . date('Y-m-d_H-i-s') . '.csv';
            
            return response($csvContent)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la génération du fichier Excel: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function calculerKPIs($entreprise, $periode)
    {
        $dateDebut = $this->getDateDebut($periode);
        
        $offresPubliees = $entreprise->offresEmploi()
            ->where('statut', 'publiee')
            ->when($dateDebut, fn($q) => $q->where('date_publication', '>=', $dateDebut))
            ->count();
            
        $offresActives = $entreprise->offresEmploi()
            ->where('statut', 'publiee')
            ->where('date_expiration', '>', now())
            ->count();
            
        $vuesOffres = $entreprise->offresEmploi()
            ->when($dateDebut, fn($q) => $q->where('created_at', '>=', $dateDebut))
            ->sum('nb_vues');
            
        $candidaturesRecues = $entreprise->candidatures()
            ->when($dateDebut, fn($q) => $q->where('candidatures.created_at', '>=', $dateDebut))
            ->count();
            
        $entretiensProgrammes = $entreprise->candidatures()
            ->where('statut_entreprise', 'entretien')
            ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
            ->count();
            
        $recrutementsFinales = $entreprise->candidatures()
            ->where('statut_entreprise', 'retenue')
            ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
            ->count();
            
        $tauxConversion = $candidaturesRecues > 0 
            ? round(($recrutementsFinales / $candidaturesRecues) * 100, 1)
            : 0;
            
        $tauxVueMoyen = $offresPubliees > 0 
            ? round($vuesOffres / $offresPubliees, 1)
            : 0;
        
        // Calculer les profils visités (talents qui ont vu les offres)
        $profilsVisites = $entreprise->offresEmploi()
            ->when($dateDebut, fn($q) => $q->where('created_at', '>=', $dateDebut))
            ->sum('nb_vues');
            
        // Calculer les talents liés aux offres (candidatures uniques)
        $talentsLies = $entreprise->candidatures()
            ->when($dateDebut, fn($q) => $q->where('candidatures.created_at', '>=', $dateDebut))
            ->distinct('talent_id')
            ->count();

        return [
            'offres_publiees' => $offresPubliees,
            'offres_actives' => $offresActives,
            'candidatures_mois' => $candidaturesRecues,
            'vues_totales' => $vuesOffres,
            'profils_visites' => $profilsVisites,
            'talents_lies' => $talentsLies,
            'entretiens_programmes' => $entretiensProgrammes,
            'candidats_recrutes' => $recrutementsFinales,
            'taux_conversion' => $tauxConversion,
            'taux_vue_moyen' => $tauxVueMoyen
        ];
    }
    
    private function getEvolutionData($entreprise, $periode)
    {
        $dateDebut = $this->getDateDebut($periode);
        $format = $this->getDateFormat($periode);
        $interval = $this->getDateInterval($periode);
        
        // Générer les labels de dates
        $labels = [];
        $current = $dateDebut->copy();
        while ($current <= now()) {
            $labels[] = $current->format($format);
            $current->add($interval);
        }
        
        // Données d'évolution
        $evolutionOffres = [];
        $evolutionCandidatures = [];
        $evolutionRecrutements = [];
        
        foreach ($labels as $label) {
            $dateLabel = \Carbon\Carbon::createFromFormat($format, $label);
            $dateFinLabel = $dateLabel->copy()->add($interval);
            
            $evolutionOffres[] = $entreprise->offresEmploi()
                ->where('date_publication', '>=', $dateLabel)
                ->where('date_publication', '<', $dateFinLabel)
                ->count();
                
            $evolutionCandidatures[] = $entreprise->candidatures()
                ->where('candidatures.created_at', '>=', $dateLabel)
                ->where('candidatures.created_at', '<', $dateFinLabel)
                ->count();
                
            $evolutionRecrutements[] = $entreprise->candidatures()
                ->where('statut_entreprise', 'retenue')
                ->where('candidatures.updated_at', '>=', $dateLabel)
                ->where('candidatures.updated_at', '<', $dateFinLabel)
                ->count();
        }
        
        return [
            'labels' => $labels,
            'data' => $evolutionCandidatures,
            'evolution_labels' => $labels,
            'evolution_offres' => $evolutionOffres,
            'evolution_candidatures' => $evolutionCandidatures,
            'evolution_recrutements' => $evolutionRecrutements
        ];
    }
    
    private function getRepartitionCandidatures($entreprise, $periode)
    {
        $dateDebut = $this->getDateDebut($periode);
        
        $recues = $entreprise->candidatures()
            ->where('statut_entreprise', 'candidature_recue')
            ->when($dateDebut, fn($q) => $q->where('candidatures.created_at', '>=', $dateDebut))
            ->count();
            
        $preselectionnees = $entreprise->candidatures()
            ->where('statut_entreprise', 'preselctionnee')
            ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
            ->count();
            
        $entretiens = $entreprise->candidatures()
            ->where('statut_entreprise', 'entretien')
            ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
            ->count();
            
        $retenues = $entreprise->candidatures()
            ->where('statut_entreprise', 'retenue')
            ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
            ->count();
        
        return [
            'candidatures_recues' => [
                'label' => 'Candidatures reçues',
                'count' => $recues,
                'color' => '#3B82F6'
            ],
            'preselectionnees' => [
                'label' => 'Présélectionnées',
                'count' => $preselectionnees,
                'color' => '#F59E0B'
            ],
            'entretiens' => [
                'label' => 'Entretiens',
                'count' => $entretiens,
                'color' => '#10B981'
            ],
            'retenues' => [
                'label' => 'Retenues',
                'count' => $retenues,
                'color' => '#8B5CF6'
            ]
        ];
    }
    
    private function getOffresPerformance($entreprise, $periode)
    {
        $dateDebut = $this->getDateDebut($periode);
        
        return $entreprise->offresEmploi()
            ->with(['candidatures'])
            ->when($dateDebut, fn($q) => $q->where('date_publication', '>=', $dateDebut))
            ->get()
            ->each(function ($offre) {
                // Add computed attributes to the model
                $offre->nb_candidatures = $offre->candidatures->count();
                $offre->nb_entretiens = $offre->candidatures->where('statut_entreprise', 'entretien')->count();
                $offre->nb_recrutes = $offre->candidatures->where('statut_entreprise', 'retenue')->count();
            });
    }
    
    private function getDateDebut($periode)
    {
        return match($periode) {
            'semaine' => now()->startOfWeek(),
            'mois' => now()->startOfMonth(),
            'trimestre' => now()->startOfQuarter(),
            'annee' => now()->startOfYear(),
            default => now()->startOfMonth()
        };
    }
    
    private function getDateFormat($periode)
    {
        return match($periode) {
            'semaine' => 'd/m',
            'mois' => 'd/m',
            'trimestre' => 'M Y',
            'annee' => 'M Y',
            default => 'd/m'
        };
    }
    
    private function getDateInterval($periode)
    {
        return match($periode) {
            'semaine' => \Carbon\CarbonInterval::day(),
            'mois' => \Carbon\CarbonInterval::day(),
            'trimestre' => \Carbon\CarbonInterval::month(),
            'annee' => \Carbon\CarbonInterval::month(),
            default => \Carbon\CarbonInterval::day()
        };
    }






    
    public function parrainage()
    {
        $entreprise = Auth::user()->entreprise;
        
        // Statistiques de parrainage
        $stats = [
            'invitations_envoyees' => $entreprise->parrainages()->count(),
            'inscriptions_reussies' => $entreprise->parrainages()->accepte()->count(),
            'entreprises_actives' => $entreprise->parrainages()->actif()->count(),
            'recompenses_gagnees' => $entreprise->parrainages()->recompenseAccordee()->sum('montant_recompense')
        ];
        
        // Code de parrainage de l'entreprise
        $code_parrainage = 'ENT' . str_pad($entreprise->id, 6, '0', STR_PAD_LEFT);
        
        // Historique des parrainages
        $parrainages = $entreprise->parrainages()
            ->with(['entrepriseParrainee'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('entreprise.parrainage', compact('stats', 'code_parrainage', 'parrainages'));
    }
    
    public function inviterEntreprise(Request $request)
    {
        $request->validate([
            'email_entreprise' => 'required|email|unique:parrainages,email_entreprise',
            'nom_entreprise' => 'nullable|string|max:255',
            'message_personnel' => 'nullable|string|max:500'
        ]);
        
        $entreprise = Auth::user()->entreprise;
        
        // Créer le parrainage
        $parrainage = Parrainage::create([
            'entreprise_parrain_id' => $entreprise->id,
            'email_entreprise' => $request->email_entreprise,
            'nom_entreprise' => $request->nom_entreprise,
            'message_personnel' => $request->message_personnel,
            'parrain_type' => 'entreprise',
            'ip_invitation' => $request->ip(),
            'user_agent_invitation' => $request->userAgent()
        ]);
        
        // Envoyer l'email d'invitation
        $this->envoyerEmailInvitation($parrainage);
        
        return response()->json([
            'success' => true,
            'message' => 'Invitation envoyée avec succès !',
            'parrainage' => $parrainage
        ]);
    }
    
    private function envoyerEmailInvitation($parrainage)
    {
        // TODO: Implémenter l'envoi d'email
        // Mail::to($parrainage->email_entreprise)->send(new InvitationParrainageEntreprise($parrainage));
        
        // Pour le moment, on simule l'envoi
        \Log::info('Email d\'invitation envoyé', [
            'parrainage_id' => $parrainage->id,
            'email' => $parrainage->email_entreprise,
            'code' => $parrainage->code_parrainage
        ]);
    }

    // Méthodes pour les candidatures
    public function getCandidaturesData(Request $request)
    {
        $entreprise = Auth::user()->entreprise;
        
        $candidatures = $entreprise->candidatures()
            ->with(['talent.user', 'talent.niveauDiplome', 'offreEmploi.familleMetier'])
            ->when($request->offre_id, fn($q) => $q->where('offre_emploi_id', $request->offre_id))
            ->when($request->statut, fn($q) => $q->where('statut_entreprise', $request->statut))
            ->when($request->famille_metier_id, function($q) use ($request) {
                $q->whereHas('offreEmploi', function($subQ) use ($request) {
                    $subQ->where('famille_metier_id', $request->famille_metier_id);
                });
            })
            ->when($request->periode, function($q) use ($request) {
                $dateDebut = $this->getDateDebut($request->periode);
                if ($dateDebut) {
                    $q->where('created_at', '>=', $dateDebut);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        $stats = [
            'total' => $candidatures->count(),
            'candidature_recue' => $candidatures->where('statut_entreprise', 'candidature_recue')->count(),
            'preselections' => $candidatures->where('statut_entreprise', 'preselctionnee')->count(),
            'entretiens' => $candidatures->where('statut_entreprise', 'entretien')->count(),
            'retenues' => $candidatures->where('statut_entreprise', 'retenue')->count()
        ];
        
        return response()->json([
            'candidatures' => $candidatures,
            'stats' => $stats
        ]);
    }
    
    public function getCandidatureDetails($candidatureId)
    {
        $entreprise = Auth::user()->entreprise;
        $candidature = $entreprise->candidatures()
            ->with(['talent.user', 'talent.niveauDiplome', 'talent.experiencesProfessionnelles', 'talent.formations', 'offreEmploi'])
            ->findOrFail($candidatureId);
            
        $html = view('entreprise.partials.candidature-details', compact('candidature'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
    
    // WF-E06: Badges Entreprise - Salle de Trophées
    public function showBadges()
    {
        $entreprise = Auth::user()->entreprise;
        
        // Messages aléatoires pour la salle de trophées
        $messagesAleatoires = [
            "Débloquez votre potentiel RH 💼",
            "Plus vous recrutez, plus vous progressez 🚀",
            "Une salle des trophées à votre image 🏆",
            "Célébrez chaque victoire dans votre aventure RH 🎉",
            "Les meilleurs recruteurs ne passent pas inaperçus 👀"
        ];
        $messageAleatoire = $messagesAleatoires[array_rand($messagesAleatoires)];
        
        // Définir tous les badges disponibles avec leurs critères
        $allBadges = $this->getAllBadgesDefinitions();
        
        // Calculer le statut de chaque badge
        $badges = [];
        foreach ($allBadges as $badgeData) {
            $badge = $badgeData;
            $badge['obtained'] = $this->checkBadgeCondition($entreprise, $badge['id']);
            $badge['progression'] = $this->calculateBadgeProgression($entreprise, $badge['id']);
            $badge['date_obtention'] = $badge['obtained'] ? now() : null;
            $badges[] = $badge;
        }
        
        $badgesObtenus = collect($badges)->where('obtained', true);
        $totalBadgesDisponibles = count($allBadges);
        $pourcentageCompletion = $totalBadgesDisponibles > 0 ? ($badgesObtenus->count() / $totalBadgesDisponibles) * 100 : 0;
        
        $stats = [
            'total_badges' => $totalBadgesDisponibles,
            'badges_obtenus' => $badgesObtenus->count(),
            'badges_recents' => $badgesObtenus->where('date_obtention', '>=', now()->subDays(30))->count(),
            'points_total' => $badgesObtenus->sum('points'),
            'niveau_actuel' => $this->calculerNiveauEntreprise($entreprise),
            'niveau_entreprise' => $this->calculerNiveauEntreprise($entreprise),
            'pourcentage_completion' => $pourcentageCompletion,
            'credits_disponibles' => $badgesObtenus->sum('points'),
            'reduction_max' => min(50, floor($badgesObtenus->sum('points') / 100) * 5)
        ];
        
        // Prochains objectifs (badges non obtenus avec progression > 0)
        $prochains_objectifs = collect($badges)
            ->where('obtained', false)
            ->where('progression', '>', 0)
            ->take(6)
            ->values()
            ->toArray();
        
        return view('entreprise.badges', compact('badges', 'stats', 'prochains_objectifs', 'messageAleatoire'));
    }
    
    public function checkNewBadges()
    {
        $entreprise = Auth::user()->entreprise;
        
        // Logique pour vérifier les nouveaux badges
        $newBadges = $this->verifierNouveauxBadges($entreprise);
        
        return response()->json([
            'success' => true,
            'new_badges' => $newBadges
        ]);
    }
    
    private function getAllBadgesDefinitions()
    {
        return [
            // Badges de Recrutement
            [
                'id' => 'recruteur_express',
                'nom' => 'Recruteur Express 🚀',
                'description' => '1 recrutement en moins de 14 jours',
                'message_marketing' => 'Rapide et efficace, vous inspirez confiance !',
                'recompense' => 'Boost gratuit d\'annonce',
                'icon' => 'fas fa-rocket',
                'color' => 'primary',
                'category' => 'recrutement',
                'points' => 100,
                'criteres' => 'Finaliser un recrutement dans les 14 jours suivant la publication de l\'offre',
                'valeur_requise' => 1
            ],
            [
                'id' => 'chasseur_talents',
                'nom' => 'Chasseur de Talents 🧠',
                'description' => '5 talents présélectionnés',
                'message_marketing' => 'Un œil de lynx RH ! Vous détectez les pépites.',
                'recompense' => 'Affichage prioritaire',
                'icon' => 'fas fa-search',
                'color' => 'success',
                'category' => 'recrutement',
                'points' => 150,
                'criteres' => 'Présélectionner 5 talents pour vos offres',
                'valeur_requise' => 5
            ],
            [
                'id' => 'maitre_matching',
                'nom' => 'Maître du Matching 💡',
                'description' => '10 talents ont postulé à vos offres',
                'message_marketing' => 'Vous visez juste à chaque fois.',
                'recompense' => 'Accès à des suggestions IA premium',
                'icon' => 'fas fa-lightbulb',
                'color' => 'warning',
                'category' => 'recrutement',
                'points' => 200,
                'criteres' => 'Recevoir 10 candidatures sur vos offres',
                'valeur_requise' => 10
            ],
            [
                'id' => 'architecte_equipe',
                'nom' => 'Architecte d\'Équipe 🏗️',
                'description' => '5 recrutements réussis',
                'message_marketing' => 'Vous construisez les fondations de demain.',
                'recompense' => 'Badge + remerciement officiel',
                'icon' => 'fas fa-building',
                'color' => 'info',
                'category' => 'recrutement',
                'points' => 500,
                'criteres' => 'Finaliser 5 recrutements avec succès',
                'valeur_requise' => 5
            ],
            [
                'id' => 'recruteur_eclair',
                'nom' => 'Recruteur Éclair 🌩️',
                'description' => '1 recrutement effectué dans la semaine suivant la publication',
                'message_marketing' => 'Rapidité + efficacité = talent sécurisé !',
                'recompense' => 'Boost prioritaire automatique',
                'icon' => 'fas fa-bolt',
                'color' => 'warning',
                'category' => 'recrutement',
                'points' => 150,
                'criteres' => 'Recruter dans les 7 jours suivant la publication',
                'valeur_requise' => 1
            ],
            
            // Badges d'Activité
            [
                'id' => 'star_mois',
                'nom' => 'Star du Mois 🌟',
                'description' => 'Top 3 entreprises les + actives du mois',
                'message_marketing' => 'Vous brillez sur la plateforme.',
                'recompense' => 'Mise en avant dans newsletter',
                'icon' => 'fas fa-star',
                'color' => 'warning',
                'category' => 'activite',
                'points' => 300,
                'criteres' => 'Être dans le top 3 des entreprises les plus actives',
                'valeur_requise' => 1
            ],
            [
                'id' => 'marathon_rh',
                'nom' => 'Marathon RH 🏃‍♂️',
                'description' => 'Connexion 7 jours de suite',
                'message_marketing' => 'La régularité paie toujours.',
                'recompense' => 'XP bonus ou badge visuel',
                'icon' => 'fas fa-running',
                'color' => 'success',
                'category' => 'activite',
                'points' => 100,
                'criteres' => 'Se connecter 7 jours consécutifs',
                'valeur_requise' => 7
            ],
            [
                'id' => 'serial_publisher',
                'nom' => 'Serial Publisher 📣',
                'description' => '10 offres d\'emploi publiées',
                'message_marketing' => 'Vous avez toujours un poste à pourvoir… et un talent à découvrir !',
                'recompense' => '1 publication gratuite',
                'icon' => 'fas fa-bullhorn',
                'color' => 'primary',
                'category' => 'activite',
                'points' => 250,
                'criteres' => 'Publier 10 offres d\'emploi',
                'valeur_requise' => 10
            ],
            [
                'id' => 'recruteur_nocturne',
                'nom' => 'Recruteur Nocturne 🌙',
                'description' => 'Connexion entre 21h et 6h, au moins 2 fois sur une semaine',
                'message_marketing' => 'Même la nuit, vous construisez votre équipe !',
                'recompense' => 'Badge spécial nocturne',
                'icon' => 'fas fa-moon',
                'color' => 'dark',
                'category' => 'activite',
                'points' => 75,
                'criteres' => 'Se connecter la nuit (21h-6h) au moins 2 fois par semaine',
                'valeur_requise' => 2
            ],
            [
                'id' => 'explorateur_yabara',
                'nom' => 'Explorateur YABARA 🧭',
                'description' => 'A exploré toutes les sections (Kanban, stats, badges, etc.)',
                'message_marketing' => 'Vous connaissez YABARA comme votre poche.',
                'recompense' => 'Badge explorateur + 1 mois premium',
                'icon' => 'fas fa-compass',
                'color' => 'info',
                'category' => 'activite',
                'points' => 200,
                'criteres' => 'Visiter toutes les sections de la plateforme',
                'valeur_requise' => 5
            ],
            
            // Badges de Performance
            [
                'id' => 'full_pack',
                'nom' => 'Full Pack 💼',
                'description' => 'Toutes fonctionnalités ont été utilisées',
                'message_marketing' => 'Vous exploitez 100% du potentiel de YABARA.',
                'recompense' => 'Badge or + mini-coaching RH',
                'icon' => 'fas fa-briefcase',
                'color' => 'warning',
                'category' => 'performance',
                'points' => 400,
                'criteres' => 'Utiliser toutes les fonctionnalités disponibles',
                'valeur_requise' => 10
            ],
            [
                'id' => 'boite_talents',
                'nom' => 'Boîte à Talents 💼',
                'description' => '20 talents liés à des offres',
                'message_marketing' => 'Votre vivier de candidats est en pleine croissance !',
                'recompense' => 'Boost visibilité + badge argent',
                'icon' => 'fas fa-users',
                'color' => 'primary',
                'category' => 'performance',
                'points' => 300,
                'criteres' => 'Avoir 20 talents qui ont postulé à vos offres',
                'valeur_requise' => 20
            ],
            [
                'id' => 'analyste_rh',
                'nom' => 'Analyste RH 📊',
                'description' => '3 rapports statistiques consultés',
                'message_marketing' => 'Des décisions guidées par les données, bravo👏 !',
                'recompense' => 'Accès à un rapport premium',
                'icon' => 'fas fa-chart-bar',
                'color' => 'info',
                'category' => 'performance',
                'points' => 150,
                'criteres' => 'Consulter 3 rapports statistiques',
                'valeur_requise' => 3
            ],
            [
                'id' => 'reactif_pro',
                'nom' => 'Réactif Pro ⚡',
                'description' => '90% des candidatures traitées en moins de 72h',
                'message_marketing' => 'Votre réactivité attire les meilleurs profils.',
                'recompense' => 'Affichage prioritaire 7 jours',
                'icon' => 'fas fa-tachometer-alt',
                'color' => 'success',
                'category' => 'performance',
                'points' => 250,
                'criteres' => 'Traiter 90% des candidatures en moins de 72h',
                'valeur_requise' => 90
            ],
            [
                'id' => 'offre_parfaite',
                'nom' => 'Offre Parfaite ✅',
                'description' => 'Offre avec 100% des champs remplis',
                'message_marketing' => 'Une annonce claire attire les meilleurs talents.',
                'recompense' => 'Coaching annonce ou visibilité',
                'icon' => 'fas fa-check-circle',
                'color' => 'success',
                'category' => 'performance',
                'points' => 100,
                'criteres' => 'Publier une offre avec tous les champs remplis',
                'valeur_requise' => 1
            ],
            [
                'id' => 'maestro_filtrage',
                'nom' => 'Maestro du Filtrage 🔍',
                'description' => '15 recherches de talents avec filtres avancés',
                'message_marketing' => 'Vous maîtrisez la recherche comme personne.',
                'recompense' => 'Crédit de 5 talents à contacter',
                'icon' => 'fas fa-filter',
                'color' => 'primary',
                'category' => 'performance',
                'points' => 200,
                'criteres' => 'Effectuer 15 recherches avec filtres avancés',
                'valeur_requise' => 15
            ],
            [
                'id' => 'offre_etoile',
                'nom' => 'Offre Étoile 🌟',
                'description' => 'Une offre avec plus de 4 candidats en entretien',
                'message_marketing' => 'Votre offre attire les talents de demain !',
                'recompense' => 'Mise en avant "Top offre de la semaine"',
                'icon' => 'fas fa-star',
                'color' => 'warning',
                'category' => 'performance',
                'points' => 200,
                'criteres' => 'Avoir plus de 4 candidats en entretien pour une offre',
                'valeur_requise' => 4
            ],
            [
                'id' => 'equipe_complete',
                'nom' => 'Équipe Complète 🧑‍🤝‍🧑',
                'description' => '5 talents recrutés pour 5 offres différentes',
                'message_marketing' => 'Bravo, votre équipe prend vie.',
                'recompense' => 'Trophée digital + place dans le Hall of Fame',
                'icon' => 'fas fa-users',
                'color' => 'success',
                'category' => 'performance',
                'points' => 600,
                'criteres' => 'Recruter 5 talents pour 5 offres différentes',
                'valeur_requise' => 5
            ],
            
            // Badges Spéciaux
            [
                'id' => 'ambassadeur_yabara',
                'nom' => 'Ambassadeur YABARA 📣',
                'description' => '3 entreprises invitées inscrites',
                'message_marketing' => 'Vous contribuez à la croissance du réseau.',
                'recompense' => 'Abonnement offert ou remise facture',
                'icon' => 'fas fa-bullhorn',
                'color' => 'primary',
                'category' => 'special',
                'points' => 500,
                'criteres' => 'Inviter 3 entreprises qui s\'inscrivent',
                'valeur_requise' => 3
            ],
            [
                'id' => 'challenge_accepted',
                'nom' => 'Challenge Accepted 🧨',
                'description' => 'Participation à un défi YABARA',
                'message_marketing' => 'Vous relevez tous les défis RH !',
                'recompense' => 'Réduction abonnement 10%',
                'icon' => 'fas fa-fire',
                'color' => 'danger',
                'category' => 'special',
                'points' => 200,
                'criteres' => 'Participer à un défi YABARA',
                'valeur_requise' => 1
            ],
            [
                'id' => 'zero_candidature_oubliee',
                'nom' => '0 Candidature Oubliée 💌',
                'description' => 'Toutes les candidatures ouvertes traitées dans le mois',
                'message_marketing' => 'Rien ne vous échappe, bravo pour votre rigueur !',
                'recompense' => 'Statut "Premium Pro" temporaire',
                'icon' => 'fas fa-envelope-open',
                'color' => 'success',
                'category' => 'special',
                'points' => 300,
                'criteres' => 'Traiter toutes les candidatures du mois',
                'valeur_requise' => 100
            ],
            [
                'id' => 'feedbacker',
                'nom' => 'Feedbacker ⭐',
                'description' => 'Donne une note à 10 profils ou laisse un avis',
                'message_marketing' => 'Merci de contribuer à améliorer YABARA !',
                'recompense' => 'Points XP + badge collaboratif',
                'icon' => 'fas fa-star',
                'color' => 'warning',
                'category' => 'special',
                'points' => 150,
                'criteres' => 'Donner 10 notes ou avis',
                'valeur_requise' => 10
            ],
            [
                'id' => 'trophee_or',
                'nom' => 'Trophée d\'Or 🥇',
                'description' => '10 badges obtenus',
                'message_marketing' => 'Vous êtes un modèle de recrutement !',
                'recompense' => 'Visibilité maximale sur la plateforme',
                'icon' => 'fas fa-trophy',
                'color' => 'warning',
                'category' => 'special',
                'points' => 1000,
                'criteres' => 'Obtenir 10 badges',
                'valeur_requise' => 10
            ],
            [
                'id' => 'legend_rh',
                'nom' => 'Legend RH 👑',
                'description' => '15 badges obtenus',
                'message_marketing' => 'Votre légende s\'écrit ici. Recruteur modèle !',
                'recompense' => 'Statut élite + trophée animé dans le dashboard',
                'icon' => 'fas fa-crown',
                'color' => 'warning',
                'category' => 'special',
                'points' => 2000,
                'criteres' => 'Obtenir 15 badges',
                'valeur_requise' => 15
            ]
        ];
    }
    
    private function checkBadgeCondition($entreprise, $badgeId)
    {
        // Simuler les conditions pour la démonstration
        // Dans un vrai système, ces conditions seraient basées sur les vraies données
        $conditions = [
            'recruteur_express' => ($entreprise->total_recrutements_finalises ?? 0) >= 1,
            'chasseur_talents' => ($entreprise->candidatures()->count()) >= 5,
            'maitre_matching' => ($entreprise->candidatures()->count()) >= 10,
            'architecte_equipe' => ($entreprise->total_recrutements_finalises ?? 0) >= 5,
            'recruteur_eclair' => ($entreprise->total_recrutements_finalises ?? 0) >= 1,
            'star_mois' => false, // Nécessite une logique de classement
            'marathon_rh' => false, // Nécessite un suivi des connexions
            'serial_publisher' => ($entreprise->total_offres_publiees ?? 0) >= 10,
            'recruteur_nocturne' => false, // Nécessite un suivi des heures de connexion
            'explorateur_yabara' => false, // Nécessite un suivi des pages visitées
            'full_pack' => false, // Nécessite un suivi des fonctionnalités utilisées
            'boite_talents' => ($entreprise->candidatures()->count()) >= 20,
            'analyste_rh' => false, // Nécessite un suivi des consultations de rapports
            'reactif_pro' => false, // Nécessite un calcul de temps de réponse
            'offre_parfaite' => ($entreprise->total_offres_publiees ?? 0) >= 1,
            'maestro_filtrage' => false, // Nécessite un suivi des recherches
            'offre_etoile' => false, // Nécessite un suivi des entretiens
            'equipe_complete' => ($entreprise->total_recrutements_finalises ?? 0) >= 5,
            'ambassadeur_yabara' => false, // Nécessite un système de parrainage
            'challenge_accepted' => false, // Nécessite un système de défis
            'zero_candidature_oubliee' => false, // Nécessite un suivi des traitements
            'feedbacker' => false, // Nécessite un système de notation
            'trophee_or' => false, // Sera calculé dynamiquement
            'legend_rh' => false // Sera calculé dynamiquement
        ];
        
        return $conditions[$badgeId] ?? false;
    }
    
    private function calculateBadgeProgression($entreprise, $badgeId)
    {
        $progressions = [
            'recruteur_express' => min(100, (($entreprise->total_recrutements_finalises ?? 0) / 1) * 100),
            'chasseur_talents' => min(100, ($entreprise->candidatures()->count() / 5) * 100),
            'maitre_matching' => min(100, ($entreprise->candidatures()->count() / 10) * 100),
            'architecte_equipe' => min(100, (($entreprise->total_recrutements_finalises ?? 0) / 5) * 100),
            'recruteur_eclair' => min(100, (($entreprise->total_recrutements_finalises ?? 0) / 1) * 100),
            'star_mois' => 0,
            'marathon_rh' => 0,
            'serial_publisher' => min(100, (($entreprise->total_offres_publiees ?? 0) / 10) * 100),
            'recruteur_nocturne' => 0,
            'explorateur_yabara' => 0,
            'full_pack' => 0,
            'boite_talents' => min(100, ($entreprise->candidatures()->count() / 20) * 100),
            'analyste_rh' => 0,
            'reactif_pro' => 0,
            'offre_parfaite' => min(100, (($entreprise->total_offres_publiees ?? 0) / 1) * 100),
            'maestro_filtrage' => 0,
            'offre_etoile' => 0,
            'equipe_complete' => min(100, (($entreprise->total_recrutements_finalises ?? 0) / 5) * 100),
            'ambassadeur_yabara' => 0,
            'challenge_accepted' => 0,
            'zero_candidature_oubliee' => 0,
            'feedbacker' => 0,
            'trophee_or' => 0,
            'legend_rh' => 0
        ];
        
        return $progressions[$badgeId] ?? 0;
    }
    
    private function calculerNiveauEntreprise($entreprise)
    {
        // Calculer les points basés sur les badges obtenus
        $allBadges = $this->getAllBadgesDefinitions();
        $points = 0;
        
        foreach ($allBadges as $badge) {
            if ($this->checkBadgeCondition($entreprise, $badge['id'])) {
                $points += $badge['points'];
            }
        }
        
        if ($points >= 2000) return 'Légende';
        if ($points >= 1000) return 'Expert';
        if ($points >= 500) return 'Avancé';
        if ($points >= 200) return 'Intermédiaire';
        return 'Débutant';
    }
    
    private function verifierNouveauxBadges($entreprise)
    {
        $newBadges = [];
        $allBadges = $this->getAllBadgesDefinitions();
        
        foreach ($allBadges as $badge) {
            if ($this->checkBadgeCondition($entreprise, $badge['id'])) {
                $newBadges[] = $badge;
            }
        }
        
        return $newBadges;
    }

    // WF-E08: Profil Entreprise
    public function showProfile()
    {
        $entreprise = Auth::user()->entreprise;
        $poles = \App\Models\Pole::orderBy('nom')->get();
        
        return view('entreprise.profile', compact('entreprise', 'poles'));
    }

    public function updateProfile(Request $request)
    {
        $entreprise = Auth::user()->entreprise;
        
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'numero_legal' => 'nullable|string|max:50',
            'pole_activite_id' => 'required|exists:poles,id',
            'effectif' => 'nullable|in:<50,50-100,100-500,>500',
            'responsable_rh_prenom' => 'nullable|string|max:100',
            'responsable_rh_nom' => 'nullable|string|max:100',
            'responsable_rh_email' => 'nullable|email|max:255',
            'responsable_rh_telephone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_logo' => 'nullable|in:0,1'
        ]);
        
        $data = $request->only([
            'nom_entreprise',
            'numero_legal', 
            'pole_activite_id',
            'effectif',
            'responsable_rh_prenom',
            'responsable_rh_nom',
            'responsable_rh_email',
            'responsable_rh_telephone'
        ]);
        
        // Gestion du logo
        if ($request->has('remove_logo') && $request->remove_logo == '1') {
            // Supprimer l'ancien logo du stockage si il existe
            if ($entreprise->logo_url) {
                $oldLogoPath = str_replace('/storage/', '', $entreprise->logo_url);
                if (\Storage::disk('public')->exists($oldLogoPath)) {
                    \Storage::disk('public')->delete($oldLogoPath);
                }
            }
            $data['logo_url'] = null;
        } elseif ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si il existe
            if ($entreprise->logo_url) {
                $oldLogoPath = str_replace('/storage/', '', $entreprise->logo_url);
                if (\Storage::disk('public')->exists($oldLogoPath)) {
                    \Storage::disk('public')->delete($oldLogoPath);
                }
            }
            // Stocker le nouveau logo
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo_url'] = '/storage/' . $logoPath;
        }
        
        $entreprise->update($data);
        
        return redirect()->route('entreprise.profile.index')
                        ->with('success', 'Profil mis à jour avec succès!');
    }

    public function updateNotifications(Request $request)
    {
        $entreprise = Auth::user()->entreprise;
        
        $entreprise->update([
            'notif_nouvelle_candidature' => $request->has('notif_nouvelle_candidature'),
            'notif_deplacement_kanban' => $request->has('notif_deplacement_kanban')
        ]);
        
        return redirect()->route('entreprise.profile.index')
                        ->with('success', 'Paramètres de notification mis à jour!');
    }

    // WF-E07: Parrainage Entreprise
    public function showReferral()
    {
        $entreprise = Auth::user()->entreprise;
        
        // Récupérer les parrainages de l'entreprise
        $parrainages = $entreprise->parrainages()
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculer les statistiques
        $stats = [
            'total_invitations' => $parrainages->count(),
            'invitations_envoyees' => $parrainages->count(),
            'invitations_en_attente' => $parrainages->where('statut', 'en_attente')->count(),
            'inscriptions_reussies' => $parrainages->where('statut', 'accepte')->count(),
            'entreprises_actives' => $parrainages->where('statut', 'accepte')->count(),
            'points_gagnes' => $parrainages->where('statut', 'accepte')->sum('points_gagnes'),
            'recompenses_gagnees' => $parrainages->where('statut', 'accepte')->sum('montant_recompense'),
            'taux_conversion' => $parrainages->count() > 0 ? 
                round(($parrainages->where('statut', 'accepte')->count() / $parrainages->count()) * 100, 1) : 0
        ];
        
        // Code de parrainage de l'entreprise
        $code_parrainage = 'ENT' . str_pad($entreprise->id, 6, '0', STR_PAD_LEFT);
        
        return view('entreprise.parrainage', compact('parrainages', 'stats', 'code_parrainage'));
    }
    
    public function sendReferral(Request $request)
    {
        // Alias pour sendInvitation pour compatibilité
        return $this->sendInvitation($request);
    }
    
    public function renvoyerInvitation($parrainageId)
    {
        $entreprise = Auth::user()->entreprise;
        $parrainage = $entreprise->parrainages()->findOrFail($parrainageId);
        
        if ($parrainage->statut !== 'en_attente') {
            return response()->json([
                'success' => false,
                'message' => 'Cette invitation ne peut pas être renvoyée.'
            ], 422);
        }
        
        // Mettre à jour la date d'invitation
        $parrainage->update(['date_invitation' => now()]);
        
        // Renvoyer l'email
        $this->envoyerEmailInvitation($parrainage);
        
        return response()->json([
            'success' => true,
            'message' => 'Invitation renvoyée avec succès !'
        ]);
    }
    
    public function detailsParrainage($parrainageId)
    {
        $entreprise = Auth::user()->entreprise;
        $parrainage = $entreprise->parrainages()
            ->with('entrepriseParrainee')
            ->findOrFail($parrainageId);
            
        $html = view('entreprise.partials.parrainage-details', compact('parrainage'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
    
    // Méthode pour envoyer une invitation de parrainage
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'email_entreprise' => 'required|email',
            'nom_entreprise' => 'nullable|string|max:255',
            'message_personnel' => 'nullable|string|max:500'
        ]);
        
        $entreprise = Auth::user()->entreprise;
        
        // Vérifier si l'email n'est pas déjà invité
        $existingParrainage = Parrainage::where('email_entreprise', $request->email_entreprise)
            ->where('entreprise_parrain_id', $entreprise->id)
            ->first();
            
        if ($existingParrainage) {
            return response()->json([
                'success' => false,
                'message' => 'Cette entreprise a déjà été invitée.'
            ], 422);
        }
        
        // Créer le parrainage
        $parrainage = Parrainage::create([
            'entreprise_parrain_id' => $entreprise->id,
            'email_entreprise' => $request->email_entreprise,
            'nom_entreprise' => $request->nom_entreprise,
            'message_personnel' => $request->message_personnel,
            'code_parrainage' => 'PAR-' . strtoupper(Str::random(8)),
            'statut' => 'en_attente',
            'date_invitation' => now()
        ]);
        
        // Envoyer l'email d'invitation
        $this->envoyerEmailInvitation($parrainage);
        
        return response()->json([
            'success' => true,
            'message' => 'Invitation envoyée avec succès !',
            'parrainage' => $parrainage
        ]);
    }
    
    // API pour récupérer les offres de l'entreprise
    public function getMesOffres()
    {
        $entreprise = Auth::user()->entreprise;
        $offres = $entreprise->offresEmploi()
            ->where('statut', 'publiee')
            ->select('id', 'titre')
            ->get();
            
        return response()->json($offres);
    }

    // API pour récupérer les familles de métiers
    public function getFamillesMetiers($poleId)
    {
        try {
            // Vérifier que le pôle existe
            $pole = Pole::find($poleId);
            if (!$pole) {
                return response()->json([
                    'error' => 'Pôle non trouvé',
                    'message' => 'Le pôle spécifié n\'existe pas'
                ], 404);
            }

            // Récupérer les familles de métiers du pôle
            $familles = FamilleMetier::where('pole_id', $poleId)
                                     ->orderBy('nom')
                                     ->get(['id', 'nom', 'description']);

            // Log pour debug
            \Log::info('Familles métiers récupérées', [
                'pole_id' => $poleId,
                'count' => $familles->count(),
                'familles' => $familles->toArray()
            ]);

            return response()->json($familles);

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des familles de métiers', [
                'pole_id' => $poleId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Erreur serveur',
                'message' => 'Une erreur est survenue lors de la récupération des familles de métiers'
            ], 500);
        }
    }

    // Méthodes pour les actions des offres d'emploi
    
    /**
     * Afficher les détails d'une offre
     */
    public function showOffre($id)
    {
        $entreprise = Auth::user()->entreprise;
        $offre = $entreprise->offresEmploi()
            ->with(['typeContrat', 'pole', 'familleMetier', 'niveauDiplome', 'candidatures.talent.user'])
            ->findOrFail($id);
            
        return view('entreprise.offres.show', compact('offre'));
    }
    
    public function duplicateOffre($id)
{
    try {
        $entreprise = Auth::user()->entreprise;
        $offre = $entreprise->offresEmploi()->findOrFail($id);
        
        \Log::info('Début duplication offre', [
            'offre_id' => $id, 
            'entreprise_id' => $entreprise->id
        ]);
        
        // Utiliser une transaction pour s'assurer de la cohérence
        DB::beginTransaction();
        
        // Créer une copie de l'offre
        $nouvelleOffre = $offre->replicate();
        
        // Modifier les champs spécifiques
        $nouvelleOffre->titre = $offre->titre . ' (Copie)';
        $nouvelleOffre->statut = 'brouillon';
        $nouvelleOffre->date_publication = null;
        $nouvelleOffre->date_expiration = null;
        $nouvelleOffre->reference_offre = null; // Sera généré à la publication
        $nouvelleOffre->nb_recrutes = 0;
        $nouvelleOffre->nb_vues = 0;
        
        // Réinitialiser les timestamps
        $nouvelleOffre->created_at = now();
        $nouvelleOffre->updated_at = now();
        
        // Sauvegarder la nouvelle offre
        $nouvelleOffre->save();
        
        DB::commit();
        
        \Log::info('Duplication réussie', [
            'nouvelle_offre_id' => $nouvelleOffre->id,
            'titre' => $nouvelleOffre->titre
        ]);
        
        // Rediriger vers l'édition de la nouvelle offre (étape 1)
        return redirect()->route('entreprise.publish-job.step1', $nouvelleOffre->id)
            ->with('success', 'Offre dupliquée avec succès ! Vous pouvez maintenant la modifier.');
            
    } catch (\Exception $e) {
        DB::rollback();
        
        \Log::error('Erreur lors de la duplication', [
            'offre_id' => $id,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        
        return redirect()->back()
            ->with('error', 'Erreur lors de la duplication de l\'offre : ' . $e->getMessage());
    }
}

    /**
     * Changer le statut d'une offre (suspendre/activer)
     */
    public function toggleOffreStatus(Request $request, $id)
    {
        $entreprise = Auth::user()->entreprise;
        $offre = $entreprise->offresEmploi()->findOrFail($id);
        
        $action = $request->input('action', 'suspend');
        
        if ($action === 'suspend') {
            $offre->update(['statut' => 'suspendue']);
            $message = 'Offre suspendue avec succès.';
        } else {
            $offre->update(['statut' => 'publiee']);
            $message = 'Offre réactivée avec succès.';
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Supprimer une offre
     */
    public function deleteOffre($id)
    {
        $entreprise = Auth::user()->entreprise;
        $offre = $entreprise->offresEmploi()->findOrFail($id);
        
        // Vérifier s'il y a des candidatures
        if ($offre->candidatures()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une offre qui a reçu des candidatures.');
        }
        
        $offre->delete();
        
        return back()->with('success', 'Offre supprimée avec succès.');
    }
    
    /**
     * Afficher les candidatures d'une offre
     */
    public function showOffreCandidatures(Request $request, $id)
    {
        $entreprise = Auth::user()->entreprise;
        $offre = $entreprise->offresEmploi()->findOrFail($id);
        
        // Construire la requête des candidatures avec filtres
        $candidaturesQuery = $offre->candidatures()
            ->with(['talent.user', 'talent.niveauDiplome', 'talent.experiences'])
            ->orderBy('created_at', 'desc');
        
        // Filtrer par statut
        if ($request->filled('statut')) {
            $candidaturesQuery->where('statut_entreprise', $request->statut);
        }
        
        // Filtrer par date de début
        if ($request->filled('date_debut')) {
            $candidaturesQuery->whereDate('created_at', '>=', $request->date_debut);
        }
        
        // Filtrer par date de fin
        if ($request->filled('date_fin')) {
            $candidaturesQuery->whereDate('created_at', '<=', $request->date_fin);
        }
        
        // Filtrer par recherche (nom, prénom, email)
        if ($request->filled('recherche')) {
            $recherche = $request->recherche;
            $candidaturesQuery->whereHas('talent.user', function($query) use ($recherche) {
                $query->where('nom', 'like', '%' . $recherche . '%')
                      ->orWhere('prenom', 'like', '%' . $recherche . '%')
                      ->orWhere('email', 'like', '%' . $recherche . '%');
            });
        }
        
        // Paginer les résultats
        $candidatures = $candidaturesQuery->paginate(20)->appends($request->query());
        
        // Récupérer toutes les candidatures pour les statistiques (sans filtres)
        $toutesLesCandidatures = $offre->candidatures;
        
        return view('entreprise.offres.candidatures', compact('offre', 'candidatures', 'toutesLesCandidatures'));
    }
    
    /**
     * Afficher les statistiques détaillées d'une offre
     */
    public function showOffreStatistiques($id)
    {
        $entreprise = Auth::user()->entreprise;
        $offre = $entreprise->offresEmploi()
            ->with(['candidatures'])
            ->findOrFail($id);
            
        // Calculer les statistiques
        $statistiques = [
            'vues' => $offre->nb_vues ?? 0,
            'candidatures_total' => $offre->candidatures->count(),
            'candidatures_nouvelles' => $offre->candidatures->where('statut_entreprise', 'candidature_recue')->count(),
            'candidatures_retenues' => $offre->candidatures->where('statut_entreprise', 'retenue')->count(),
            'taux_conversion' => $offre->candidatures->count() > 0 ? 
                round(($offre->candidatures->where('statut_entreprise', 'retenue')->count() / $offre->candidatures->count()) * 100, 1) : 0,
            'par_statut' => [
                'candidature_recue' => $offre->candidatures->where('statut_entreprise', 'candidature_recue')->count(),
                'preselctionnee' => $offre->candidatures->where('statut_entreprise', 'preselctionnee')->count(),
                'entretien' => $offre->candidatures->where('statut_entreprise', 'entretien')->count(),
                'retenue' => $offre->candidatures->where('statut_entreprise', 'retenue')->count(),
                'refusee' => $offre->candidatures->where('statut_entreprise', 'refusee')->count()
            ]
        ];
        
        // Statistiques par période (30 derniers jours)
        $candidaturesParJour = $offre->candidatures
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(function($candidature) {
                return $candidature->created_at->format('Y-m-d');
            })
            ->map(function($group) {
                return $group->count();
            });
            
        return view('entreprise.offres.statistiques', compact('offre', 'statistiques', 'candidaturesParJour'));
    }

    // WF-E03: Affichage du profil d'un talent
    public function showTalentProfile($id)
    {
        $talent = Talent::with([
            'user',
            'pole',
            'familleMetier',
            'niveauDiplome',
            'experiencesProfessionnelles',
            'formations',
            'competences',
            'langues',
            'candidatures.offreEmploi'
        ])->findOrFail($id);
        
        return view('entreprise.talent-profile', compact('talent'));
    }
}
