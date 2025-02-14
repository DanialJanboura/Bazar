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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete(); // or ->onDelete('cascade');

            // Same idea for category_id -> references 'categories' table
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete(); // or ->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description');
            $table->unsignedBigInteger('price');//price in SYP
            $table->enum('condition', ['new', 'used', 'refurbished'])->default('used');
            $table->string('location')->nullable();
            $table->enum('status', ['active', 'inactive', 'sold', 'pending'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
