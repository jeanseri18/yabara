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
        Schema::create('talents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 20)->nullable();
            $table->foreignId('pole_id')->nullable()->constrained('poles')->onDelete('set null');
            $table->foreignId('famille_metier_id')->nullable()->constrained('familles_metiers')->onDelete('set null');
            $table->enum('niveau_etude', ['BAC', 'BAC+1', 'BAC+2', 'BAC+3', 'BAC+4', 'BAC+5', 'BAC+6', 'BAC+7', 'BAC+8'])->nullable();
            $table->string('cv_reference', 20)->unique();
            $table->decimal('profile_completion_percentage', 5, 2)->default(0.00);
            $table->string('parrain_cv_reference', 20)->nullable();
            $table->string('avatar_type', 50)->nullable();
            $table->integer('total_applications')->default(0);
            $table->integer('total_interviews')->default(0);
            $table->integer('total_offers_viewed')->default(0);
            $table->timestamps();
        });
        
        // Add the self-referencing foreign key constraint after table creation
        Schema::table('talents', function (Blueprint $table) {
            $table->foreign('parrain_cv_reference')->references('cv_reference')->on('talents')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talents');
    }
};
