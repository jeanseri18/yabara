<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('offres_emploi', function (Blueprint $table) {
            // Ajouter la colonne competences_recherchees
            $table->text('competences_recherchees')->nullable()->after('mobilite_requise');
            
            // Modifier experience_minimum pour accepter des chaînes comme '0-2', '3-5', etc.
            $table->string('experience_minimum', 10)->default('0-2')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres_emploi', function (Blueprint $table) {
            // Supprimer la colonne competences_recherchees
            $table->dropColumn('competences_recherchees');
            
            // Remettre experience_minimum en integer
            $table->integer('experience_minimum')->default(0)->change();
        });
    }
};
