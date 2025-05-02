<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participant_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->constrained();
            $table->foreignId('participant_type_id')->nullable()->constrained();
            $table->foreignId('industry_id')->nullable()->constrained();
            $table->string('institution')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['participant_type_id']);
            $table->dropForeign(['industry_id']);
            $table->dropColumn(['country_id', 'city_id', 'participant_type_id', 'industry_id', 'institution']);
        });

        Schema::dropIfExists('industries');
        Schema::dropIfExists('participant_types');
    }
};
