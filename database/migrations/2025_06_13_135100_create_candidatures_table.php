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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->foreignId('offre_emploi_id')->constrained('offres_emploi')->onDelete('cascade');
            $table->enum('type', ['spontanee', 'reponse_offre'])->default('reponse_offre');
            $table->enum('statut_entreprise', ['candidature_recue', 'preselctionnee', 'entretien', 'retenue', 'refusee'])->default('candidature_recue');
            $table->enum('statut_talent', ['en_attente', 'acceptee', 'refusee', 'retiree'])->default('en_attente');
            $table->text('lettre_motivation')->nullable();
            $table->string('cv_url', 500)->nullable();
            $table->text('notes_entreprise')->nullable();
            $table->timestamp('date_entretien')->nullable();
            $table->text('feedback_entretien')->nullable();
            $table->decimal('salaire_propose', 10, 2)->nullable();
            $table->date('date_prise_poste')->nullable();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['talent_id', 'statut_talent']);
            $table->index(['offre_emploi_id', 'statut_entreprise']);
            $table->index(['type', 'created_at']);
            
            // Contrainte unique pour éviter les candidatures multiples
            $table->unique(['talent_id', 'offre_emploi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};