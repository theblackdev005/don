<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('funding_request_financial_changes')) {
            return;
        }

        Schema::create('funding_request_financial_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funding_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('field', 64);
            $table->string('action', 32);
            $table->decimal('old_amount', 12, 2)->nullable();
            $table->decimal('new_amount', 12, 2);
            $table->decimal('delta_amount', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['funding_request_id', 'created_at'], 'fr_fin_changes_request_created_idx');
            $table->index(['field', 'created_at'], 'fr_fin_changes_field_created_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funding_request_financial_changes');
    }
};
