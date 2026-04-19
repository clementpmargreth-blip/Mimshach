@if ($consultations->isEmpty())
  <tr>
    <td class="px-6 py-10 text-center text-gray-500 dark:text-gray-400" colspan="6">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Consultation Requests Found</p>
    </td>
  </tr>
@else
  @foreach ($consultations as $consultation)
    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <div class="text-sm font-medium text-gray-900 dark:text-white">
          {{ $consultation->name }}</div>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $consultation->phone }}
        </div>
      </td>
      <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 sm:px-6 dark:text-gray-300">
        {{ $consultation->email }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 text-sm sm:px-6">
        <span
          class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900 dark:text-blue-200">
          {{ $consultation->level_of_education }}
        </span>
      </td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:px-6 lg:table-cell dark:text-gray-300">
        <div class="max-w-xs flex gap-2 items-center">
          @foreach (array_slice($consultation->programme_of_interest, 0, 2) as $programme)
            <span
              class="inline-block rounded-full bg-gray-100 px-2 py-1 text-xs dark:bg-accent/20 dark:text-gray-300">
              {{ $programme }}
            </span>
          @endforeach
          @if (count($consultation->programme_of_interest) > 2)
            <span
              class="text-xs text-gray-500">+{{ count($consultation->programme_of_interest) - 2 }}
              more</span>
          @endif
        </div>
      </td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:px-6 xl:table-cell dark:text-gray-300">
        ${{ number_format($consultation->tuition_budget) }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 sm:px-6 dark:text-gray-400">
        {{ $consultation->created_at->format('M d, Y') }}
      </td>
      {{-- <td class="whitespace-nowrap px-4 py-4 text-sm font-medium sm:px-6">
        <div class="flex space-x-3">
          <a class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
            href="{{ route('admin.consultations.show', $consultation) }}">View</a>
          <form action="{{ route('admin.consultations.destroy', $consultation) }}" class="inline"
            method="POST" onsubmit="return confirm('Delete this consultation request?')">
            @csrf
            @method('DELETE')
            <button
              class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
              type="submit">Delete</button>
          </form>
        </div>
      </td> --}}
    </tr>
  @endforeach
@endif
