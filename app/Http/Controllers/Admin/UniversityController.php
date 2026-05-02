<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UniversityController extends Controller
{
    public function index(Request $request)
    {
        // Get unique values for filters
        $countries = ['All Cities', ...University::distinct()->pluck('country')->filter()->sort()->values()->toArray()];
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
            ],
            [
                'type' => 'select',
                'name' => 'city',
                'label' => 'City',
                'options' => $cities,
            ],
        ];

        $query = University::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('country') && $request->country !== 'All Cities') {
            $query->where('country', $request->country);
        }

        if ($request->filled('city') && $request->city !== 'All Cities') {
            $query->where('city', $request->city);
        }

        $universities = $query->orderBy('id', 'desc')->paginate(6);

        return view('admin.universities.index', compact('universities', 'filters'));
    }
    
    public function store(Request $request)
    {
        try {
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

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    $imagePath = $request->file('image')->store('universities', 'public');
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

            // Handle logo upload
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                try {
                    $logoPath = $request->file('logo')->store('universities/logos', 'public');
                    $validated['logo'] = $logoPath;
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload logo: ' . $e->getMessage()
                    ], 500);
                }
            } else {
                unset($validated['logo']);
            }

            $university = University::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'University created successfully',
                'university' => $university
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('University store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating university: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $university = University::findOrFail($id);

            // Add full URLs for images
            $universityData = $university->toArray();
            $universityData['image_url'] = $university->image ? Storage::url($university->image) : null;
            $universityData['logo_url'] = $university->logo ? Storage::url($university->logo) : null;

            return response()->json([
                'success' => true,
                'university' => $universityData
            ]);
        } catch (\Exception $e) {
            Log::error('University edit error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'University not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $university = University::findOrFail($id);

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

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image if exists
                if ($university->image && Storage::disk('public')->exists($university->image)) {
                    Storage::disk('public')->delete($university->image);
                }

                try {
                    $imagePath = $request->file('image')->store('universities', 'public');
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

            // Handle logo upload
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                // Delete old logo if exists
                if ($university->logo && Storage::disk('public')->exists($university->logo)) {
                    Storage::disk('public')->delete($university->logo);
                }

                try {
                    $logoPath = $request->file('logo')->store('universities/logos', 'public');
                    $validated['logo'] = $logoPath;
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload logo: ' . $e->getMessage()
                    ], 500);
                }
            } else {
                unset($validated['logo']);
            }

            $university->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'University updated successfully',
                'university' => $university
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . json_encode($e->errors())
            ], 422);
        } catch (\Exception $e) {
            Log::error('University update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating university: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $university = University::findOrFail($id);

            // Delete image if exists
            if ($university->image && Storage::disk('public')->exists($university->image)) {
                Storage::disk('public')->delete($university->image);
            }

            // Delete logo if exists
            if ($university->logo && Storage::disk('public')->exists($university->logo)) {
                Storage::disk('public')->delete($university->logo);
            }

            $university->delete();

            return response()->json([
                'success' => true,
                'message' => 'University deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('University delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting university: ' . $e->getMessage()
            ], 500);
        }
    }

    public function admissions($id)
    {
        try {
            $university = University::with('admissions')->findOrFail($id);

            return response()->json([
                'success' => true,
                'admissions' => $university->admissions
            ]);
        } catch (\Exception $e) {
            Log::error('University admissions error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading admissions'
            ], 404);
        }
    }
}