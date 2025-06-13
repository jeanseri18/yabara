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
        Schema::create('niveaux_diplomes', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->integer('niveau'); // Niveau numérique pour tri
            $table->string('description', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Insérer les niveaux de diplômes de base
        DB::table('niveaux_diplomes')->insert([
            ['nom' => 'Sans diplôme', 'niveau' => 0, 'description' => 'Aucun diplôme requis', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'CAP/BEP', 'niveau' => 1, 'description' => 'Certificat d\'Aptitude Professionnelle ou Brevet d\'Études Professionnelles', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC', 'niveau' => 2, 'description' => 'Baccalauréat', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+1', 'niveau' => 3, 'description' => 'Bac + 1 an', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+2', 'niveau' => 4, 'description' => 'BTS, DUT, DEUG', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+3', 'niveau' => 5, 'description' => 'Licence, Bachelor', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+4', 'niveau' => 6, 'description' => 'Maîtrise, Master 1', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+5', 'niveau' => 7, 'description' => 'Master, Ingénieur', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+6', 'niveau' => 8, 'description' => 'Mastère spécialisé', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nom' => 'BAC+8', 'niveau' => 9, 'description' => 'Doctorat, PhD', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveaux_diplomes');
    }
};