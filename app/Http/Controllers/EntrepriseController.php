<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            'experience_minimum' => 'required|integer|min:0',
            'remuneration' => 'nullable|numeric',
            'lieu_poste' => 'required|string|max:255',
            'teletravail' => 'boolean',
            'mobilite_requise' => 'boolean'
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

    // WF-E03: Recherche de Talents
    public function showTalentSearch()
    {
        $poles = Pole::all();
        $niveauxDiplome = NiveauDiplome::all();
        
        return view('entreprise.talent-search', compact('poles', 'niveauxDiplome'));
    }

    public function searchTalents(Request $request)
    {
        $query = Talent::with(['pole', 'familleMetier'])
            ->whereHas('user', function($q) {
                $q->where('is_active', 1);
            });

        if ($request->pole_id) {
            $query->where('pole_id', $request->pole_id);
        }
        
        if ($request->famille_metier_id) {
            $query->where('famille_metier_id', $request->famille_metier_id);
        }
        
        if ($request->experience_min) {
            // Logique pour filtrer par expérience
        }
        
        if ($request->niveau_diplome) {
            $query->where('niveau_etude', $request->niveau_diplome);
        }

        $talents = $query->paginate(12);
        
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
            'type' => 'liee_entreprise',
            'statut_entreprise' => 'candidature_recue',
            'statut_talent' => 'en_attente'
        ]);

        return response()->json(['success' => true, 'message' => 'Talent lié à l\'offre avec succès']);
    }

    // WF-E04: Suivi Candidatures KANBAN
    public function showKanban()
    {
        $entreprise = Auth::user()->entreprise;
        
        $candidatures = Candidature::with(['talent.user', 'offreEmploi'])
            ->whereHas('offreEmploi', function($q) use ($entreprise) {
                $q->where('entreprise_id', $entreprise->id);
            })
            ->get()
            ->groupBy('statut_entreprise');

        // Statistiques pour le kanban
        $stats = [
            'candidatures_recues' => $candidatures->get('candidature_recue', collect())->count(),
            'preselections' => $candidatures->get('preselctionnee', collect())->count(),
            'entretiens' => $candidatures->get('entretien', collect())->count(),
            'recrutes' => $candidatures->get('retenue', collect())->count()
        ];

        // Offres pour le filtre
        $offres = $entreprise->offresEmploi()->where('statut', 'publiee')->get();
        
        // Familles métiers pour le filtre
        $famillesMetiers = FamilleMetier::all();

        return view('entreprise.candidatures-kanban', compact('candidatures', 'stats', 'offres', 'famillesMetiers'));
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
        
        return [
            'offres_publiees' => $offresPubliees,
            'offres_actives' => $offresActives,
            'vues_offres' => $vuesOffres,
            'candidatures_recues' => $candidaturesRecues,
            'entretiens_programmes' => $entretiensProgrammes,
            'recrutements_finalises' => $recrutementsFinales,
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
            'evolution_labels' => $labels,
            'evolution_offres' => $evolutionOffres,
            'evolution_candidatures' => $evolutionCandidatures,
            'evolution_recrutements' => $evolutionRecrutements
        ];
    }
    
    private function getRepartitionCandidatures($entreprise, $periode)
    {
        $dateDebut = $this->getDateDebut($periode);
        
        return [
            'recues' => $entreprise->candidatures()
                ->where('statut_entreprise', 'candidature_recue')
                ->when($dateDebut, fn($q) => $q->where('candidatures.created_at', '>=', $dateDebut))
                ->count(),
            'preselectionnees' => $entreprise->candidatures()
                ->where('statut_entreprise', 'preselctionnee')
                ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
                ->count(),
            'entretien' => $entreprise->candidatures()
                ->where('statut_entreprise', 'entretien')
                ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
                ->count(),
            'retenues' => $entreprise->candidatures()
                ->where('statut_entreprise', 'retenue')
                ->when($dateDebut, fn($q) => $q->where('candidatures.updated_at', '>=', $dateDebut))
                ->count()
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
            ->with(['talent.user', 'offreEmploi.familleMetier'])
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
            ->with(['talent.user', 'talent.experiencesProfessionnelles', 'talent.formations', 'offreEmploi'])
            ->findOrFail($candidatureId);
            
        $html = view('entreprise.partials.candidature-details', compact('candidature'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
    
    // WF-E06: Badges Entreprise
    public function showBadges()
    {
        $entreprise = Auth::user()->entreprise;
        
        // Récupérer les badges de l'entreprise
        $badges = $entreprise->badges()->with('badge')->get();
        
        // Calculer les statistiques pour les badges
        $totalBadgesDisponibles = \App\Models\Badge::count();
        $pourcentageCompletion = $totalBadgesDisponibles > 0 ? ($badges->count() / $totalBadgesDisponibles) * 100 : 0;
        
        $stats = [
            'total_badges' => $badges->count(),
            'badges_obtenus' => $badges->count(),
            'badges_recents' => $badges->where('created_at', '>=', now()->subDays(30))->count(),
            'points_total' => $badges->sum('points_gagnes'),
            'niveau_actuel' => $this->calculerNiveauEntreprise($entreprise),
            'niveau_entreprise' => $this->calculerNiveauEntreprise($entreprise),
            'pourcentage_completion' => $pourcentageCompletion,
            'credits_disponibles' => $badges->sum('points_gagnes'), // Credits based on total points earned
            'reduction_max' => min(50, floor($badges->sum('points_gagnes') / 100) * 5) // Max 50% reduction based on points
        ];
        
        // Badges disponibles à débloquer
        $badgesDisponibles = \App\Models\Badge::whereNotIn('id', $badges->pluck('badge_id'))->get();
        
        // Prochains objectifs à atteindre
        $prochains_objectifs = [
            [
                'nom' => 'Première offre publiée',
                'icon' => 'fas fa-briefcase',
                'color' => 'primary',
                'valeur_actuelle' => $entreprise->total_offres_publiees ?? 0,
                'valeur_requise' => 1,
                'progression' => min(100, (($entreprise->total_offres_publiees ?? 0) / 1) * 100)
            ],
            [
                'nom' => '5 candidatures reçues',
                'icon' => 'fas fa-users',
                'color' => 'success',
                'valeur_actuelle' => $entreprise->candidatures()->count(),
                'valeur_requise' => 5,
                'progression' => min(100, ($entreprise->candidatures()->count() / 5) * 100)
            ],
            [
                'nom' => 'Premier recrutement',
                'icon' => 'fas fa-handshake',
                'color' => 'warning',
                'valeur_actuelle' => $entreprise->total_recrutements_finalises ?? 0,
                'valeur_requise' => 1,
                'progression' => min(100, (($entreprise->total_recrutements_finalises ?? 0) / 1) * 100)
            ]
        ];
        
        return view('entreprise.badges', compact('badges', 'stats', 'badgesDisponibles', 'prochains_objectifs'));
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
    
    private function calculerNiveauEntreprise($entreprise)
    {
        $points = $entreprise->badges()->sum('points_gagnes');
        
        if ($points >= 1000) return 'Expert';
        if ($points >= 500) return 'Avancé';
        if ($points >= 200) return 'Intermédiaire';
        return 'Débutant';
    }
    
    private function verifierNouveauxBadges($entreprise)
    {
        $newBadges = [];
        
        // Vérifier badge "Première offre publiée"
        if ($entreprise->total_offres_publiees >= 1 && !$entreprise->badges()->where('badge_id', 1)->exists()) {
            $newBadges[] = ['id' => 1, 'nom' => 'Première offre', 'description' => 'Votre première offre publiée'];
        }
        
        // Vérifier badge "Recruteur actif" (5 offres)
        if ($entreprise->total_offres_publiees >= 5 && !$entreprise->badges()->where('badge_id', 2)->exists()) {
            $newBadges[] = ['id' => 2, 'nom' => 'Recruteur actif', 'description' => '5 offres publiées'];
        }
        
        // Vérifier badge "Premier recrutement"
        if ($entreprise->total_recrutements_finalises >= 1 && !$entreprise->badges()->where('badge_id', 3)->exists()) {
            $newBadges[] = ['id' => 3, 'nom' => 'Premier recrutement', 'description' => 'Votre premier recrutement finalisé'];
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
            'effectif' => 'nullable|in:1-10,11-50,51-200,201-500,500+',
            'responsable_rh_prenom' => 'nullable|string|max:100',
            'responsable_rh_nom' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->only([
            'nom_entreprise',
            'numero_legal', 
            'pole_activite_id',
            'effectif',
            'responsable_rh_prenom',
            'responsable_rh_nom'
        ]);
        
        // Gestion du logo
        if ($request->hasFile('logo')) {
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
            ->with(['talent.user', 'talent.experiences'])
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
}
