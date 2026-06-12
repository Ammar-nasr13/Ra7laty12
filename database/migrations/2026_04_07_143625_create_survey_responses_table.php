<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->enum('budget', ['low', 'medium', 'high', 'luxury']);
            $table->enum('travel_type', ['family', 'couple', 'solo', 'friends']);
            $table->enum('preferred_climate', ['beach', 'desert', 'mountain', 'city']);
            $table->enum('duration_preference', ['weekend', 'week', 'twoweeks', 'month']);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
