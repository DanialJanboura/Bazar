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
        Schema::create('listing_images', function (Blueprint $table) {
            $table->id();

            // Reference the "listings" table
            $table->foreignId('listing_id')
                  ->constrained('listings')
                  ->onDelete('cascade');

            // Path or URL to the image
            $table->string('image_path');

            // Optional: You could store the position/sort order of the image
            $table->unsignedInteger('sort_order')->nullable();

            // Optional: Indicate whether this is the "main" image
            $table->boolean('is_primary')->default(FALSE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_images');
    }
};
