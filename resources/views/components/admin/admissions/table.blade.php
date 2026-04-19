@if ($admissions->isEmpty())
  <tr>
    <td class="px-6 py-10 text-center text-gray-500 dark:text-gray-400" colspan="7">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path
          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
      </svg>
      <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No Admissions Found</p>
      <button
        class="bg-primary hover:bg-primary/90 mt-4 inline-flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-medium text-white transition cursor-pointer"
        onclick="openCreateModal()">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Admission
      </button>
    </td>
  </tr>
@else
  @forelse ($admissions as $admission)
    <tr
      class="border-b border-gray-200 transition-colors hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-700">
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @if ($admission->image)
          <img alt="{{ $admission->title }}" class="h-12 w-12 rounded-lg object-cover"
            src="{{ Storage::url($admission->image) }}">
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
        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $admission->program }}
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $admission->title }}</div>
      </td>
      <td class="px-4 py-4 text-sm text-gray-600 sm:px-6 dark:text-gray-300">
        {{ $admission->university->name }}</td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:table-cell sm:px-6 dark:text-gray-300">
        {{ $admission->country }}</td>
      <td class="hidden px-4 py-4 text-sm text-gray-600 sm:px-6 lg:table-cell dark:text-gray-300">
        {{ $admission->year }}</td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @php
          $deadline = \Carbon\Carbon::parse($admission->deadline);
          $isUrgent = $deadline->isPast();
          $isSoon = $deadline->diffInDays(now()) <= 7 && !$isUrgent;
        @endphp
        <div class="flex flex-col">
          <span
            class="{{ $isUrgent ? 'text-red-600' : ($isSoon ? 'text-orange-600' : 'text-gray-600 dark:text-gray-300') }} text-sm font-medium">
            {{ $deadline->format('M d, Y') }}
          </span>
          @if ($isUrgent)
            <span class="text-xs text-red-500">Expired</span>
          @elseif($isSoon)
            <span class="text-xs text-orange-500">{{ floor(now()->diffInDays($deadline)) }} days
              left</span>
          @endif
        </div>
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        @php
          $status = $admission->year - now()->year > 0 ? 'active' : 'inactive';
          $statusColors = [
              'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
              'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'
          ];
          $statusLabels = [
              'active' => 'Active',
              'inactive' => 'Inactive'
          ];
        @endphp
        <span
          class="{{ $statusColors[$status] }} inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold">
          {{ $statusLabels[$status] }}
        </span>
      </td>
      <td class="whitespace-nowrap px-4 py-4 sm:px-6">
        <div class="flex items-center space-x-2">
          <button
            class="rounded-lg p-1.5 text-blue-600 transition-colors hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20"
            onclick="editAdmission({{ $admission->id }})" title="Edit">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </button>
          <form action="{{ route('admin.admission.destroy', $admission) }}" class="inline"
            method="POST"
            onsubmit="return confirm('Are you sure you want to delete this admission?')">
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
          <button
            class="{{ $admission->is_active ? 'text-yellow-600 hover:bg-yellow-50 dark:text-yellow-400' : 'text-green-600 hover:bg-green-50 dark:text-green-400' }} rounded-lg p-1.5 transition-colors"
            onclick="toggleStatus({{ $admission->id }}, {{ $admission->is_active ? 0 : 1 }})"
            title="{{ $admission->is_active ? 'Deactivate' : 'Activate' }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              @if ($admission->is_active)
                <path
                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              @else
                <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              @endif
            </svg>
          </button>
        </div>
      </td>
    </tr>
  @empty
    <tr>
      <td class="px-4 py-12 text-center sm:px-6" colspan="8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
          viewBox="0 0 24 24">
          <path
            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No admissions found</p>
      </td>
    </tr>
  @endforelse
@endif
