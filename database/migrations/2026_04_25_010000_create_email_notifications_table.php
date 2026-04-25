<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('email_notifications')) {
            return;
        }

        Schema::create('email_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funding_request_id')->nullable()->constrained()->nullOnDelete();
            $table->string('recipient_email', 191);
            $table->string('recipient_type', 32)->default('applicant');
            $table->string('mailable_class');
            $table->string('subject')->nullable();
            $table->string('locale', 8)->default('fr');
            $table->string('status', 24)->default('pending');
            $table->unsignedInteger('attempts')->default(0);
            $table->text('last_error')->nullable();
            $table->timestamp('last_attempt_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['funding_request_id', 'created_at'], 'email_notifications_request_created_idx');
            $table->index(['recipient_email', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_notifications');
    }
};
