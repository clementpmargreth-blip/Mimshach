<x-admin-layout pageTitle="Consultation Requests">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Consultation Requests
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage student consultation requests
        </p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <div class="flex items-center">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900">
              <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Consultations
              </p>
              <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ number_format($totalConsultations) }}</p>
            </div>
          </div>
        </div>
      </div>

      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <div class="flex items-center">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900">
              <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                  stroke-linejoin="round" stroke-width="2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New This Week</p>
              <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                +{{ number_format($newThisWeek) }}</p>
            </div>
          </div>
        </div>
      </div>

      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <div class="flex items-center">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900">
              <svg class="h-6 w-6 text-purple-600 dark:text-purple-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M12 8c-3.31 0-6 2.69-6 6 0 3.31 2.69 6 6 6 3.31 0 6-2.69 6-6 0-3.31-2.69-6-6-6z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                <path d="M12 2v2M12 20v2M4 4l2 2M18 4l-2 2M4 20l2-2M18 20l-2-2"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">New This Month</p>
              <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                +{{ number_format($newThisMonth) }}</p>
            </div>
          </div>
        </div>
      </div>

      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <div class="flex items-center">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900">
              <svg class="h-6 w-6 text-orange-600 dark:text-orange-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg. Budget</p>
              <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                ${{ number_format($avgBudget, 0) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Education Level</p>
          <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
            {{ $topEducationLevel ? $topEducationLevel->level_of_education : 'N/A' }}</p>
          <p class="mt-1 text-sm text-gray-500">
            {{ $topEducationLevel ? $topEducationLevel->count . ' requests' : '' }}</p>
        </div>
      </div>

      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Programme of Interest
          </p>
          <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">
            {{ $topProgramme ?? 'N/A' }}</p>
        </div>
      </div>

      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Top Preferred Country</p>
          <p class="mt-2 text-xl font-bold text-gray-900 dark:text-white">{{ $topCountry ?? 'N/A' }}
          </p>
        </div>
      </div>
    </div>

    <!-- Filter Bar -->
    <x-filter-bar :$filters contentId="consultationsList" paginationId="paginationContainer" />

    <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead
            class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
            <tr>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Name</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Email</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Education Level</th>
              <th
                class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 lg:table-cell dark:text-gray-300">
                Programme</th>
              <th
                class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 xl:table-cell dark:text-gray-300">
                Budget</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Date</th>
              {{-- <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Actions</th> --}}
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
            id="consultationsList">
            <x-admin.consultation.table :$consultations />
          </tbody>
        </table>
      </div>
      @if (isset($consultations) && method_exists($consultations, 'hasPages') && $consultations->hasPages())
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
          id="paginationContainer">
          {{ $consultations->links() }}
        </div>
      @endif
    </div>
  </div>
</x-admin-layout>
