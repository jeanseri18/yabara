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
        Schema::create('competences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->string('nom_competence', 255);
            $table->enum('niveau', ['Débutant', 'Intermédiaire', 'Avancé', 'Expert']);
            $table->enum('type_competence', ['Technique', 'Linguistique', 'Soft Skills']);
            $table->boolean('certifie')->default(false);
            $table->string('nom_certification', 255)->nullable();
            $table->date('date_certification')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('talent_id');
            $table->index(['talent_id', 'type_competence']);
            $table->index('niveau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competences');
    }
};
