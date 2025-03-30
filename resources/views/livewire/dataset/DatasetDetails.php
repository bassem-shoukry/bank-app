<?php

namespace App\Livewire\Dashboard;

use App\Models\Dataset;
use Livewire\Component;

class DatasetDetails extends Component
{
    public Dataset $dataset;

    public function mount(Dataset $dataset)
    {
        // Check if the dataset is approved or belongs to the current user
        if (!$dataset->is_approved && auth()->id() !== $dataset->user_id) {
            session()->flash('error', 'You do not have permission to view this dataset.');
            return redirect()->route('dashboard');
        }

        $this->dataset = $dataset;
    }

    public function render()
    {
        return view('livewire.dataset-details')
            ->layout('layouts.app');
    }
}
