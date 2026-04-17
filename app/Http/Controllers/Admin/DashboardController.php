<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationRequest;
use App\Models\NewsletterSubscription;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\University;
use App\Models\Admission;
use App\Models\Funding;
use App\Models\Blog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalConsultations = ConsultationRequest::count();
        $newConsultationsToday = ConsultationRequest::whereDate('created_at', Carbon::today())->count();

        $totalNewsletters = NewsletterSubscription::count();
        $newNewslettersToday = NewsletterSubscription::whereDate('subscribed_at', Carbon::today())->count();

        $totalEvents = Event::count();
        $upcomingEvents = Event::where('date', '>=', Carbon::today())->count();
        $totalEventRegistrations = EventRegistration::count();

        $totalUniversities = University::count();
        $totalAdmissions = Admission::count();
        $activeAdmissions = Admission::where('deadline', '>=', Carbon::today())->count();

        $totalFunding = Funding::count();
        $totalBlogs = Blog::count();

        // Recent data
        $recentConsultations = ConsultationRequest::latest()->take(5)->get();
        $recentNewsletters = NewsletterSubscription::latest()->take(5)->get();
        $recentEvents = Event::latest()->take(5)->get();

        // Chart data (last 7 days)
        $consultationChart = $this->getLast7DaysData(ConsultationRequest::class, 'created_at');
        $newsletterChart = $this->getLast7DaysData(NewsletterSubscription::class, 'subscribed_at');

        return view('admin.dashboard', compact(
            'totalConsultations',
            'newConsultationsToday',
            'totalNewsletters',
            'newNewslettersToday',
            'totalEvents',
            'upcomingEvents',
            'totalEventRegistrations',
            'totalUniversities',
            'totalAdmissions',
            'activeAdmissions',
            'totalFunding',
            'totalBlogs',
            'recentConsultations',
            'recentNewsletters',
            'recentEvents',
            'consultationChart',
            'newsletterChart'
        ));
    }

    private function getLast7DaysData($model, $dateColumn)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = $model::whereDate($dateColumn, $date)->count();
            $data['labels'][] = $date->format('M d');
            $data['values'][] = $count;
        }
        return $data;
    }
}
