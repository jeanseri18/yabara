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
        Schema::table('parrainages', function (Blueprint $table) {
            $table->foreignId('entreprise_parrain_id')->nullable()->constrained('entreprises')->onDelete('cascade');
            $table->foreignId('talent_parrain_id')->nullable()->constrained('talents')->onDelete('cascade');
            $table->string('email_entreprise')->nullable();
            $table->string('nom_entreprise')->nullable();
            $table->text('message_personnel')->nullable();
            $table->string('code_parrainage')->unique()->nullable();
            $table->timestamp('date_invitation')->nullable();
            $table->timestamp('date_inscription')->nullable();
            $table->foreignId('entreprise_parrainee_id')->nullable()->constrained('entreprises')->onDelete('cascade');
            $table->foreignId('talent_parraine_id')->nullable()->constrained('talents')->onDelete('cascade');
            $table->boolean('recompense_accordee')->default(false);
            $table->decimal('montant_recompense', 8, 2)->nullable();
            $table->timestamp('date_recompense')->nullable();
            $table->enum('parrain_type', ['entreprise', 'talent'])->nullable();
            $table->string('ip_invitation')->nullable();
            $table->text('user_agent_invitation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parrainages', function (Blueprint $table) {
            $table->dropForeign(['entreprise_parrain_id']);
            $table->dropForeign(['talent_parrain_id']);
            $table->dropForeign(['entreprise_parrainee_id']);
            $table->dropForeign(['talent_parraine_id']);
            $table->dropColumn([
                'entreprise_parrain_id',
                'talent_parrain_id',
                'email_entreprise',
                'nom_entreprise',
                'message_personnel',
                'code_parrainage',
                'date_invitation',
                'date_inscription',
                'entreprise_parrainee_id',
                'talent_parraine_id',
                'recompense_accordee',
                'montant_recompense',
                'date_recompense',
                'parrain_type',
                'ip_invitation',
                'user_agent_invitation'
            ]);
        });
    }
};
