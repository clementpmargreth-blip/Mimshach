<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search by email...',
            ],
            [
                'type' => 'date',
                'name' => 'date_from',
                'placeholder' => 'Subscribed From',
            ],
            [
                'type' => 'date',
                'name' => 'date_to',
                'placeholder' => 'Subscribed To',
            ],
        ];

        // Get filtered subscriptions
        $query = NewsletterSubscription::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('subscribed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('subscribed_at', '<=', $request->date_to);
        }

        $subscriptions = $query->orderBy('subscribed_at', 'desc')->paginate(6);

        // Get statistics
        $totalSubscribers = NewsletterSubscription::count();
        $newThisWeek = NewsletterSubscription::where('subscribed_at', '>=', Carbon::now()->startOfWeek())->count();
        $newThisMonth = NewsletterSubscription::where('subscribed_at', '>=', Carbon::now()->startOfMonth())->count();

        // Get most active day
        // $mostActiveDay = NewsletterSubscription::selectRaw('DAYNAME(subscribed_at) as day, COUNT(*) as count')
        //     ->groupBy('day')
        //     ->orderBy('count', 'desc')
        //     ->first();

        // Check if it's an AJAX request
        // if ($request->ajax()) {
        //     $html = view('components.admin.newsletter.table', compact('subscriptions'))->render();
        //     $pagination = $subscriptions->hasPages() ? $subscriptions->links() : '';

        //     return response()->json([
        //         'html' => $html,
        //         'pagination' => $pagination
        //     ]);
        // }

        return view('admin.newsletter.index', compact('subscriptions', 'filters', 'totalSubscribers', 'newThisWeek', 'newThisMonth'));
    }

    public function destroy(NewsletterSubscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.newsletter.index')->with('success', 'Subscription deleted successfully');
    }

    public function export(Request $request)
    {
        $query = NewsletterSubscription::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('subscribed_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('subscribed_at', '<=', $request->date_to);
        }

        $subscriptions = $query->orderBy('subscribed_at', 'desc')->get();

        // CSV export
        $csv = "Email,Subscribed Date\n";
        foreach ($subscriptions as $subscription) {
            $csv .= "{$subscription->email},{$subscription->subscribed_at}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="newsletter-subscribers-' . date('Y-m-d') . '.csv"');
    }
}
