<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('familles_metiers', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->text('description')->nullable();
            $table->foreignId('pole_id')->constrained('poles')->onDelete('cascade');
            $table->integer('ordre_affichage')->default(0);
            $table->timestamps();
        });

        // Insertion des familles de métiers correspondant au formulaire
        DB::table('familles_metiers')->insert([
            // Pôle 1: Développement Digital
            ['id' => 1, 'nom' => 'Développement Web', 'pole_id' => 1, 'ordre_affichage' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nom' => 'Développement Mobile', 'pole_id' => 1, 'ordre_affichage' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nom' => 'UX/UI Design', 'pole_id' => 1, 'ordre_affichage' => 3, 'created_at' => now(), 'updated_at' => now()],
            
            // Pôle 2: Ingénierie & Industrie
            ['id' => 4, 'nom' => 'Génie Civil', 'pole_id' => 2, 'ordre_affichage' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nom' => 'Mécanique', 'pole_id' => 2, 'ordre_affichage' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nom' => 'Électronique', 'pole_id' => 2, 'ordre_affichage' => 3, 'created_at' => now(), 'updated_at' => now()],
            
            // Pôle 3: Gestion & Finance
            ['id' => 7, 'nom' => 'Comptabilité', 'pole_id' => 3, 'ordre_affichage' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'nom' => 'Contrôle de Gestion', 'pole_id' => 3, 'ordre_affichage' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'nom' => 'Finance d\'Entreprise', 'pole_id' => 3, 'ordre_affichage' => 3, 'created_at' => now(), 'updated_at' => now()],
            
            // Pôle 4: Recherche & Innovation
            ['id' => 10, 'nom' => 'Biotechnologie', 'pole_id' => 4, 'ordre_affichage' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'nom' => 'Pharmacie', 'pole_id' => 4, 'ordre_affichage' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'nom' => 'IA & Data Science', 'pole_id' => 4, 'ordre_affichage' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('familles_metiers');
    }
};
