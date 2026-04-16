<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('testimonial_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testimonial_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('author_name');
            $table->string('role')->nullable();
            $table->text('quote');

            $table->unique(['testimonial_id', 'locale']);
        });

        $defaultLocale = (string) config('locales.default', 'fr');

        DB::table('testimonials')
            ->select(['id', 'author_name', 'role', 'quote'])
            ->orderBy('id')
            ->get()
            ->each(function (object $testimonial) use ($defaultLocale): void {
                DB::table('testimonial_translations')->insert([
                    'testimonial_id' => $testimonial->id,
                    'locale' => $defaultLocale,
                    'author_name' => (string) $testimonial->author_name,
                    'role' => $testimonial->role !== null ? (string) $testimonial->role : null,
                    'quote' => (string) $testimonial->quote,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_translations');
    }
};
