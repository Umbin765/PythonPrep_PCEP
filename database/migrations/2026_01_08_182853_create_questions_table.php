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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('topic')->default('basics');
            $table->string('difficulty')->default('easy');
            $table->text('prompt');
            $table->json('choices');
            $table->unsignedTinyInteger('correct_index')->default(0);
            $table->text('explanation')->nullable();
            $table->text('tip')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
