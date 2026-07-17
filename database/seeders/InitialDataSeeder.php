<?php

namespace Database\Seeders;

use App\Models\CaseType;
use App\Models\Industry;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Industries
        $industries = [
            'Banking',
            'Marketing',
            'Human Resource',
            'Business',
            'Economy',
            'Education',
            'Environment',
            'Finance',
            'Government',
            'Health',
            'Management',
            'Sports',
            'Supply Chain',
            'Technology',
            'Transportation',
            'Other',
        ];

        foreach ($industries as $industry) {
            Industry::create([
                'name' => $industry,
                'slug' => Str::slug($industry),
            ]);
        }

        // Create Case Types
        $caseTypes = [
            'مدني',
            'جنائي',
            'تجاري',
            'أحوال شخصية',
            'عمالي',
            'إداري',
        ];

        foreach ($caseTypes as $caseType) {
            CaseType::create(['name' => $caseType]);
        }
    }
}
