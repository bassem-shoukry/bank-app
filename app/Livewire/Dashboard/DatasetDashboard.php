<?php

namespace App\Livewire\Dashboard;

use App\Models\Dataset;
use App\Models\Industry;
use App\Models\Skill;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class DatasetDashboard extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $selectedSkill = '';
    public $selectedIndustry = '';
    public $selectedYear = '';

    // Reset pagination when filters change
    public function updatedSearchTerm() { $this->resetPage(); }
    public function updatedSelectedSkill() { $this->resetPage(); }
    public function updatedSelectedIndustry() { $this->resetPage(); }
    public function updatedSelectedYear() { $this->resetPage(); }

    public function mount(): void
    {
        // Don't set a default year to show all datasets initially
        // $this->selectedYear = date('Y');
    }

    public function render()
    {
        return view('livewire.dashboard.dataset-dashboard', [
            'datasets' => $this->getDatasets(),
            'years' => $this->getYears(),
            'skills' => $this->getSkills(),
            'industries' => $this->getIndustries(),
        ]);
    }

    private function getDatasets()
    {
        // Start with a query builder instead of fetching all records
        $query = Dataset::query();

        // Filter only approved datasets
        $query->where('is_approved', true);

        // Apply search filter if provided
        if (!empty($this->searchTerm)) {
            $searchTerm = '%' . $this->searchTerm . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm)
                    ->orWhereHas('skill', function($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    })
                    ->orWhereHas('industry', function($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    });
            });
        }

        // Apply skill filter if selected
        if (!empty($this->selectedSkill)) {
            $query->where('skill_id', $this->selectedSkill);
        }

        // Apply industry filter if selected
        if (!empty($this->selectedIndustry)) {
            $query->where('industry_id', $this->selectedIndustry);
        }

        // Apply year filter if selected
        if (!empty($this->selectedYear)) {
            $query->where('year_id', $this->selectedYear);
        }

        // Return paginated results (10 per page)
        return $query->paginate(10);
    }

    private function getYears(): array
    {
        return Year::pluck('year', 'id')->toArray();
    }

    private function getSkills(): array
    {
        return Skill::pluck('name', 'id')->toArray();
    }

    private function getIndustries(): array
    {
        return Industry::pluck('name', 'id')->toArray();
    }

    // Add method to reset all filters
    public function resetFilters()
    {
        $this->searchTerm = '';
        $this->selectedSkill = '';
        $this->selectedIndustry = '';
        $this->selectedYear = '';
        $this->resetPage();
    }

    // Delete dataset
    #[On('deleteDataset')]
    public function deleteDataset($id)
    {
        $dataset = Dataset::find($id);

        if ($dataset) {
            // Delete the actual file if it exists
            if ($dataset->file_path && file_exists(storage_path('app/' . $dataset->file_path))) {
                unlink(storage_path('app/' . $dataset->file_path));
            }

            // Delete the database record
            $dataset->delete();

            // Show success notification
            session()->flash('message', 'Dataset deleted successfully.');
        }
    }
}
