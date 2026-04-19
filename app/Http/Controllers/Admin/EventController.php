<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $cities = ['All Cities', ...Event::distinct()->pluck('location')->filter()->sort()->values()->toArray()];

        $filters = [
            [
                'type' => 'date',
                'name' => 'date_from',
                'placeholder' => 'Event From',
            ],
            [
                'type' => 'date',
                'name' => 'date_to',
                'placeholder' => 'Event To',
            ],
            [
                'type' => 'date',
                'name' => 'specific_date',
                'placeholder' => 'Specific Date',
            ],
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search events...',
            ],
            [
                'type' => 'select',
                'name' => 'city',
                'label' => 'City',
                'options' => $cities,
            ],
        ];

        // Get filtered events
        $query = Event::with('registrations');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('city') && $request->city !== 'All Cities') {
            $query->where('location', $request->city);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }
        if ($request->filled('specific_date')) {
            $query->whereDate('date', $request->specific_date);
        }

        $events = $query->orderBy('date', 'desc')->paginate(10);

        // Check if it's an AJAX request for filtering
        if ($request->ajax() && !$request->has('_method')) {
            $html = view('components.admin.events.event-list', compact('events'))->render();
            $pagination = $events->hasPages() ? $events->links() : '';

            return response()->json([
                'html' => $html,
                'pagination' => $pagination
            ]);
        }

        return view('admin.events.index', compact('events', 'filters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string',
            'timezone' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Event::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event created successfully',
            'event' => $event
        ]);
    }

    public function edit(Event $event)
    {
        return response()->json([
            'success' => true,
            'event' => $event
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string',
            'timezone' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Event updated successfully'
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event deleted successfully'
        ]);
    }

    public function registrations(Event $event)
    {
        return response()->json([
            'success' => true,
            'registrations' => $event->registrations
        ]);
    }
}
