<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
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
            'skill_id' => 'required|string',
            'industry_id' => 'required|string',
            'datasetSize' => 'required|numeric',
            'datasetFile' => 'required|file|max:102400' // 100MB max
        ]);


//         Handle file upload (example, adjust the storage logic as needed)
         $path = $request->file('datasetFile')->store('datasets');

//         Store the dataset in the database (example, adjust field names as needed)
         Dataset::create([
             'name'         => $validated['datasetName'],
             'user_id' => Auth()->user()->id,
             'author'       => $validated['author'],
             'industry_id'     => $validated['industry_id'],
             'description'  => $validated['datasetDescription'],
             'year_id'      => $validated['year_id'],
             'size'         => $validated['datasetSize'],
             'skill_id'       => $validated['skill_id'],
             'file_path'    => $path, // if file upload is implemented
         ]);

        // Store the dataset in the database and handle file upload
        // This would be implemented with real storage logic

        return redirect()->route('dashboard')
            ->with('success', 'Dataset uploaded successfully!');
    }

    public function download(Dataset $dataset)
    {
        // Check if a file exists
        if (!Storage::exists($dataset->file_path)) {
            return back()->with('error', 'File not found.');
        }

        // Get the original filename or use dataset name with extension
        $pathInfo = pathinfo($dataset->file_path);
        $filename = $dataset->name . '.' . ($pathInfo['extension'] ?? 'csv');

        // Return file download
        return Storage::download($dataset->file_path, $filename);
    }
}
