@props(['events'])

@forelse($events as $event)
<tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
    <td class="px-4 py-4 sm:px-6">
        @if($event->image_url)
            <img src="{{ $event->image_url }}" 
                 alt="{{ $event->title }}" 
                 class="h-12 w-12 rounded-lg object-cover">
        @else
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
            </div>
        @endif
    </td>
    <td class="px-4 py-4 sm:px-6">
        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $event->title }}</div>
        @if($event->subtitle)
            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $event->subtitle }}</div>
        @endif
    </td>
    <td class="px-2 py-4 sm:px-4">
        <div class="text-sm text-gray-900 dark:text-white">{{ $event->date->format('M d, Y') }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $event->display_start_time }} - {{ $event->display_end_time }} ({{ $event->timezone_abbr }})</div>
    </td>
    <td class="px-4 py-4 sm:px-6 md:table-cell">
        <div class="text-sm text-gray-900 dark:text-white">{{ $event->location }}</div>
    </td>
    <td class="px-4 py-4 sm:px-6">
        <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-200">
            {{ $event->registrations->count() }}
        </span>
    </td>
    <td class="px-4 py-4 sm:px-6">
        {!! $event->status_label !!}
    </td>
    <td class="px-4 py-4 sm:px-6">
        <div class="flex space-x-2">
            <button onclick="viewRegistrations({{ $event->id }})" 
                    class="rounded-lg bg-indigo-100 p-2 text-indigo-600 transition-colors hover:bg-indigo-200 dark:bg-indigo-900/50 dark:text-indigo-400 dark:hover:bg-indigo-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
            </button>
            <button onclick="editEvent({{ $event->id }})" 
                    class="rounded-lg bg-blue-100 p-2 text-blue-600 transition-colors hover:bg-blue-200 dark:bg-blue-900/50 dark:text-blue-400 dark:hover:bg-blue-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
            </button>
            <button onclick="deleteEvent({{ $event->id }})" 
                    class="rounded-lg bg-red-100 p-2 text-red-600 transition-colors hover:bg-red-200 dark:bg-red-900/50 dark:text-red-400 dark:hover:bg-red-900">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
  <td class="px-4 py-12 text-center sm:px-6" colspan="7">
    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
      viewBox="0 0 24 24">
      <path
        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
    </svg>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Events Found</p>
    <button
      class="bg-primary hover:bg-primary/90 mt-4 inline-flex cursor-pointer items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition"
      onclick="openEventModal()">
      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
        </path>
      </svg>
      Create Event
    </button>
  </td>
</tr>
@endforelse