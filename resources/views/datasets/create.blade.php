<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload Your Dataset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Global Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong class="font-bold">Whoops!</strong>
                            <span>There were some problems with your input.</span>
                            <ul class="mt-3 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('datasets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Dataset Name -->
                        <div>
                            <label for="datasetName" class="block text-sm font-medium text-gray-700">Dataset Name</label>
                            <input type="text" id="datasetName" name="datasetName" value="{{ old('datasetName') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Author -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">User</label>
                            <input type="text" id="author" name="author" value="{{ old('author', Auth::user()->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Dataset Description -->
                        <div>
                            <label for="datasetDescription" class="block text-sm font-medium text-gray-700">Dataset Description</label>
                            <textarea id="datasetDescription" name="datasetDescription" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('datasetDescription') }}</textarea>
                        </div>

                        <!-- Dataset Size -->
                        <div>
                            <label for="datasetSize" class="block text-sm font-medium text-gray-700">Size of Dataset (in MB)</label>
                            <input type="number" id="datasetSize" name="datasetSize" value="{{ old('datasetSize') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <!-- Year Select -->
                        <div class="form-group">
                            <label for="year_id">Year:</label>
                            <select name="year_id" id="year_id" class="form-control">
                                <option value="">-- Select Year --</option>
                                @foreach($years as $id => $year)
                                    <option value="{{ $id }}" {{ old('year_id') == $id ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                            @error('year_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Skill Select -->
                        <div class="form-group">
                            <label for="skill_id">Skill:</label>
                            <select name="skill_id" id="skill_id" class="form-control">
                                <option value="">-- Select Skill --</option>
                                @foreach($skills as $id => $skill)
                                    <option value="{{ $id }}" {{ old('skill_id') == $id ? 'selected' : '' }}>{{ $skill }}</option>
                                @endforeach
                            </select>
                            @error('skill_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Industry Select -->
                        <div class="form-group">
                            <label for="industry_id">Industry:</label>
                            <select name="industry_id" id="industry_id" class="form-control">
                                <option value="">-- Select Industry --</option>
                                @foreach($industries as $id => $industry)
                                    <option value="{{ $id }}" {{ old('industry_id') == $id ? 'selected' : '' }}>{{ $industry }}</option>
                                @endforeach
                            </select>
                            @error('industry_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Source -->
                        <div>
                            <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                            <textarea id="source" name="source" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('source') }}</textarea>
                        </div>

                        <!-- Dataset File Upload -->
                        <div>
                            <label for="datasetFile" class="block text-sm font-medium text-gray-700">Upload Dataset File</label>
                            <input type="file" id="datasetFile" name="datasetFile" accept=".csv,.xlsx,.json,.txt"
                                   class="mt-1 block w-full" required>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
