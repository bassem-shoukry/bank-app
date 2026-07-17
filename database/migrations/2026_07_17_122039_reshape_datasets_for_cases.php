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
        Schema::table('datasets', function (Blueprint $table): void {
            $table->dropForeign(['industry_id']);
            $table->dropForeign(['year_id']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'description',
                'author',
                'industry_id',
                'year_id',
                'size',
                'source',
                'is_approved',
                'approved_at',
                'approved_by',
                'communications_opt_in',
            ]);

            $table->string('national_id')->after('name');
            $table->text('address')->after('national_id');
            $table->string('case_number')->after('address');
            $table->string('case_type')->after('case_number');
            $table->text('verdict')->after('case_type');
            $table->string('payment_status')->default('unpaid')->after('verdict');
        });

        Schema::dropIfExists('dataset_skill');
        Schema::dropIfExists('dataset_files');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('dataset_files', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('dataset_id')->constrained()->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->timestamps();
        });

        Schema::create('dataset_skill', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('dataset_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['dataset_id', 'skill_id']);
        });

        Schema::table('datasets', function (Blueprint $table): void {
            $table->dropColumn([
                'national_id',
                'address',
                'case_number',
                'case_type',
                'verdict',
                'payment_status',
            ]);

            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->foreignId('industry_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('year_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('size', 10, 2)->nullable()->comment('Size in MB');
            $table->string('source')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->boolean('communications_opt_in')->default(false);
        });
    }
};
