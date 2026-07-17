<?php

namespace App\Livewire\Dashboard;

use App\Models\Dataset;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class DatasetDashboard extends Component
{
    use WithPagination;

    public $searchTerm = '';

    public function updatedSearchTerm(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.dashboard.dataset-dashboard', [
            'datasets' => $this->getDatasets(),
        ]);
    }

    private function getDatasets()
    {
        $query = Dataset::query()->with('caseType');

        if (! auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        if (! empty($this->searchTerm)) {
            $searchTerm = '%'.trim($this->searchTerm).'%';
            $query->where(function ($q) use ($searchTerm): void {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('national_id', 'like', $searchTerm)
                    ->orWhere('case_number', 'like', $searchTerm)
                    ->orWhereHas('caseType', function ($q) use ($searchTerm): void {
                        $q->where('name', 'like', $searchTerm);
                    });
            });
        }

        return $query->latest()->paginate(10);
    }

    public function resetFilters(): void
    {
        $this->searchTerm = '';
        $this->resetPage();
    }

    #[On('deleteDataset')]
    public function deleteDataset($id): void
    {
        $dataset = Dataset::find($id);

        if (! $dataset) {
            return;
        }

        abort_unless(auth()->user()->can('delete', $dataset), 403);

        $dataset->delete();

        session()->flash('message', 'تم حذف القضية بنجاح.');
    }
}
