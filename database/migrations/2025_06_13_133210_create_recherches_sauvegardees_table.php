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
        Schema::create('recherches_sauvegardees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nom_recherche', 100);
            $table->enum('type_recherche', ['talents', 'offres', 'entreprises']);
            $table->json('criteres_recherche');
            $table->boolean('notifications_actives')->default(true);
            $table->timestamp('derniere_execution')->nullable();
            $table->integer('nombre_resultats')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'type_recherche']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recherches_sauvegardees');
    }
};
