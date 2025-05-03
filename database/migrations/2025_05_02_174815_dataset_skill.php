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
        Schema::create('dataset_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dataset_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['dataset_id', 'skill_id']);
        });

        // Add communications_opt_in column to dataset table
        Schema::table('datasets', function (Blueprint $table) {
            $table->boolean('communications_opt_in')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dataset_skill');

        Schema::table('datasets', function (Blueprint $table) {
            $table->dropColumn('communications_opt_in');
        });
    }
};
