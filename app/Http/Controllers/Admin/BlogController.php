<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Get unique authors for filter
        $authors = ['All Authors', ...Blog::with('user')->get()->pluck('user.name')->unique()->filter()->sort()->values()->toArray()];

        $filters = [
            [
                'type' => 'select',
                'name' => 'author',
                'label' => 'Author',
                'options' => $authors,
            ],
            [
                'type' => 'date',
                'name' => 'date_from',
                'placeholder' => 'Blog From',
            ],
            [
                'type' => 'date',
                'name' => 'date_to',
                'placeholder' => 'Blog To',
            ],
            [
                'type' => 'date',
                'name' => 'specific_date',
                'placeholder' => 'Specific Date',
            ],
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search blogs...',
            ],
        ];

        // Get filtered blogs
        $query = Blog::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('author') && $request->author !== 'All Authors') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', $request->author);
            });
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

        $blogs = $query->orderBy('created_at', 'desc')->paginate(6);

        // Return full view for regular requests
        return view('admin.blogs.index', compact('blogs', 'filters'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully');
    }
}
