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
        Schema::create('experiences_professionnelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->string('entreprise', 255);
            $table->string('poste', 255);
            $table->text('description')->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->boolean('est_poste_actuel')->default(false);
            $table->string('secteur_activite', 100)->nullable();
            $table->enum('type_contrat', ['CDI', 'CDD', 'Stage', 'Freelance', 'Alternance'])->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('pays', 100)->default('France');
            $table->timestamps();
            
            $table->index('talent_id');
            $table->index(['talent_id', 'date_debut']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences_professionnelles');
    }
};
