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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->string('responsable_rh_email')->nullable()->after('responsable_rh_prenom');
            $table->string('responsable_rh_telephone')->nullable()->after('responsable_rh_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn(['responsable_rh_email', 'responsable_rh_telephone']);
        });
    }
};
