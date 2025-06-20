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
        // Modifier l'enum pour inclure 'suspendue'
        DB::statement("ALTER TABLE offres_emploi MODIFY COLUMN statut ENUM('brouillon', 'publiee', 'suspendue', 'expiree', 'fermee') DEFAULT 'brouillon'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre l'enum original (attention: cela supprimera les données avec statut 'suspendue')
        DB::statement("UPDATE offres_emploi SET statut = 'fermee' WHERE statut = 'suspendue'");
        DB::statement("ALTER TABLE offres_emploi MODIFY COLUMN statut ENUM('brouillon', 'publiee', 'expiree', 'fermee') DEFAULT 'brouillon'");
    }
};