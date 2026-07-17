<?php

namespace Tests\Feature\Filament;

use App\Filament\Widgets\DashboardOverview;
use App\Models\Dataset;
use App\Models\Industry;
use App\Models\ParticipantType;
use App\Models\User;
use App\Models\Year;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardOverviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_accurate_record_counts(): void
    {
        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);

        $industry = Industry::create(['name' => 'Technology', 'slug' => 'technology']);
        $year = Year::create(['year' => 2026]);
        ParticipantType::create(['name' => 'Academic', 'is_active' => true]);

        Dataset::create([
            'name' => 'Test Dataset',
            'description' => 'A dataset used for testing.',
            'user_id' => $admin->id,
            'author' => $admin->name,
            'industry_id' => $industry->id,
            'year_id' => $year->id,
            'size' => 1.5,
            'source' => 'unit-test',
            'is_approved' => false,
            'communications_opt_in' => false,
        ]);

        Livewire::test(DashboardOverview::class)
            ->assertSee('Datasets')
            ->assertSee('Users')
            ->assertSee('Industries')
            ->assertSee('Participant Types')
            ->assertSee('1');
    }
}
