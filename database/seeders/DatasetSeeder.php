<?php

namespace Database\Seeders;

use App\Models\Dataset;
use App\Models\DatasetFile;
use App\Models\Industry;
use App\Models\Skill;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $users = User::all();
        $industries = Industry::all();
        $years = Year::all();
        $skills = Skill::all();

        // If no users exist, create one
        if ($users->isEmpty()) {
            $users = [
                User::factory()->create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => bcrypt('password')
                ])
            ];
        }

        // Create 5 sample datasets
        for ($i = 1; $i <= 5; $i++) {
            $dataset = Dataset::create([
                'name' => "Sample Dataset {$i}",
                'description' => "This is a sample dataset {$i} for testing purposes.",
                'user_id' => $users->random()->id,
                'author' => "Author {$i}",
                'industry_id' => $industries->random()->id,
                'year_id' => $years->random()->id,
                'size' => rand(1, 100), // Random size between 1-100 MB
                'source' => "Sample Source {$i}",
                'is_approved' => true,
                'approved_at' => now(),
                'approved_by' => $users->random()->id,
                'communications_opt_in' => rand(0, 1), // Random boolean
            ]);

            // Attach 1-3 random skills to the dataset
            $dataset->skills()->attach(
                $skills->random(rand(1, 3))->pluck('id')->toArray()
            );

            // Create 1-3 sample files for each dataset
            for ($j = 1; $j <= rand(1, 3); $j++) {
                // Create a dummy file path (no actual file is created)
                $filePath = "datasets/sample_file_{$i}_{$j}.csv";

                // Create the file record
                $dataset->files()->create([
                    'file_name' => "sample_file_{$j}.csv",
                    'file_path' => $filePath,
                    'file_type' => 'text/csv',
                    'file_size' => rand(100, 5000), // Random size in KB
                ]);
            }
        }
    }
}
