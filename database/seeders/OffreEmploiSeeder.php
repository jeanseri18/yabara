<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\OffreEmploi;
use App\Models\Pole;
use App\Models\FamilleMetier;
use App\Models\NiveauDiplome;
use App\Models\TypeContrat;

class OffreEmploiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur entreprise de test
        $userEntreprise = User::firstOrCreate(
            ['email' => 'entreprise@example.com'],
            [
                'name' => 'Entreprise Test',
                'password' => Hash::make('password'),
                'user_type' => 'entreprise',
                'email_verified_at' => now(),
            ]
        );

        // Créer une entreprise de test
        $entreprise = Entreprise::firstOrCreate(
            ['user_id' => $userEntreprise->id],
            [
                'nom_entreprise' => 'TechCorp Solutions',
                'pole_activite_id' => Pole::first()->id ?? 1,
                'numero_legal' => '12345678901234',
                'effectif' => '50-100',
                'responsable_rh_nom' => 'Martin',
                'responsable_rh_prenom' => 'Sophie',
                'responsable_rh_email' => 'sophie.martin@techcorp.com',
                'responsable_rh_telephone' => '0123456789',
                'is_verified' => true,
            ]
        );

        // Récupérer les données de référence
        $poles = Pole::all();
        $famillesMetiers = FamilleMetier::all();
        $niveauxDiplomes = NiveauDiplome::all();
        
        // Créer des types de contrats s'ils n'existent pas
        $typesCDI = TypeContrat::firstOrCreate(['nom' => 'CDI']);
        $typesCDD = TypeContrat::firstOrCreate(['nom' => 'CDD']);
        $typesStage = TypeContrat::firstOrCreate(['nom' => 'Stage']);

        // Créer des offres d'emploi de test
        $offres = [
            [
                'titre' => 'Développeur Full Stack Senior',
                'descriptif' => 'Nous recherchons un développeur full stack expérimenté pour rejoindre notre équipe technique. Vous travaillerez sur des projets innovants utilisant les dernières technologies.',
                'lieu_poste' => 'Paris',
                'remuneration' => 55000,
                'type_contrat_id' => $typesCDI->id,
                'niveau_diplome_requis' => 'Bac+5',
                'famille_metier_id' => $famillesMetiers->where('nom', 'LIKE', '%Informatique%')->first()->id ?? $famillesMetiers->first()->id,
                'experience_minimum' => 3,
            ],
            [
                'titre' => 'Chef de Projet Digital',
                'descriptif' => 'Poste de chef de projet pour piloter nos projets de transformation digitale. Expérience en gestion de projet et connaissance des méthodologies agiles requises.',
                'lieu_poste' => 'Lyon',
                'remuneration' => 47500,
                'type_contrat_id' => $typesCDI->id,
                'niveau_diplome_requis' => 'Bac+3',
                'famille_metier_id' => $famillesMetiers->skip(1)->first()->id ?? $famillesMetiers->first()->id,
                'experience_minimum' => 2,
            ],
            [
                'titre' => 'Analyste Data Junior',
                'descriptif' => 'Rejoignez notre équipe data pour analyser et valoriser nos données. Formation en statistiques ou informatique appréciée.',
                'lieu_poste' => 'Toulouse',
                'remuneration' => 37000,
                'type_contrat_id' => $typesCDD->id,
                'niveau_diplome_requis' => 'Bac+3',
                'famille_metier_id' => $famillesMetiers->first()->id,
                'experience_minimum' => 1,
            ],
            [
                'titre' => 'Consultant en Transformation Digitale',
                'descriptif' => 'Accompagnez nos clients dans leur transformation digitale. Missions variées et environnement stimulant.',
                'lieu_poste' => 'Marseille',
                'remuneration' => 44000,
                'type_contrat_id' => $typesCDI->id,
                'niveau_diplome_requis' => 'Bac+5',
                'famille_metier_id' => $famillesMetiers->skip(2)->first()->id ?? $famillesMetiers->first()->id,
                'experience_minimum' => 2,
            ]
        ];

        foreach ($offres as $offreData) {
            OffreEmploi::create(array_merge($offreData, [
                'entreprise_id' => $entreprise->id,
                'pole_id' => $poles->random()->id,
                'statut' => 'publiee',
                'date_publication' => now(),
                'reference_offre' => 'REF-' . strtoupper(uniqid()),
                'teletravail' => rand(0, 1),
                'mobilite_requise' => rand(0, 1),
                'nb_recrutes' => 1,
                'nb_vues' => rand(10, 100),
            ]));
        }

        $this->command->info('Offres d\'emploi de test créées avec succès!');
    }
}