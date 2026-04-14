<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('funding_requests', 'nationality')) {
            Schema::table('funding_requests', function (Blueprint $table) {
                $table->dropColumn('nationality');
            });
        }
    }

    public function down(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->string('nationality', 120)->nullable()->after('birth_date');
        });
    }
};
