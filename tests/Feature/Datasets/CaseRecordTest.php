<?php

namespace Tests\Feature\Datasets;

use App\Enums\PaymentStatus;
use App\Livewire\Dashboard\DatasetDashboard;
use App\Models\CaseType;
use App\Models\Dataset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CaseRecordTest extends TestCase
{
    use RefreshDatabase;

    private CaseType $caseType;

    protected function setUp(): void
    {
        parent::setUp();

        $this->caseType = CaseType::factory()->create(['name' => 'مدني']);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'أحمد محمد',
            'national_id' => '29001011234567',
            'address' => '10 شارع التحرير، القاهرة',
            'case_number' => '2026/123',
            'case_type_id' => $this->caseType->id,
            'verdict' => 'حكمت المحكمة بقبول الدعوى.',
            'payment_status' => 'paid',
        ], $overrides);
    }

    public function test_authenticated_user_can_store_a_case_record(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('datasets.store'), $this->validPayload());

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('datasets', [
            'name' => 'أحمد محمد',
            'national_id' => '29001011234567',
            'case_number' => '2026/123',
            'case_type_id' => $this->caseType->id,
            'payment_status' => PaymentStatus::Paid->value,
            'user_id' => $user->id,
        ]);
    }

    public function test_national_id_must_be_fourteen_digits(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['national_id' => '12345'])
        );

        $response->assertSessionHasErrors('national_id');
        $this->assertDatabaseMissing('datasets', ['national_id' => '12345']);
    }

    public function test_national_id_rejects_an_invalid_century_digit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['national_id' => '19001011234567'])
        );

        $response->assertSessionHasErrors('national_id');
    }

    public function test_national_id_rejects_an_impossible_birth_date(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['national_id' => '29013011234567'])
        );

        $response->assertSessionHasErrors('national_id');
    }

    public function test_national_id_rejects_a_birth_date_in_the_future(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['national_id' => '33001011234567'])
        );

        $response->assertSessionHasErrors('national_id');
    }

    public function test_name_rejects_digits(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['name' => 'Ahmed123'])
        );

        $response->assertSessionHasErrors('name');
    }

    public function test_case_number_accepts_arabic_court_format(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['case_number' => '1234 لسنة 2026 مدني كلي'])
        );

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('datasets', ['case_number' => '1234 لسنة 2026 مدني كلي']);
    }

    public function test_case_type_id_must_reference_an_existing_case_type(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['case_type_id' => 999999])
        );

        $response->assertSessionHasErrors('case_type_id');
    }

    public function test_payment_status_must_be_a_known_value(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(
            route('datasets.store'),
            $this->validPayload(['payment_status' => 'bogus'])
        );

        $response->assertSessionHasErrors('payment_status');
    }

    public function test_guest_cannot_access_case_creation(): void
    {
        $response = $this->get(route('datasets.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_dashboard_lists_case_records(): void
    {
        $user = User::factory()->create();
        Dataset::factory()->create(['user_id' => $user->id, 'name' => 'قضية اختبار', 'case_type_id' => $this->caseType->id]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSeeLivewire(DatasetDashboard::class);
    }

    public function test_show_page_displays_case_details(): void
    {
        $user = User::factory()->create();
        $dataset = Dataset::factory()->create(['user_id' => $user->id, 'name' => 'قضية اختبار', 'case_type_id' => $this->caseType->id]);

        $response = $this->actingAs($user)->get(route('datasets.show', $dataset));

        $response->assertOk();
        $response->assertSee('قضية اختبار');
    }

    public function test_user_cannot_view_another_users_case_record(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $dataset = Dataset::factory()->create(['user_id' => $owner->id, 'case_type_id' => $this->caseType->id]);

        $response = $this->actingAs($other)->get(route('datasets.show', $dataset));

        $response->assertForbidden();
    }

    public function test_admin_can_view_any_case_record(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $dataset = Dataset::factory()->create(['user_id' => $owner->id, 'name' => 'قضية اختبار', 'case_type_id' => $this->caseType->id]);

        $response = $this->actingAs($admin)->get(route('datasets.show', $dataset));

        $response->assertOk();
        $response->assertSee('قضية اختبار');
    }

    public function test_dashboard_only_lists_the_current_users_case_records(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Dataset::factory()->create(['user_id' => $user->id, 'name' => 'قضيتي', 'case_type_id' => $this->caseType->id]);
        Dataset::factory()->create(['user_id' => $other->id, 'name' => 'قضية غيري', 'case_type_id' => $this->caseType->id]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSee('قضيتي');
        $response->assertDontSee('قضية غيري');
    }

    public function test_admin_sees_every_case_record_on_the_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $other = User::factory()->create();
        Dataset::factory()->create(['user_id' => $other->id, 'name' => 'قضية غيري', 'case_type_id' => $this->caseType->id]);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertSee('قضية غيري');
    }

    public function test_owner_can_delete_their_own_case_record(): void
    {
        $user = User::factory()->create();
        $dataset = Dataset::factory()->create(['user_id' => $user->id, 'case_type_id' => $this->caseType->id]);

        Livewire::actingAs($user)
            ->test(DatasetDashboard::class)
            ->call('deleteDataset', $dataset->id);

        $this->assertDatabaseMissing('datasets', ['id' => $dataset->id]);
    }

    public function test_non_owner_cannot_delete_another_users_case_record(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $dataset = Dataset::factory()->create(['user_id' => $owner->id, 'case_type_id' => $this->caseType->id]);

        Livewire::actingAs($other)
            ->test(DatasetDashboard::class)
            ->call('deleteDataset', $dataset->id)
            ->assertForbidden();

        $this->assertDatabaseHas('datasets', ['id' => $dataset->id]);
    }

    public function test_admin_can_delete_any_case_record(): void
    {
        $owner = User::factory()->create();
        $admin = User::factory()->create(['is_admin' => true]);
        $dataset = Dataset::factory()->create(['user_id' => $owner->id, 'case_type_id' => $this->caseType->id]);

        Livewire::actingAs($admin)
            ->test(DatasetDashboard::class)
            ->call('deleteDataset', $dataset->id);

        $this->assertDatabaseMissing('datasets', ['id' => $dataset->id]);
    }
}
