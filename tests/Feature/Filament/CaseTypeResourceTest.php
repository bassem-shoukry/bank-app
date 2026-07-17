<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\CaseTypeResource\Pages\CreateCaseType;
use App\Filament\Resources\CaseTypeResource\Pages\ListCaseTypes;
use App\Models\CaseType;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CaseTypeResourceTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin(): User
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Filament::setCurrentPanel(Filament::getPanel('admin'));
        $this->actingAs($admin);

        return $admin;
    }

    public function test_admin_can_create_a_case_type(): void
    {
        $this->actingAsAdmin();

        Livewire::test(CreateCaseType::class)
            ->fillForm(['name' => 'إداري'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('case_types', ['name' => 'إداري']);
    }

    public function test_case_type_name_must_be_unique(): void
    {
        $this->actingAsAdmin();
        CaseType::factory()->create(['name' => 'مدني']);

        Livewire::test(CreateCaseType::class)
            ->fillForm(['name' => 'مدني'])
            ->call('create')
            ->assertHasFormErrors(['name' => 'unique']);
    }

    public function test_admin_can_list_case_types(): void
    {
        $this->actingAsAdmin();
        $caseType = CaseType::factory()->create(['name' => 'جنائي']);

        Livewire::test(ListCaseTypes::class)
            ->assertCanSeeTableRecords([$caseType]);
    }
}
