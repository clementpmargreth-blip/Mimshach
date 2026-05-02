<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Funding;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FundingController extends Controller
{
    public function index(Request $request)
    {
        // Get unique values for filters
        $educationLevels = ['All Levels', ...Funding::distinct()->pluck('education_level')->filter()->sort()->values()->toArray()];
        $universities = University::orderBy('name', 'asc')->get();

        // Build filters array
        $filters = [
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search funding...',
            ],
            [
                'type' => 'select',
                'name' => 'education_level',
                'label' => 'Education Level',
                'options' => $educationLevels,
            ],
        ];

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

        $fundings = $query->orderBy('id', 'desc')->paginate(6);

        return view('admin.funding.index', compact('fundings', 'filters', 'universities'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'university_id' => 'required|exists:universities,id',
                'education_level' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $validated['slug'] = Str::slug($validated['name']);

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    $imagePath = $request->file('image')->store('fundings', 'public');
                    $validated['image'] = $imagePath;
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload image: ' . $e->getMessage()
                    ], 500);
                }
            } else {
                unset($validated['image']);
            }

            $funding = Funding::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Funding opportunity created successfully',
                'funding' => $funding
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Funding store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating funding opportunity: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $funding = Funding::findOrFail($id);

            // Add full URL for image
            $fundingData = $funding->toArray();
            $fundingData['image_url'] = $funding->image ? Storage::url($funding->image) : null;

            return response()->json([
                'success' => true,
                'funding' => $fundingData
            ]);
        } catch (\Exception $e) {
            Log::error('Funding edit error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Funding opportunity not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $funding = Funding::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'university_id' => 'required|exists:universities,id',
                'education_level' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $validated['slug'] = Str::slug($validated['name']);

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image if exists
                if ($funding->image && Storage::disk('public')->exists($funding->image)) {
                    Storage::disk('public')->delete($funding->image);
                }

                try {
                    $imagePath = $request->file('image')->store('fundings', 'public');
                    $validated['image'] = $imagePath;
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload image: ' . $e->getMessage()
                    ], 500);
                }
            } else {
                unset($validated['image']);
            }

            $funding->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Funding opportunity updated successfully',
                'funding' => $funding
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Funding update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating funding opportunity: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $funding = Funding::findOrFail($id);

            // Delete image if exists
            if ($funding->image && Storage::disk('public')->exists($funding->image)) {
                Storage::disk('public')->delete($funding->image);
            }

            $funding->delete();

            return response()->json([
                'success' => true,
                'message' => 'Funding opportunity deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Funding delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting funding opportunity: ' . $e->getMessage()
            ], 500);
        }
    }
}
