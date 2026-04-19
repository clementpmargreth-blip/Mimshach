<x-app-layout pageTitle='Admission Insights | Mimshach Education Centre'>

  <x-page-header subtitle="Stay updated with application deadlines, university news, and expert tips"
    title="Admission Insights" />

  <div class="mx-auto max-w-[1200px] px-4">

    <!-- Filter Bar -->
    <x-filter-bar :$filters contentId="blogList" paginationId="paginationContainer" classes='-mt-10' />

    <!-- Blog List -->
    <div class="mt-12 space-y-6" id="blogList">

      @if ($admissions->isEmpty())
        <div class="rounded-2xl bg-white p-10 text-center shadow-sm">
          <h3 class="text-lg font-semibold text-[var(--color-primary)]">
            No admission records found
          </h3>
          <p class="mt-2 text-sm text-gray-500">
            Please adjust your filters to see results.
          </p>
        </div>
      @else
        @foreach ($admissions as $admission)
          <x-admission.admission-card :$admission />
        @endforeach
      @endif

    </div>

    <!-- Pagination -->
    <div class="mt-12 flex justify-center" id="paginationContainer">
      @if ($admissions->hasPages())
        {{ $admissions->links('vendor.pagination.custom') }}
      @endif
    </div>

  </div>
</x-app-layout>
