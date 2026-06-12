<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->json('name');                   // {"ar":"...", "en":"..."}
            $table->json('description');            // {"ar":"...", "en":"..."}
            $table->enum('category', ['beach', 'culture', 'adventure', 'heritage']);
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->json('meta_title')->nullable();
            $table->json('meta_desc')->nullable();
            $table->json('meta_keywords')->nullable();
            $table->timestamps();
        });

        Schema::table('trips', function (Blueprint $table) {
            $table->foreign('destination_id')->references('id')->on('destinations')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropForeign(['destination_id']);
        });

        Schema::dropIfExists('destinations');
    }
};
