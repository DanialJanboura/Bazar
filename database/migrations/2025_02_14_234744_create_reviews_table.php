<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Which listing is being reviewed?
            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->onDelete('cascade');

            // Which user wrote the review?
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // The rating, e.g., 1-5
            $table->unsignedTinyInteger('rating')->comment('1 to 5');

            // Optional written feedback
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
