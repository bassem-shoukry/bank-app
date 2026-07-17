<?php

namespace Tests\Feature\Filament;

use App\Enums\PaymentStatus;
use App\Filament\Widgets\DashboardOverview;
use App\Models\CaseType;
use App\Models\Dataset;
use App\Models\User;
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

        $caseType = CaseType::factory()->create(['name' => 'مدني']);

        Dataset::create([
            'name' => 'Test Case',
            'national_id' => '12345678901234',
            'address' => 'Test Address',
            'case_number' => '1',
            'case_type_id' => $caseType->id,
            'verdict' => 'Test verdict.',
            'payment_status' => PaymentStatus::Unpaid,
            'user_id' => $admin->id,
        ]);

        Livewire::test(DashboardOverview::class)
            ->assertSee('القضايا')
            ->assertSee('Users')
            ->assertSee('أنواع القضايا')
            ->assertSee('1');
    }
}
