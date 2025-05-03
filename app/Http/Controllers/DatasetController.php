<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\DatasetFile;
use App\Models\Industry;
use App\Models\Skill;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DatasetController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create()
    {
        $years = Year::pluck('year', 'id')->toArray();
        $skills = Skill::pluck('name', 'id')->toArray();
        $industries = Industry::pluck('name', 'id')->toArray();

        // Pass them to the view
        return view('datasets.create', compact('years', 'skills', 'industries'));
    }

    public function store(Request $request)
    {
        // Validation logic
        $validated = $request->validate([
            'datasetName' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'datasetDescription' => 'required|string',
            'year_id' => 'required|integer',
            'skill_id' => 'required|array', // Changed to array for multi-select
            'skill_id.*' => 'exists:skills,id', // Validate each skill ID
            'industry_id' => 'required|string',
            'datasetSize' => 'required|numeric',
            'datasetFiles' => 'required|array',
            'datasetFiles.*' => 'file', // 100MB max per file
            'terms' => 'required|accepted', // Validate terms acceptance
            'communications' => 'nullable', // Optional communications preference
        ]);

        // Create the dataset
        $dataset = Dataset::create([
            'name' => $validated['datasetName'],
            'user_id' => Auth()->user()->id,
            'author' => $validated['author'],
            'industry_id' => $validated['industry_id'],
            'description' => $validated['datasetDescription'],
            'year_id' => $validated['year_id'],
            'size' => $validated['datasetSize'],
            // Store the first skill ID in the main skill_id field
            'skill_id' => $validated['skill_id'][0],
            'communications_opt_in' => isset($validated['communications']),
        ]);

        // Attach additional skills (for many-to-many relationship)
        // You'll need to create a dataset_skill pivot table and relationship for this
        if (count($validated['skill_id']) > 1) {
            $dataset->skills()->attach(array_slice($validated['skill_id'], 1));
        }

        // Handle multiple file uploads
        if ($request->hasFile('datasetFiles')) {
            foreach ($request->file('datasetFiles') as $file) {
                $path = $file->store('datasets');

                // Create file record
                $dataset->files()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('dashboard')
            ->with('message', 'Admin will review the Data uploaded in 24 hrs.');
    }

    // In DatasetController.php - rename this method
    public function downloadFile($id)
    {
        $file = DatasetFile::findOrFail($id);

        // Check if a file exists
        if (!Storage::exists($file->file_path)) {
            return back()->with('error', 'File not found.');
        }

        // Return file download
        return Storage::download($file->file_path, $file->file_name);
    }


    public function show(Dataset $dataset)
    {
        // Check if the dataset is approved or belongs to the current user
        if (!$dataset->is_approved && auth()->id() !== $dataset->user_id) {
            session()->flash('error', 'You do not have permission to view this dataset.');
            return redirect()->route('dashboard');
        }

        return view('datasets.show', compact('dataset'));
    }
}
