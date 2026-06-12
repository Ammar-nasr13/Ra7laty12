<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->json('title');                          // {"ar":"...", "en":"..."}
            $table->json('desc');                           // {"ar":"...", "en":"..."}
            $table->json('highlights');                     // {"ar":[...], "en":[...]}
            $table->json('highlight_images')->nullable();
            $table->json('included')->nullable();           // {"ar":[...],"en":[...]}
            $table->json('excluded')->nullable();           // {"ar":[...],"en":[...]}
            $table->json('itinerary')->nullable();          // {"ar":[...],"en":[...]}
            $table->unsignedBigInteger('destination_id')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 5)->default('$');
            $table->unsignedTinyInteger('duration');        // days
            $table->enum('category', ['beach', 'culture', 'adventure']);
            $table->enum('climate', ['beach', 'desert', 'mountain', 'city']);
            $table->json('travel_type');                    // ["family","couple","solo","friends"]
            $table->enum('budget_tier', ['low', 'medium', 'high', 'luxury']);
            $table->string('color_from', 10)->default('#C5A028');
            $table->string('color_to', 10)->default('#1A3A5C');
            $table->boolean('is_egyptian')->default(false);
            $table->unsignedSmallInteger('spots_total')->default(20);
            $table->unsignedSmallInteger('spots_left')->default(20);
            $table->json('departure_dates')->nullable();    // ["2026-04-20", ...]
            $table->boolean('is_active')->default(true);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->json('meta_title')->nullable();
            $table->json('meta_desc')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
