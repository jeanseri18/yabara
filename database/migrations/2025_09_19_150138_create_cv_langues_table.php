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
        Schema::create('cv_langues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents')->onDelete('cascade');
            $table->string('nom');
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'natif'])->default('intermediaire');
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
        Schema::dropIfExists('cv_langues');
    }
};
