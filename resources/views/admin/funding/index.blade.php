<x-admin-layout pageTitle="Funding Management">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Funding Opportunities
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage scholarships, grants, and funding opportunities</p>
      </div>
      <a class="from-primary to-accent inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl"
        href="{{ route('admin.funding.create') }}">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Funding Opportunity
      </a>
    </div>

    <!-- Filter Bar -->
    <x-filter-bar :$filters contentId="fundingList" paginationId="paginationContainer" />

      <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead
              class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
              <tr>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Image
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Name
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  University
                </th>
                <th
                  class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 md:table-cell dark:text-gray-300">
                  Education Level
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Created Date
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
              id="fundingList">
              <x-admin.funding.table :$fundings />
            </tbody>
          </table>
        </div>
        @if (isset($fundings) && method_exists($fundings, 'hasPages') && $fundings->hasPages())
          <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
            id="paginationContainer">
            {{ $fundings->links() }}
          </div>
        @endif
      </div>
  </div>
</x-admin-layout>