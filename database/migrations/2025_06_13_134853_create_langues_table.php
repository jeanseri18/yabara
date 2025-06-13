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
        Schema::create('langues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->string('langue', 100);
            $table->enum('niveau', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Natif']);
            $table->boolean('certifie')->default(false);
            $table->string('nom_certification', 255)->nullable();
            $table->date('date_certification')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('talent_id');
            $table->index(['talent_id', 'niveau']);
            $table->unique(['talent_id', 'langue']); // Un talent ne peut avoir qu'une seule entrée par langue
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langues');
    }
};
