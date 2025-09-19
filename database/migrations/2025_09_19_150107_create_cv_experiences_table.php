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
        Schema::create('cv_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->string('poste');
            $table->string('entreprise');
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->boolean('en_cours')->default(false);
            $table->text('description')->nullable();
            $table->integer('ordre')->default(0);
            $table->timestamps();
            
            $table->index(['talent_id', 'ordre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_experiences');
    }
};
