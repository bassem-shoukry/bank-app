<div>
    <section class="description text-center">
        <h2 class="text-3xl font-bold mb-2">Welcome to Data Bank</h2>
        <p class="text-lg mb-8">Your next step to Data Science <br> Upload and share your Datasets with ease</p>
    </section>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-center">
        <div class="flex gap-2">
            <a href="{{ route('datasets.create') }}" class="bg-gray-100 border border-gray-300 py-2 px-4 hover:bg-gray-200 transition">
                Add New Data Set
            </a>
            <button wire:click="resetFilters" class="bg-red-50 border border-red-200 py-2 px-4 hover:bg-red-100 transition">
                Reset Filters
            </button>
        </div>
        <input wire:model.live="searchTerm" type="text" placeholder="Search datasets..."
               class="border border-gray-300 px-4 py-2 rounded w-1/3">
    </div>

    <div class="bg-gray-100 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
            <tr>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left">Name</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left">Description</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100">
                    <div>Skill</div>
                    <select wire:model.live="selectedSkill" class="mt-1 block w-full py-1 px-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
                        <option value="">All Skills</option>
                        @foreach($skills as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100">
                    <div>Industry</div>
                    <select wire:model.live="selectedIndustry" class="mt-1 block w-full py-1 px-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
                        <option value="">All Industries</option>
                        @foreach($industries as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100">
                    <div>Year</div>
                    <select wire:model.live="selectedYear" class="mt-1 block w-full py-1 px-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none">
                        <option value="">All Years</option>
                        @foreach($years as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left">Size</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left">Files</th>
                <th class="py-3 px-4 border-b border-gray-200 bg-gray-100 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($datasets as $dataset)
                <tr>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->name }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ Str::limit($dataset->description, 50) }}</td>
                    <td class="py-3 px-4 border-b border-gray-200 text-center">{{ $dataset->skill->name ?? 'N/A' }}</td>
                    <td class="py-3 px-4 border-b border-gray-200 text-center">{{ $dataset->industry->name ?? 'N/A' }}</td>
                    <td class="py-3 px-4 border-b border-gray-200 text-center">{{ $dataset->year->year ?? 'N/A' }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $dataset->formatSize() }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">
                        <div class="flex flex-col gap-1">
                            @forelse($dataset->files as $file)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm">{{ $file->file_name }}</span>
                                    <a href="{{ route('datasets.download.file', $file->id) }}" class="text-blue-500 hover:text-blue-700" title="Download">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                </div>
                            @empty
                                @if($dataset->file_path)
                                    <!-- Legacy support for datasets with a single file path -->
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm">File</span>
                                        <a href="{{ route('datasets.download', $dataset) }}" class="text-blue-500 hover:text-blue-700" title="Download">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    </div>
                                @else
                                    <span>No files</span>
                                @endif
                            @endforelse
                        </div>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200">
                        <div class="flex gap-2">
                            <a href="{{ route('datasets.show', $dataset) }}" class="text-blue-500 hover:text-blue-700" title="View Details">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            @if($dataset->user_id == Auth::id())
                                <button
                                    wire:click="$dispatch('openModal', { component: 'modals.confirm-delete', arguments: { id: {{ $dataset->id }}, name: '{{ $dataset->name }}' }})"
                                    class="text-red-500 hover:text-red-700"
                                    title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="py-3 px-4 border-b border-gray-200 text-center">No datasets found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $datasets->links() }}
    </div>
</div>
