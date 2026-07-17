<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('datasets', function (Blueprint $table): void {
            $table->foreignId('case_type_id')->nullable()->after('case_type')->constrained('case_types')->cascadeOnDelete();
        });

        DB::table('datasets')->whereNotNull('case_type')->distinct()->pluck('case_type')->each(function (string $name): void {
            $caseTypeId = DB::table('case_types')->where('name', $name)->value('id')
                ?? DB::table('case_types')->insertGetId([
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            DB::table('datasets')->where('case_type', $name)->update(['case_type_id' => $caseTypeId]);
        });

        Schema::table('datasets', function (Blueprint $table): void {
            $table->dropColumn('case_type');
        });

        Schema::table('datasets', function (Blueprint $table): void {
            $table->foreignId('case_type_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datasets', function (Blueprint $table): void {
            $table->string('case_type')->nullable()->after('case_type_id');
        });

        DB::table('datasets')->whereNotNull('case_type_id')->get(['id', 'case_type_id'])->each(function (object $dataset): void {
            $name = DB::table('case_types')->where('id', $dataset->case_type_id)->value('name');

            DB::table('datasets')->where('id', $dataset->id)->update(['case_type' => $name]);
        });

        Schema::table('datasets', function (Blueprint $table): void {
            $table->dropForeign(['case_type_id']);
            $table->dropColumn('case_type_id');
        });

        Schema::table('datasets', function (Blueprint $table): void {
            $table->string('case_type')->nullable(false)->change();
        });
    }
};
