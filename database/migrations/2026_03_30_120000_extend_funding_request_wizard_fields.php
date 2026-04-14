<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->text('address')->nullable()->after('birth_date');
            $table->string('current_situation', 32)->nullable()->after('address');
            $table->string('monthly_income_approx', 120)->nullable()->after('current_situation');
            $table->string('family_situation', 32)->nullable()->after('monthly_income_approx');
            $table->string('need_type', 40)->nullable()->after('family_situation');
            $table->boolean('previous_aid_received')->nullable()->after('need_type');
            $table->text('previous_aid_details')->nullable()->after('previous_aid_received');
            $table->string('preferred_timeline', 32)->nullable()->after('previous_aid_details');
            $table->string('doc_id_path')->nullable()->after('preferred_timeline');
            $table->string('doc_situation_path')->nullable()->after('doc_id_path');
            $table->string('doc_medical_path')->nullable()->after('doc_situation_path');
            $table->boolean('declare_accurate')->default(false)->after('doc_medical_path');
            $table->boolean('declare_analysis')->default(false)->after('declare_accurate');
            $table->boolean('declare_no_false')->default(false)->after('declare_analysis');
        });
    }

    public function down(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'current_situation',
                'monthly_income_approx',
                'family_situation',
                'need_type',
                'previous_aid_received',
                'previous_aid_details',
                'preferred_timeline',
                'doc_id_path',
                'doc_situation_path',
                'doc_medical_path',
                'declare_accurate',
                'declare_analysis',
                'declare_no_false',
            ]);
        });
    }
};
