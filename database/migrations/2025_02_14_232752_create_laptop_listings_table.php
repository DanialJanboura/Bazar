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
        Schema::create('laptop_listings', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->string('cpu');
            $table->unsignedInteger('ram');        // RAM in GB
            $table->unsignedInteger('storage');    // Storage in GB
            $table->string('gpu')->nullable();     // Optional: dedicated GPU model
            $table->string('screen_size')->nullable(); // e.g., "15.6 inch", optional
            $table->string('os')->nullable();      // Operating system, e.g., "Windows 10", optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptop_listings');
    }
};
