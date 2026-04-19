<x-admin-layout pageTitle="Admissions Management">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Admissions
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage admission posts and deadlines
        </p>
      </div>
      <button
        class="from-primary to-accent focus:ring-primary inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2"
        onclick="openCreateModal()">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Admission
      </button>
    </div>

    <x-filter-bar :$filters contentId="admissionsList" paginationId="paginationContainer" />

      <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead
              class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
              <tr>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Image</th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Program</th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  University</th>
                <th
                  class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:table-cell sm:px-6 dark:text-gray-300">
                  Country</th>
                <th
                  class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 lg:table-cell dark:text-gray-300">
                  Year</th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Deadline</th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Status</th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
              id="admissionsList">
              <x-admin.admissions.table :$admissions />
            </tbody>
          </table>
        </div>
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
          id="paginationContainer">
          {{ $admissions->links() }}
        </div>
      </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="admissionModal">
    <div
      class="relative mx-auto my-10 w-full max-w-2xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div
        class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Add Admission
        </h3>
        <button
          class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form enctype="multipart/form-data" id="admissionForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="admissionId" name="admission_id" type="hidden">

        <div class="max-h-[60vh] space-y-4 overflow-y-auto p-6">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title
              *</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="title" name="title" required type="text">
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Subtitle</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="subtitle" name="subtitle" type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Program
              *</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="program" name="program" required type="text">
          </div>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Year
                *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="year" name="year" required type="number">
            </div>
            <div>
              <label
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Country
                *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="country" name="country" required type="text">
            </div>
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">University
              *</label>
            <select
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="university_id" name="university_id" required>
              <option value="">Select University</option>
              @foreach ($admissions->pluck('university') as $university)
                <option value="{{ $university->id }}">{{ $university->name }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Deadline
              *</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="deadline" name="deadline" required type="date">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Content
              *</label>
            <textarea
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="content" name="content" required rows="5"></textarea>
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
            <input accept="image/*"
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="image" name="image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <img alt="Current image" class="h-24 w-24 rounded-lg object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 p-6 dark:border-gray-700">
          <button
            class="rounded-lg bg-gray-200 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeModal()" type="button">Cancel</button>
          <button
            class="from-primary to-accent rounded-lg bg-gradient-to-r px-4 py-2 font-medium text-white transition hover:shadow-lg"
            type="submit">Save Admission</button>
        </div>
      </form>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      // Filter functionality
      document.getElementById('search').addEventListener('input', filterAdmissions);
      document.getElementById('programFilter').addEventListener('change', filterAdmissions);
      document.getElementById('countryFilter').addEventListener('change', filterAdmissions);
      document.getElementById('universityFilter').addEventListener('change', filterAdmissions);

      function filterAdmissions() {
        const search = document.getElementById('search').value;
        const program = document.getElementById('programFilter').value;
        const country = document.getElementById('countryFilter').value;
        const university = document.getElementById('universityFilter').value;

        fetch(
            `/admin/admissions/filter?search=${search}&program=${program}&country=${country}&university=${university}`
            )
          .then(response => response.json())
          .then(data => {
            document.getElementById('admissionsTableBody').innerHTML = data.html;
          });
      }

      function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add Admission';
        document.getElementById('method').value = 'POST';
        document.getElementById('admissionForm').action = "{{ route('admin.admission.store') }}";
        document.getElementById('admissionForm').reset();
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('admissionModal').classList.remove('hidden');
      }

      function editAdmission(id) {
        fetch(`/admin/admissions/${id}/edit`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Admission';
            document.getElementById('method').value = 'PUT';
            document.getElementById('admissionForm').action = `/admin/admissions/${id}`;
            document.getElementById('admissionId').value = id;
            document.getElementById('title').value = data.title;
            document.getElementById('subtitle').value = data.subtitle;
            document.getElementById('program').value = data.program;
            document.getElementById('year').value = data.year;
            document.getElementById('country').value = data.country;
            document.getElementById('university_id').value = data.university_id;
            document.getElementById('deadline').value = data.deadline;
            document.getElementById('content').value = data.content;

            if (data.image) {
              document.getElementById('currentImagePreview').src = `/storage/${data.image}`;
              document.getElementById('currentImage').classList.remove('hidden');
            }

            document.getElementById('admissionModal').classList.remove('hidden');
          });
      }

      function closeModal() {
        document.getElementById('admissionModal').classList.add('hidden');
      }
    </script>
  </x-slot:scripts>
</x-admin-layout>
