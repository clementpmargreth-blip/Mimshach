@if ($fundings->isEmpty())
  <tr>
    <td class="px-6 py-10 text-center text-gray-500 dark:text-gray-400" colspan="5">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Funding Opportunities Found</p>
      <button
        class="bg-primary hover:bg-primary/90 mt-4 inline-flex cursor-pointer items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition"
        onclick="openCreateModal()">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Funding
      </button>
    </td>
  </tr>
@else
  @foreach ($fundings as $funding)
    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @if ($funding->image)
          <img alt="{{ $funding->name }}" class="h-12 w-12 rounded-lg object-cover"
            src="{{ Storage::url($funding->image) }}">
        @else
          <div
            class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
          </div>
        @endif
      </td>
      <td class="px-4 py-4 sm:px-6">
        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $funding->name }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400">
          {{ Str::limit($funding->description, 50) }}</div>
      </td>
      <td class="px-4 py-4 text-sm text-gray-600 sm:px-6 dark:text-gray-300">
        {{ $funding->university->name }}
      </td>
      <td class="hidden px-4 py-4 text-sm sm:px-6 md:table-cell">
        <span
          class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900 dark:text-blue-200">
          {{ $funding->education_level }}
        </span>
      </td>
      <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 sm:px-6 dark:text-gray-400">
        {{ $funding->created_at->format('M d, Y') }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 text-sm font-medium sm:px-6">
        <div class="flex space-x-3">
          <button
            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
            onclick="editFunding({{ $funding->id }})"><svg class="h-5 w-5" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg></button>
          <form action="{{ route('admin.blog.destroy', $funding) }}" class="inline" method="POST"
            onsubmit="return confirm('Delete this blog post?')">
            @csrf
            @method('DELETE')
            <button
              class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
              type="submit">
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
