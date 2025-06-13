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
        Schema::create('types_contrats', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('description', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insérer les types de contrats de base
        DB::table('types_contrats')->insert([
            ['nom' => 'CDI', 'description' => 'Contrat à Durée Indéterminée', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'CDD', 'description' => 'Contrat à Durée Déterminée', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Stage', 'description' => 'Stage professionnel', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Freelance', 'description' => 'Travail indépendant', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Temps partiel', 'description' => 'Travail à temps partiel', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'Intérim', 'description' => 'Travail temporaire', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types_contrats');
    }
};