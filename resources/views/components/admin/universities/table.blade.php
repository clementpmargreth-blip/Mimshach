@if ($universities->isEmpty())
  <tr>
    <td class="px-4 py-12 text-center sm:px-6" colspan="6">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Universities Found</p>
      <button
        class="bg-primary hover:bg-primary/90 mt-4 inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition cursor-pointer"
        onclick="openCreateModal()">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add University
      </button>
    </td>
  </tr>
@else
  @foreach ($universities as $university)
    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <div class="flex items-center space-x-2">
          @if ($university->logo)
            <img alt="{{ $university->name }} logo" class="h-10 w-10 rounded-lg object-contain"
              src="{{ Storage::url($university->logo) }}">
          @else
            <div
              class="from-primary/10 to-accent/10 flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br">
              <svg class="text-primary h-5 w-5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              </svg>
            </div>
          @endif

          @if ($university->image)
            <img alt="{{ $university->name }}" class="h-10 w-10 rounded-lg object-cover"
              src="{{ Storage::url($university->image) }}">
          @endif
        </div>
      </td>
      <td class="px-4 py-4 sm:px-6">
        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $university->name }}
        </div>
        @if ($university->subtitle)
          <div class="text-xs text-gray-500 dark:text-gray-400">
            {{ Str::limit($university->subtitle, 50) }}</div>
        @endif
      </td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:table-cell sm:px-6 dark:text-gray-300">
        {{ $university->country }}
      </td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:table-cell sm:px-6 dark:text-gray-300">
        {{ $university->city }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @php
          $hasAdmissions = $university->admissions()->count() > 0;
          $hasActiveAdmissions =
              $university->admissions()->where('deadline', '>=', now())->count() > 0;
        @endphp
        <div class="flex flex-col space-y-1">
          <span
            class="{{ $hasAdmissions ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }} inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold">
            {{ $hasAdmissions ? 'Has Admissions' : 'No Admissions' }}
          </span>
          @if ($hasActiveAdmissions)
            <span class="text-xs text-blue-600 dark:text-blue-400">Active admissions open</span>
          @endif
        </div>
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <div class="flex items-center space-x-2">
          <button
            class="rounded-lg p-1.5 text-blue-600 transition-colors hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20"
            onclick="editUniversity({{ $university->id }})" title="Edit">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </button>
          <form action="{{ route('admin.universities.destroy', $university) }}" class="inline"
            method="POST"
            onsubmit="return confirm('Are you sure you want to delete this university? This will also delete all associated admissions.')">
            @csrf
            @method('DELETE')
            <button
              class="rounded-lg p-1.5 text-red-600 transition-colors hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20"
              title="Delete" type="submit">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              </svg>
            </button>
          </form>
        </div>
      </td>
    </tr>
  @endforeach
@endif
