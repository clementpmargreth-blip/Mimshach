<x-admin-layout pageTitle="Universities Management">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Universities
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage partner universities and
          institutions</p>
      </div>
      <button
        class="from-primary to-accent focus:ring-primary inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2"
        onclick="openCreateModal()">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add University
      </button>
    </div>

    <!-- Filter Component -->
    <x-filter-bar :filters="$filters" :useAjax="true" contentId="universitiesList"
      paginationId="paginationContainer" />

    
      <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead
              class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
              <tr>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Image/Logo
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  University Name
                </th>
                <th
                  class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:table-cell sm:px-6 dark:text-gray-300">
                  Country
                </th>
                <th
                  class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:table-cell sm:px-6 dark:text-gray-300">
                  City
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Status
                </th>
                <th
                  class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
              id="universitiesList">
              <x-admin.universities.table :$universities />
            </tbody>
          </table>
        </div>
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
          id="paginationContainer">
          {{ $universities->links() }}
        </div>
      </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="universityModal">
    <div
      class="relative mx-auto my-10 w-full max-w-2xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div
        class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Add University
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
      <form enctype="multipart/form-data" id="universityForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="universityId" name="university_id" type="hidden">

        <div class="max-h-[60vh] space-y-4 overflow-y-auto p-6">
          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">University
              Name *</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="name" name="name" required type="text">
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Subtitle</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="subtitle" name="subtitle" type="text">
          </div>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Country
                *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="country" name="country" required type="text">
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">City
                *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="city" name="city" required type="text">
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Content
              *</label>
            <textarea
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="content" name="content" required rows="5"></textarea>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Featured
              Image</label>
            <input accept="image/*"
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="image" name="image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <img alt="Current image" class="h-24 w-24 rounded-lg object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
            <input accept="image/*"
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="logo" name="logo" type="file">
            <div class="mt-2 hidden" id="currentLogo">
              <img alt="Current logo" class="h-24 w-24 rounded-lg object-contain"
                id="currentLogoPreview" src="">
            </div>
          </div>
        </div>

        <div class="flex justify-end space-x-3 border-t border-gray-200 p-6 dark:border-gray-700">
          <button
            class="rounded-lg bg-gray-200 px-4 py-2 font-medium text-gray-700 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeModal()" type="button">Cancel</button>
          <button
            class="from-primary to-accent rounded-lg bg-gradient-to-r px-4 py-2 font-medium text-white transition hover:shadow-lg"
            type="submit">Save University</button>
        </div>
      </form>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add University';
        document.getElementById('method').value = 'POST';
        document.getElementById('universityForm').action = "{{ route('admin.universities.store') }}";
        document.getElementById('universityForm').reset();
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('currentLogo').classList.add('hidden');
        document.getElementById('universityModal').classList.remove('hidden');
      }

      function editUniversity(id) {
        fetch(`/admin/universities/${id}/edit`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit University';
            document.getElementById('method').value = 'PUT';
            document.getElementById('universityForm').action = `/admin/universities/${id}`;
            document.getElementById('universityId').value = id;
            document.getElementById('name').value = data.name;
            document.getElementById('subtitle').value = data.subtitle || '';
            document.getElementById('country').value = data.country;
            document.getElementById('city').value = data.city;
            document.getElementById('content').value = data.content;

            if (data.image) {
              document.getElementById('currentImagePreview').src = `/storage/${data.image}`;
              document.getElementById('currentImage').classList.remove('hidden');
            } else {
              document.getElementById('currentImage').classList.add('hidden');
            }

            if (data.logo) {
              document.getElementById('currentLogoPreview').src = `/storage/${data.logo}`;
              document.getElementById('currentLogo').classList.remove('hidden');
            } else {
              document.getElementById('currentLogo').classList.add('hidden');
            }

            document.getElementById('universityModal').classList.remove('hidden');
          })
          .catch(error => console.error('Error:', error));
      }

      function closeModal() {
        document.getElementById('universityModal').classList.add('hidden');
      }
    </script>
  </x-slot:scripts>
</x-admin-layout>
