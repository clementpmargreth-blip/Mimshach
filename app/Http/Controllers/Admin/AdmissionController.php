<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\University;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get unique values from database for filters
        $years = ['All Years', ...Admission::distinct()->pluck('year')->sort()->toArray()];
        $universitiesList = University::orderBy('name', 'asc')->pluck('name')->toArray();
        $universities = ['All Universities', ...$universitiesList];
        $programs = ['All Programs', ...Admission::distinct()->pluck('program')->sort()->toArray()];
        $countries = ['All Countries', ...Admission::distinct()->pluck('country')->sort()->toArray()];

        // Build filters array
        $filters = [
            [
                'type' => 'select',
                'name' => 'year',
                'label' => 'Year',
                'options' => $years,
            ],
            [
                'type' => 'select',
                'name' => 'university',
                'label' => 'University',
                'options' => $universities,
            ],
            [
                'type' => 'select',
                'name' => 'program',
                'label' => 'Program',
                'options' => $programs,
            ],
            [
                'type' => 'select',
                'name' => 'country',
                'label' => 'Country',
                'options' => $countries,
            ],
        ];

        // Get filtered admissions
        $query = Admission::query();

        if ($request->year && $request->year !== 'All Years') {
            $query->where('year', $request->year);
        }

        if ($request->university && $request->university !== 'All Universities') {
            $query->whereHas('university', function ($q) use ($request) {
                $q->where('name', $request->university);
            });
        }

        if ($request->program && $request->program !== 'All Programs') {
            $query->where('program', $request->program);
        }

        if ($request->country && $request->country !== 'All Countries') {
            $query->where('country', $request->country);
        }

        $admissions = $query->with('university')->orderBy('deadline', 'desc')
            ->latest()
            ->paginate(6)
            ->appends($request->query());

        return view('admin.admissions.index', compact('admissions', 'filters'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string',
                'content' => 'required|string',
                'program' => 'required|string|max:255',
                'year' => 'required|integer|min:2000|max:2100',
                'country' => 'required|string|max:255',
                'deadline' => 'required|date',
                'university_id' => 'required|exists:universities,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    $imagePath = $request->file('image')->store('admissions', 'public');
                    $validated['image'] = $imagePath;
                } catch (\Exception $e) {
                    Log::error('Image upload failed: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload image: ' . $e->getMessage()
                    ], 500);
                }
            }

            $admission = Admission::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Admission created successfully',
                'admission' => $admission
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating admission: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $admission = Admission::with('university')->findOrFail($id);

            $admissionData = $admission->toArray();
            $admissionData['formatted_deadline'] = Carbon::parse($admission->deadline)->format('Y-m-d');
            return response()->json([
                'success' => true,
                'admission' => $admissionData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Admission not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $admission = Admission::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string',
                'content' => 'required|string',
                'program' => 'required|string|max:255',
                'year' => 'required|integer|min:2000|max:2100',
                'country' => 'required|string|max:255',
                'deadline' => 'required|date',
                'university_id' => 'required|exists:universities,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Delete old image if exists
                if ($admission->image && Storage::disk('public')->exists($admission->image)) {
                    Storage::disk('public')->delete($admission->image);
                }

                // Store new image
                $imagePath = $request->file('image')->store('admissions', 'public');
                $validated['image'] = $imagePath;
            }

            $admission->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Admission updated successfully',
                'admission' => $admission
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating admission: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $admission = Admission::findOrFail($id);

            if ($admission->image) {
                Storage::disk('public')->delete($admission->image);
            }

            $admission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admission deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting admission: ' . $e->getMessage()
            ], 500);
        }
    }
}
