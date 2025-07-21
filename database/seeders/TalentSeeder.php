<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Talent;
use App\Models\Pole;
use App\Models\FamilleMetier;
use App\Models\NiveauDiplome;
use App\Models\ExperienceProfessionnelle;
use App\Models\Formation;

class TalentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les données de référence
        $poles = Pole::all();
        $niveauxDiplome = NiveauDiplome::all();
        
        // Données de test pour les talents
        $talents = [
            [
                'user' => [
                    'name' => 'Jean Dupont',
                    'email' => 'jean.dupont@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'talent',
                    'status' => 'active'
                ],
                'talent' => [
                    'first_name' => 'Jean',
                    'last_name' => 'Dupont',
                    'phone' => '+33123456789',
                    'pole_id' => 1, // Développement Digital
                    'famille_metier_id' => 1, // Développement Web
                    'niveau_diplome_id' => 6, // BAC+3
                    'cv_reference' => 'CV001',
                    'profile_completion_percentage' => 85.50,
                    'avatar_type' => 'default'
                ]
            ],
            [
                'user' => [
                    'name' => 'Sophie Martin',
                    'email' => 'sophie.martin@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'talent',
                    'status' => 'active'
                ],
                'talent' => [
                    'first_name' => 'Sophie',
                    'last_name' => 'Martin',
                    'phone' => '+33123456790',
                    'pole_id' => 1, // Développement Digital
                    'famille_metier_id' => 3, // UX/UI Design
                    'niveau_diplome_id' => 7, // BAC+5
                    'cv_reference' => 'CV002',
                    'profile_completion_percentage' => 92.75,
                    'avatar_type' => 'custom'
                ]
            ],
            [
                'user' => [
                    'name' => 'Aya Kouassi',
                    'email' => 'aya.kouassi@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'talent',
                    'status' => 'active'
                ],
                'talent' => [
                    'first_name' => 'Aya',
                    'last_name' => 'Kouassi',
                    'phone' => '+33123456791',
                    'pole_id' => 2, // Ingénierie & Industrie
                    'famille_metier_id' => 4, // Génie Civil
                    'niveau_diplome_id' => 8, // BAC+5
                    'cv_reference' => 'CV003',
                    'profile_completion_percentage' => 78.25,
                    'avatar_type' => 'default'
                ]
            ],
            [
                'user' => [
                    'name' => 'Ibrahim Traore',
                    'email' => 'ibrahim.traore@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'talent',
                    'status' => 'active'
                ],
                'talent' => [
                    'first_name' => 'Ibrahim',
                    'last_name' => 'Traore',
                    'phone' => '+33123456792',
                    'pole_id' => 3, // Gestion & Finance
                    'famille_metier_id' => 7, // Comptabilité
                    'niveau_diplome_id' => 6, // BAC+3
                    'cv_reference' => 'CV004',
                    'profile_completion_percentage' => 88.00,
                    'avatar_type' => 'default'
                ]
            ],
            [
                'user' => [
                    'name' => 'Fatou Bamba',
                    'email' => 'fatou.bamba@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'talent',
                    'status' => 'active'
                ],
                'talent' => [
                    'first_name' => 'Fatou',
                    'last_name' => 'Bamba',
                    'phone' => '+33123456793',
                    'pole_id' => 4, // Recherche & Innovation
                    'famille_metier_id' => 10, // Recherche & Développement
                    'niveau_diplome_id' => 9, // BAC+8
                    'cv_reference' => 'CV005',
                    'profile_completion_percentage' => 95.50,
                    'avatar_type' => 'custom'
                ]
            ]
        ];

        foreach ($talents as $talentData) {
            // Créer l'utilisateur
            $user = User::create($talentData['user']);
            
            // Créer le talent
            $talentData['talent']['user_id'] = $user->id;
            $talent = Talent::create($talentData['talent']);
            
            // Ajouter quelques expériences professionnelles
            $this->createExperiences($talent);
            
            // Ajouter quelques formations
            $this->createFormations($talent);
        }
        
        $this->command->info('5 talents créés avec succès!');
    }
    
    private function createExperiences(Talent $talent)
    {
        $experiences = [
            [
                'entreprise' => 'TechCorp',
                'poste' => 'Développeur Junior',
                'description' => 'Développement d\'applications web avec PHP et JavaScript',
                'date_debut' => '2022-01-15',
                'date_fin' => '2023-06-30',
                'est_poste_actuel' => false,
                'secteur_activite' => 'Informatique',
                'type_contrat' => 'CDD',
                'ville' => 'Abidjan',
                'pays' => 'Côte d\'Ivoire'
            ],
            [
                'entreprise' => 'InnovSoft',
                'poste' => 'Développeur Full Stack',
                'description' => 'Développement et maintenance d\'applications web complexes',
                'date_debut' => '2023-07-01',
                'date_fin' => null,
                'est_poste_actuel' => true,
                'secteur_activite' => 'Informatique',
                'type_contrat' => 'CDI',
                'ville' => 'Abidjan',
                'pays' => 'Côte d\'Ivoire'
            ]
        ];
        
        foreach ($experiences as $exp) {
            $exp['talent_id'] = $talent->id;
            ExperienceProfessionnelle::create($exp);
        }
    }
    
    private function createFormations(Talent $talent)
    {
        $formations = [
            [
                'etablissement' => 'Université Félix Houphouët-Boigny',
                'diplome' => 'Licence en Informatique',
                'domaine_etude' => 'Informatique et Systèmes',
                'niveau_diplome' => 'BAC+3',
                'date_debut' => '2019-09-01',
                'date_fin' => '2022-06-30',
                'mention' => 'Bien',
                'ville' => 'Abidjan',
                'pays' => 'Côte d\'Ivoire',
                'en_cours' => false,
                'description' => 'Formation complète en développement logiciel et systèmes informatiques'
            ]
        ];
        
        foreach ($formations as $formation) {
            $formation['talent_id'] = $talent->id;
            Formation::create($formation);
        }
    }
}