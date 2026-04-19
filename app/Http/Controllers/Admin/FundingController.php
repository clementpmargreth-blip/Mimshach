<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FundingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get universities for filter
        $universities = University::orderBy('name')->get();
        $universityOptions = ['All Universities', ...$universities->pluck('name')->toArray()];

        // Get unique education levels
        $educationLevels = ['All Levels', ...Funding::distinct()->pluck('education_level')->filter()->sort()->values()->toArray()];
        
        $fundingNames = ['All Fundings', ...Funding::distinct()->pluck('name')->filter()->sort()->values()->toArray()];

        $filters = [
            [
                'type' => 'select',
                'name' => 'education_level',
                'options' => $educationLevels,
            ],
            [
                'type' => 'select',
                'name' => 'funding_name',
                'options' => $fundingNames,
            ],
            [
                'type' => 'select',
                'name' => 'university',
                'options' => $universityOptions,
            ],
        ];

        // Get filtered funding opportunities
        $query = Funding::with('university');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('education_level') && $request->education_level !== 'All Levels') {
            $query->where('education_level', $request->education_level);
        }
        if ($request->filled('funding_name') && $request->funding_name !== 'All Fundings') {
            $query->where('name', $request->funding_name);
        }

        if ($request->filled('university') && $request->university !== 'All Universities') {
            $query->whereHas('university', function ($q) use ($request) {
                $q->where('name', $request->university);
            });
        }

        $fundings = $query->orderBy('created_at', 'desc')->paginate(6);

        return view('admin.funding.index', compact('fundings', 'filters', 'universities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $universities = University::orderBy('name')->get();
        return view('admin.funding.create', compact('universities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'education_level' => 'required|string|in:Undergraduate,Graduate,PhD,Diploma',
            'university_id' => 'required|exists:universities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('funding', 'public');
        }

        Funding::create($validated);

        return redirect()->route('admin.funding.index')->with('success', 'Funding opportunity created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Funding $funding)
    {
        return view('admin.funding.show', compact('funding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Funding $funding)
    {
        $universities = University::orderBy('name')->get();
        return response()->json([
            'funding' => $funding,
            'universities' => $universities
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Funding $funding)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'education_level' => 'required|string|in:Undergraduate,Graduate,PhD,Diploma',
            'university_id' => 'required|exists:universities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($funding->image) {
                Storage::disk('public')->delete($funding->image);
            }
            $validated['image'] = $request->file('image')->store('funding', 'public');
        }

        $funding->update($validated);

        return redirect()->route('admin.funding.index')->with('success', 'Funding opportunity updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Funding $funding)
    {
        if ($funding->image) {
            Storage::disk('public')->delete($funding->image);
        }
        $funding->delete();

        return redirect()->route('admin.funding.index')->with('success', 'Funding opportunity deleted successfully');
    }
}
