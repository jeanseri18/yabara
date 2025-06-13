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
        Schema::create('poles', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('icone', 50);
            $table->integer('ordre_affichage');
            $table->timestamps();
        });

        // Insertion des données par défaut correspondant au formulaire
        DB::table('poles')->insert([
            ['id' => 1, 'nom' => 'Développement Digital', 'icone' => '📱', 'ordre_affichage' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nom' => 'Ingénierie & Industrie', 'icone' => '🏗️', 'ordre_affichage' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nom' => 'Gestion & Finance', 'icone' => '💼', 'ordre_affichage' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nom' => 'Recherche & Innovation', 'icone' => '🔬', 'ordre_affichage' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poles');
    }
};
