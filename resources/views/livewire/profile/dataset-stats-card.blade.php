<?php

use App\Models\Dataset;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public int $userDatasetCount = 0;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->userDatasetCount = Dataset::where('user_id', Auth::id())->count();
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Dataset Statistics') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Information about your uploaded datasets.') }}
        </p>
    </header>

    <div class="mt-6 flex justify-center">
        <div class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-200 w-full">
            <div class="mr-4 bg-blue-100 p-3 rounded-full">
                <i class="fa-solid fa-database text-blue-500 text-xl"></i>
            </div>
            <div>
                <h3 class="text-md font-medium text-blue-800">{{ __('Your Datasets') }}</h3>
                <p class="text-blue-600">
                    {{ __('You have uploaded') }}
                    <span class="font-bold">{{ $userDatasetCount }}</span>
                    {{ __('dataset(s)') }}
                </p>
            </div>
        </div>
    </div>
</section>
