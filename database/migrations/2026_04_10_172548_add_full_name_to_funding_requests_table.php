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
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->string('full_name', 240)->nullable()->after('id');
            $table->string('phone_prefix', 10)->nullable()->after('phone');
            $table->string('other_need_type', 500)->nullable()->after('need_type');
            $table->decimal('administrative_fees', 8, 2)->default(150.00)->after('amount_requested');
            
            // Supprimer les anciennes colonnes si elles existent
            $table->dropColumn(['first_name', 'last_name', 'birth_date', 'declare_analysis', 'declare_no_false']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'phone_prefix', 'other_need_type', 'administrative_fees']);
            // Rétablir les anciennes colonnes si nécessaire
            $table->string('first_name', 120)->nullable();
            $table->string('last_name', 120)->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('declare_analysis')->default(false);
            $table->boolean('declare_no_false')->default(false);
        });
    }
};
