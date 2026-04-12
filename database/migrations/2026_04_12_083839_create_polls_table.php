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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->text('description')->nullable();
            $table->string('slug')->unique()->index(); // datatype is varchar for better performance
            $table->unsignedTinyInteger('is_multichoice')->default(0);
            $table->timestamp('end_at')->nullable();
            $table->json('data')->nullable()->comment('store answer summary and other malicious data'); // implement DTO to ensure only verified data keys can store.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }
};
