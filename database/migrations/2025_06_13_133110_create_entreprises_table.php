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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nom_entreprise', 255);
            $table->string('logo_url', 500)->nullable();
            $table->foreignId('pole_activite_id')->nullable()->constrained('poles')->onDelete('set null');
            $table->string('numero_legal', 100)->nullable(); // SIREN/SIRET/RCCM
            $table->enum('effectif', ['<50', '50-100', '100-500', '>500'])->nullable();
            $table->string('responsable_rh_nom')->nullable();
            $table->string('responsable_rh_prenom')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->integer('total_offres_publiees')->default(0);
            $table->integer('total_candidatures_recues')->default(0);
            $table->boolean('notif_nouvelle_candidature')->default(true);
            $table->boolean('notif_deplacement_kanban')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
