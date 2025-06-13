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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->string('etablissement', 255);
            $table->string('diplome', 255);
            $table->string('domaine_etude', 255)->nullable();
            $table->enum('niveau_diplome', ['BAC', 'BAC+1', 'BAC+2', 'BAC+3', 'BAC+4', 'BAC+5', 'BAC+6', 'BAC+7', 'BAC+8'])->nullable();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->string('mention', 50)->nullable(); // Passable, Assez bien, Bien, Très bien
            $table->string('ville', 100)->nullable();
            $table->string('pays', 100)->default('France');
            $table->boolean('en_cours')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('talent_id');
            $table->index(['talent_id', 'niveau_diplome']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
