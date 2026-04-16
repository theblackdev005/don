<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->timestamp('donation_act_generated_at')->nullable()->after('donation_act_path');
        });
    }

    public function down(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->dropColumn('donation_act_generated_at');
        });
    }
};
