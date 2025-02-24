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
        Schema::create('extra_fields', function (Blueprint $table) {
            $table->id();
            // Same idea for category_id -> references 'categories' table
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete(); // or ->onDelete('cascade');
            $table->string('name');
            $table->string('label');
            $table->string('field_type')->nullable(); // e.g., text, select, checkbox, etc.
            $table->json('options')->nullable(); // For dropdowns or multi-selects
            $table->string('notes')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_fields');
    }
};
