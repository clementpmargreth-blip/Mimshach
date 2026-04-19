<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        // Get unique values for filters
        $educationLevels = ['All Levels', ...ConsultationRequest::distinct()->pluck('level_of_education')->filter()->sort()->values()->toArray()];

        // Get all programmes of interest (from JSON field)
        $allProgrammes = ConsultationRequest::all()->pluck('programme_of_interest')->flatten()->unique()->sort()->values()->toArray();
        $programmes = ['All Programmes', ...$allProgrammes];

        // Get all preferred countries (from JSON field)
        $allCountries = ConsultationRequest::all()->pluck('preferred_countries')->flatten()->unique()->sort()->values()->toArray();
        $countries = ['All Countries', ...$allCountries];

        $filters = [
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search by name or email...',
            ],
            [
                'type' => 'select',
                'name' => 'education_level',
                'label' => 'Education Level',
                'options' => $educationLevels,
            ],
            [
                'type' => 'select',
                'name' => 'programme',
                'label' => 'Programme of Interest',
                'options' => $programmes,
            ],
            [
                'type' => 'select',
                'name' => 'country',
                'label' => 'Preferred Country',
                'options' => $countries,
            ],
            [
                'type' => 'date',
                'name' => 'date_from',
                'placeholder' => 'From Date',
            ],
            [
                'type' => 'date',
                'name' => 'date_to',
                'placeholder' => 'To Date',
            ],
            [
                'type' => 'date',
                'name' => 'specific_date',
                'placeholder' => 'Specific Date',
            ],
        ];

        // Get filtered consultation requests
        $query = ConsultationRequest::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('education_level') && $request->education_level !== 'All Levels') {
            $query->where('level_of_education', $request->education_level);
        }

        if ($request->filled('programme') && $request->programme !== 'All Programmes') {
            $query->whereJsonContains('programme_of_interest', $request->programme);
        }

        if ($request->filled('country') && $request->country !== 'All Countries') {
            $query->whereJsonContains('preferred_countries', $request->country);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('specific_date')) {
            $query->whereDate('created_at', $request->specific_date);
        }

        $consultations = $query->orderBy('created_at', 'desc')->paginate(6);

        $totalConsultations = ConsultationRequest::count();
        $newThisWeek = ConsultationRequest::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $newThisMonth = ConsultationRequest::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        // Get average budget
        $avgBudget = ConsultationRequest::avg('tuition_budget');

        // Get top education level
        $topEducationLevel = ConsultationRequest::selectRaw('level_of_education, COUNT(*) as count')
            ->groupBy('level_of_education')
            ->orderBy('count', 'desc')
            ->first();

        // Get top programme of interest
        $allProgrammesList = ConsultationRequest::all()->pluck('programme_of_interest')->flatten();
        $topProgramme = $allProgrammesList->count() > 0 ? $allProgrammesList->mode()[0] ?? null : null;

        // Get top country
        $allCountriesList = ConsultationRequest::all()->pluck('preferred_countries')->flatten();
        $topCountry = $allCountriesList->count() > 0 ? $allCountriesList->mode()[0] ?? null : null;

        return view('admin.consultations.index', compact(
            'consultations',
            'filters',
            'totalConsultations',
            'newThisWeek',
            'newThisMonth',
            'avgBudget',
            'topEducationLevel',
            'topProgramme',
            'topCountry'
        ));
    }

    public function show(ConsultationRequest $consultation)
    {
        // return view('admin.consultations.show', compact('consultation'));
    }

    public function destroy(ConsultationRequest $consultation)
    {
        $consultation->delete();
        return redirect()->route('admin.consultations.index')->with('success', 'Consultation request deleted successfully');
    }
}
