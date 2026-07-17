<?php

namespace Tests\Feature\Filament;

use App\Enums\PaymentStatus;
use App\Filament\Resources\DatasetResource\Pages\CreateDataset;
use App\Filament\Resources\DatasetResource\Pages\ListDatasets;
use App\Models\CaseType;
use App\Models\Dataset;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DatasetResourceTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs($admin);

        return $admin;
    }

    public function test_admin_can_create_a_case_record(): void
    {
        $this->actingAsAdmin();
        $caseType = CaseType::factory()->create(['name' => 'تجاري']);

        Livewire::test(CreateDataset::class)
            ->fillForm([
                'name' => 'سارة أحمد',
                'national_id' => '29001011234567',
                'address' => '5 شارع الجمهورية، الجيزة',
                'case_number' => '2026/456',
                'case_type_id' => $caseType->id,
                'verdict' => 'حكمت المحكمة برفض الدعوى.',
                'payment_status' => PaymentStatus::Partial->value,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('datasets', [
            'name' => 'سارة أحمد',
            'national_id' => '29001011234567',
            'case_number' => '2026/456',
            'case_type_id' => $caseType->id,
            'payment_status' => PaymentStatus::Partial->value,
        ]);
    }

    public function test_admin_can_search_case_records_by_national_id(): void
    {
        $admin = $this->actingAsAdmin();

        $match = Dataset::factory()->create(['user_id' => $admin->id, 'national_id' => '11122233344455']);
        $other = Dataset::factory()->create(['user_id' => $admin->id, 'national_id' => '99988877766655']);

        Livewire::test(ListDatasets::class)
            ->searchTable('11122233344455')
            ->assertCanSeeTableRecords([$match])
            ->assertCanNotSeeTableRecords([$other]);
    }
}
