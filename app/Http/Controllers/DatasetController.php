<?php

namespace App\Http\Controllers;

use App\Models\CaseType;
use App\Models\Dataset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DatasetController extends Controller
{
    public function index(): View
    {
        return view('dashboard');
    }

    public function create(): View
    {
        $caseTypes = CaseType::orderBy('name')->pluck('name', 'id');

        return view('datasets.create', compact('caseTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(Dataset::rules());

        Dataset::create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')
            ->with('message', 'تم إضافة القضية بنجاح.');
    }

    public function show(Dataset $dataset): View
    {
        $dataset->load('caseType');

        return view('datasets.show', compact('dataset'));
    }
}
