<x-admin-layout pageTitle="Newsletter Subscriptions">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Newsletter Subscriptions
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage email newsletter subscribers
        </p>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <div class="flex items-center">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900">
              <svg class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Subscribers</p>
              <p class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ number_format($totalSubscribers) }}</p>
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
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
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

      {{-- <div
        class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:shadow-xl dark:bg-gray-800">
        <div class="p-6">
          <div class="flex items-center">
            <div
              class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900">
              <svg class="h-6 w-6 text-orange-600 dark:text-orange-300" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
              </svg>
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Most Active Day</p>
              <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $mostActiveDay ? $mostActiveDay->day : 'N/A' }}</p>
            </div>
          </div>
        </div>
      </div> --}}
    </div>

    <!-- Filter Bar -->
    <x-filter-bar :$filters contentId="subscriptionsList" paginationId="paginationContainer" />

    <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead
            class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
            <tr>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Email</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Subscribed Date</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Status</th>
              {{-- <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Actions</th> --}}
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
            id="subscriptionsList">
            <x-admin.newsletter.table :$subscriptions />
          </tbody>
        </table>
      </div>
      <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
        id="paginationContainer">
        {{ $subscriptions->links() }}
      </div>
    </div>
  </div>
</x-admin-layout>
