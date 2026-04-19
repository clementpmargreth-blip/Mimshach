<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\University;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get unique values from database for filters
        $years = ['All Years', ...Admission::distinct()->pluck('year')->sort()->toArray()];
        $universitiesList = University::orderBy('name')->pluck('name')->toArray();
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

        // Get filtered events
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

        $admissions = $query->with('university')
            ->latest()
            ->paginate(6)
            ->appends($request->query());

        return view('admin.admissions.index', compact('admissions', 'filters'));
    }

    /**
     * Get filtered admissions with all filter logic
     */
    private function getFilteredAdmissions(Request $request)
    {
        $query = Admission::with('university');

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

        return $query->latest()->paginate(6);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
