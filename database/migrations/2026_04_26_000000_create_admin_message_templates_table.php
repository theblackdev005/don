<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 8);
            $table->string('key', 64);
            $table->string('subject', 255);
            $table->longText('body');
            $table->timestamps();

            $table->unique(['locale', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_message_templates');
    }
};
