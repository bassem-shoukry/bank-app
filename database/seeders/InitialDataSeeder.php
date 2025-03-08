<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\Industry;
use App\Models\Year;
use Illuminate\Support\Str;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Skills
        $skills = [
            'Data Visualization',
            'Text Analytics',
            'Machine Learning',
            'Statistical Analysis',
            'Other'
        ];

        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill,
                'slug' => Str::slug($skill)
            ]);
        }

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
            'Other'
        ];

        foreach ($industries as $industry) {
            Industry::create([
                'name' => $industry,
                'slug' => Str::slug($industry)
            ]);
        }

        // Create Years (from 2000 to current year)
        $currentYear = date('Y');
        for ($year = 2000; $year <= $currentYear; $year++) {
            Year::create(['year' => $year]);
        }
    }
}
