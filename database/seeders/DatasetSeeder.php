<?php

namespace Database\Seeders;

use App\Models\CaseType;
use App\Models\Dataset;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatasetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $users = collect([
                User::factory()->create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => bcrypt('password'),
                ]),
            ]);
        }

        $caseTypes = CaseType::all();

        Dataset::factory()
            ->count(5)
            ->create([
                'user_id' => fn () => $users->random()->id,
                'case_type_id' => fn () => $caseTypes->isNotEmpty() ? $caseTypes->random()->id : CaseType::factory(),
            ]);
    }
}
