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
        Schema::create('email_queue', function (Blueprint $table) {
            $table->id();
            $table->string('destinataire_email', 255);
            $table->string('destinataire_nom', 100)->nullable();
            $table->string('sujet', 255);
            $table->text('corps_email');
            $table->string('template', 100)->nullable();
            $table->json('variables')->nullable();
            $table->enum('statut', ['en_attente', 'envoye', 'echec', 'annule'])->default('en_attente');
            $table->timestamp('date_envoi')->nullable();
            $table->integer('tentatives')->default(0);
            $table->text('erreur_message')->nullable();
            $table->enum('priorite', ['basse', 'normale', 'haute'])->default('normale');
            $table->timestamps();
            
            $table->index(['statut', 'priorite']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_queue');
    }
};
