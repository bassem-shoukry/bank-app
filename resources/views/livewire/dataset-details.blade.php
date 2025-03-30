<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <header class="mb-6">
                <h2 class="text-3xl font-bold">{{ $dataset->name }}</h2>
                <p class="mt-2 text-gray-600">{{ $dataset->description }}</p>
            </header>

            <section class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Dataset Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded">
                        <p><strong>User:</strong> {{ $dataset->user->name }}</p>
                        <p><strong>Skill:</strong> {{ $dataset->skill->name ?? 'N/A' }}</p>
                        <p><strong>Industry:</strong> {{ $dataset->industry->name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded">
                        <p><strong>Year:</strong> {{ $dataset->year->year ?? 'N/A' }}</p>
                        <p><strong>Size:</strong> {{ $dataset->formatSize() }}</p>
                        <p><strong>Uploaded:</strong> {{ $dataset->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </section>

            <section class="mb-8">
                <h3 class="text-xl font-semibold mb-3">Files</h3>
                <div class="bg-gray-50 p-4 rounded">
                    @forelse($dataset->files as $file)
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-0">
                            <span>{{ $file->file_name }}</span>
                            <a href="{{ route('datasets.download.file', $file->id) }}"
                               class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded flex items-center gap-2">
                                Download <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    @empty
                        @if($dataset->file_path)
                            <div class="flex items-center justify-between py-2">
                                <span>File</span>
                                <a href="{{ route('datasets.download', $dataset) }}"
                                   class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded flex items-center gap-2">
                                    Download <i class="fa-solid fa-download"></i>
                                </a>
                            </div>
                        @else
                            <p>No files available</p>
                        @endif
                    @endforelse
                </div>
            </section>

            <div class="flex justify-between mt-8">
                <a href="{{ route('dashboard') }}" class="bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded">
                    Back to Dashboard
                </a>

                @if($dataset->user_id == auth()->id())
                    <button
                        wire:click="$dispatch('openModal', { component: 'modals.confirm-delete', arguments: { id: {{ $dataset->id }}, name: '{{ $dataset->name }}' }})"
                        class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">
                        Delete Dataset
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
