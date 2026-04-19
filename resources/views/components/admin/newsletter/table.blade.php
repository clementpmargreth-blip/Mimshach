@if ($subscriptions->isEmpty())
  <tr>
    <td class="px-6 py-10 text-center text-gray-500 dark:text-gray-400" colspan="3">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Subscriptions Found</p>
    </td>
  </tr>
@else
  @foreach ($subscriptions as $subscription)
    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
      <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 sm:px-6 dark:text-white">
        {{ $subscription->email }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 sm:px-6 dark:text-gray-400">
        {{ $subscription->subscribed_at ? $subscription->subscribed_at->format('M d, Y h:i A') : $subscription->created_at->format('M d, Y h:i A') }}
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <span
          class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">
          Active
        </span>
      </td>
      {{-- <td class="whitespace-nowrap px-4 py-4 text-sm font-medium sm:px-6">
        <form action="{{ route('admin.newsletter.destroy', $subscription) }}" class="inline"
          method="POST" onsubmit="return confirm('Delete this subscription?')">
          @csrf
          @method('DELETE')
          <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
            type="submit">Delete</button>
        </form>
      </td> --}}
    </tr>
  @endforeach
@endIf
