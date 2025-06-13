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
        Schema::create('parrainages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parrain_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('filleul_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('date_parrainage');
            $table->enum('statut', ['en_attente', 'accepte', 'refuse', 'termine'])->default('en_attente');
            $table->text('message_parrain')->nullable();
            $table->text('message_filleul')->nullable();
            $table->integer('score_parrain')->nullable();
            $table->integer('score_filleul')->nullable();
            $table->text('commentaire_parrain')->nullable();
            $table->text('commentaire_filleul')->nullable();
            $table->timestamps();
            
            $table->unique(['parrain_id', 'filleul_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parrainages');
    }
};
