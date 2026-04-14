<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->string('identity_document_type', 24)->nullable()->after('preferred_timeline');
            $table->string('doc_passport_path')->nullable()->after('identity_document_type');
            $table->string('doc_id_front_path')->nullable()->after('doc_passport_path');
            $table->string('doc_id_back_path')->nullable()->after('doc_id_front_path');
        });
    }

    public function down(): void
    {
        Schema::table('funding_requests', function (Blueprint $table) {
            $table->dropColumn([
                'identity_document_type',
                'doc_passport_path',
                'doc_id_front_path',
                'doc_id_back_path',
            ]);
        });
    }
};
