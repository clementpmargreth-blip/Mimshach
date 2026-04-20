<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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

        $events = $query->orderBy('id', 'desc')->paginate();

        return view('admin.events.index', compact('events', 'filters'));
    }

    public function store(Request $request)
    {
        try {
            Log::info('Store method called', $request->all());

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

            $validated['slug'] = Str::slug($validated['title']);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('events', 'public');
            }

            $event = Event::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Event created successfully',
                'event' => $event
            ]);
        } catch (\Exception $e) {
            Log::error('Store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating event: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $event = Event::findOrFail($id);

            // Format dates for form inputs
            $eventData = $event->toArray();
            $eventData['formatted_date'] = Carbon::parse($event->date)->format('Y-m-d');
            $eventData['formatted_start_time'] = Carbon::parse($event->start_time)->format('H:i');
            $eventData['formatted_end_time'] = Carbon::parse($event->end_time)->format('H:i');

            return response()->json([
                'success' => true,
                'event' => $event
            ]);
        } catch (\Exception $e) {
            Log::error('Edit error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);

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

            $validated['slug'] = Str::slug($validated['title']);

            if ($request->hasFile('image')) {
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                $validated['image'] = $request->file('image')->store('events', 'public');
            }

            $event->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Event updated successfully',
                'event' => $event
            ]);
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating event: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);

            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting event: ' . $e->getMessage()
            ], 500);
        }
    }

    public function registrations($id)
    {
        try {
            $event = Event::with('registrations')->findOrFail($id);

            return response()->json([
                'success' => true,
                'registrations' => $event->registrations
            ]);
        } catch (\Exception $e) {
            Log::error('Registrations error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading registrations'
            ], 404);
        }
    }
}
