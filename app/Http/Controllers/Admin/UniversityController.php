<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        // Get unique values for filters
        $countries = ['All Countries', ...University::distinct()->pluck('country')->filter()->sort()->values()->toArray()];
        $cities = ['All Cities', ...University::distinct()->pluck('city')->filter()->sort()->values()->toArray()];

        // Build filters array
        $filters = [
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search universities...',
            ],
            [
                'type' => 'select',
                'name' => 'country',
                'label' => 'Country',
                'options' => $countries,
                'empty_option' => 'All Countries'
            ],
            [
                'type' => 'select',
                'name' => 'city',
                'label' => 'City',
                'options' => $cities,
                'empty_option' => 'All Cities'
            ],
        ];

        $query = University::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->country && $request->country !== 'All Countries') {
            $query->where('country', $request->country);
        }

        if ($request->city && $request->city !== 'All Cities') {
            $query->where('city', $request->city);
        }

        $universities = $query->latest()->paginate(6);

        return view('admin.universities.index', compact('universities', 'filters'));
    }

    /**
     * Get filtered universities with all filter logic
     */
    private function getFilteredUniversities(Request $request)
    {
        $query = University::query();

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%')
                    ->orWhere('country', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%');
            });
        }

        // Apply country filter
        if ($request->filled('country') && $request->country !== 'All Countries') {
            $query->where('country', $request->country);
        }

        // Apply city filter
        if ($request->filled('city') && $request->city !== 'All Cities') {
            $query->where('city', $request->city);
        }

        return $query->latest()->paginate(6);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('universities', 'public');
        }

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('universities/logos', 'public');
        }

        University::create($validated);

        return redirect()->route('admin.universities.index')->with('success', 'University created successfully');
    }

    public function edit(University $university)
    {
        return response()->json($university);
    }

    public function update(Request $request, University $university)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($university->image) {
                Storage::disk('public')->delete($university->image);
            }
            $validated['image'] = $request->file('image')->store('universities', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($university->logo) {
                Storage::disk('public')->delete($university->logo);
            }
            $validated['logo'] = $request->file('logo')->store('universities/logos', 'public');
        }

        $university->update($validated);

        return redirect()->route('admin.universities.index')->with('success', 'University updated successfully');
    }

    public function destroy(University $university)
    {
        if ($university->image) {
            Storage::disk('public')->delete($university->image);
        }
        if ($university->logo) {
            Storage::disk('public')->delete($university->logo);
        }
        $university->delete();

        return redirect()->route('admin.universities.index')->with('success', 'University deleted successfully');
    }
}
