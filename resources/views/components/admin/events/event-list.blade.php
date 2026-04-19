@if ($events->isEmpty())
  <tr>
    <td class="px-6 py-10 text-center text-gray-500 dark:text-gray-400" colspan="7">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Events Found</p>
      <button
        class="bg-primary hover:bg-primary/90 mt-4 inline-flex cursor-pointer items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition"
        onclick="openCreateModal()">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Event
      </button>
    </td>
  </tr>
@else
  @foreach ($events as $event)
    @php
      $now = now();
      $eventDate = null;
      $startDateTime = null;
      $endDateTime = null;
      $isPast = false;
      $statusColor = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
      $statusLabel = 'Draft';
      $formattedDate = 'Date not set';
      $daysUntil = null;

      if (isset($event->date) && !empty($event->date)) {
          try {
              $eventDate = \Carbon\Carbon::parse($event->date);
              $formattedDate = $eventDate->format('M d, Y');
              $startTime = $event->start_time ?? '00:00:00';
              $endTime = $event->end_time ?? '23:59:59';
              $startDateTime = \Carbon\Carbon::parse($event->date . ' ' . $startTime);
              $endDateTime = \Carbon\Carbon::parse($event->date . ' ' . $endTime);
              $daysUntil = $now->diffInDays($eventDate, false);

              if ($now->gt($endDateTime)) {
                  $statusColor = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                  $statusLabel = 'Completed';
                  $isPast = true;
              } elseif ($now->between($startDateTime, $endDateTime)) {
                  $statusColor =
                      'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                  $statusLabel = 'Ongoing';
                  $isPast = false;
              } else {
                  $statusColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                  $statusLabel = 'Upcoming';
                  $isPast = false;
              }
          } catch (\Exception $e) {
          }
      }
    @endphp
    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @if (!empty($event->image))
          <img alt="{{ $event->title }}" class="h-12 w-12 rounded-lg object-cover"
            src="{{ Storage::url($event->image) }}">
        @else
          <div
            class="from-primary/10 to-accent/10 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br">
            <svg class="text-primary h-6 w-6" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </div>
        @endif
      </td>
      <td class="px-4 py-4 sm:px-6">
        <div class="text-sm font-semibold text-gray-900 dark:text-white">
          {{ $event->title ?? 'Untitled' }}</div>
        @if (!empty($event->subtitle))
          <div class="text-xs text-gray-500 dark:text-gray-400">{{ $event->subtitle }}</div>
        @endif
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @if ($eventDate)
          <div class="flex flex-col">
            <span
              class="{{ $isPast ? 'text-gray-500' : 'text-gray-900 dark:text-white' }} text-sm font-medium">
              {{ $formattedDate }}
            </span>
            @if ($statusLabel === 'Upcoming' && $daysUntil !== null && $daysUntil >= 0)
              <span class="text-xs text-green-600 dark:text-green-400">
                @if ($daysUntil == 0)
                  Tomorrow
                @elseif($daysUntil == 1)
                  Tomorrow
                @else
                  {{ $daysUntil }} days away
                @endif
              </span>
            @elseif($statusLabel === 'Ongoing')
              <span class="text-xs text-green-600 dark:text-green-400">Happening now!</span>
            @elseif($statusLabel === 'Completed')
              <span class="text-xs text-gray-500">Ended</span>
            @endif
          </div>
        @else
          <div class="flex flex-col">
            <span class="text-sm text-gray-500">Date not set</span>
            <span class="text-xs text-red-500">Please edit to add date</span>
          </div>
        @endif
      </td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:px-6 md:table-cell dark:text-gray-300">
        {{ $event->location ?? 'N/A' }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <span
          class="bg-primary/10 text-primary inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold">
          <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          {{ $event->registrations->count() }}
        </span>
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <span
          class="{{ $statusColor }} inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold">
          {{ $statusLabel }}
        </span>
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <div class="flex items-center space-x-2">
          <button
            class="rounded-lg p-1.5 text-blue-600 transition-colors hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 cursor-pointer"
            onclick="editEvent({{ $event->id }})" title="Edit">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </button>
          <button
            class="rounded-lg p-1.5 text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 cursor-pointer"
            onclick="deleteEvent({{ $event->id }})" title="Delete">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </button>
          <button
            class="rounded-lg p-1.5 text-green-600 transition-colors hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-900/20 cursor-pointer"
            onclick="viewRegistrations({{ $event->id }})" title="View Registrations">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </button>
        </div>
      </td>
    </tr>
  @endforeach
@endif
