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
        Schema::create('offres_emploi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->onDelete('cascade');
            $table->string('titre', 255);
            $table->text('descriptif');
            $table->foreignId('type_contrat_id')->nullable()->constrained('types_contrats')->onDelete('set null');
            $table->foreignId('pole_id')->nullable()->constrained('poles')->onDelete('set null');
            $table->foreignId('famille_metier_id')->nullable()->constrained('familles_metiers')->onDelete('set null');
            $table->string('niveau_diplome_requis', 50)->nullable();
            $table->integer('experience_minimum')->default(0);
            $table->decimal('remuneration', 10, 2)->nullable();
            $table->string('lieu_poste', 255)->nullable();
            $table->boolean('teletravail')->default(false);
            $table->boolean('mobilite_requise')->default(false);
            $table->enum('statut', ['brouillon', 'publiee', 'expiree', 'fermee'])->default('brouillon');
            $table->timestamp('date_publication')->nullable();
            $table->timestamp('date_expiration')->nullable();
            $table->string('reference_offre', 50)->unique()->nullable();
            $table->integer('nb_recrutes')->default(0);
            $table->integer('nb_vues')->default(0);
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['entreprise_id', 'statut']);
            $table->index(['statut', 'date_publication']);
            $table->index(['pole_id', 'famille_metier_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres_emploi');
    }
};