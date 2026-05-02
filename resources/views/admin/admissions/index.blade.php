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
        class="from-primary to-accent inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl"
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
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Country
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
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-accent  dark:bg-gray-700 dark:text-white"
              id="university_id" name="university_id" required>
              <option value="">Select University</option>
              @foreach (\App\Models\University::orderBy('name')->get() as $university)
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

  <!-- Delete Confirmation Modal -->
  <div class="fixed inset-0 z-50 hidden place-items-center bg-black/50 backdrop-blur-sm"
    id="deleteModal">
    <div class="flex min-h-full items-center justify-center p-4">
      <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-800">
        <div class="text-center">
          <div
            class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900">
            <svg class="h-6 w-6 text-red-600 dark:text-red-200" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
          </div>
          <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Delete Admission
          </h3>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete
            this admission? This action cannot be undone.</p>
          <form class="mt-6 flex justify-center space-x-3" id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button
              class="rounded-lg bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
              onclick="closeDeleteModal()" type="button">Cancel</button>
            <button class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700"
              type="submit">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      // Routes configuration
      const routes = {
        store: "{{ route('admin.admissions.store') }}",
        edit: (id) => `/admin/admissions/${id}/edit`,
        update: (id) => `/admin/admissions/${id}`,
        delete: (id) => `/admin/admissions/${id}`
      };

      // Open Create Modal
      window.openCreateModal = function() {
        const form = document.getElementById('admissionForm');
        document.getElementById('modalTitle').textContent = 'Add Admission';
        document.getElementById('method').value = 'POST';
        form.action = routes.store;
        form.reset();
        document.getElementById('admissionId').value = '';
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('admissionModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // Close Modal
      window.closeModal = function() {
        document.getElementById('admissionModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
        document.body.style.overflow = 'auto';
      }

      // Edit Admission
      window.editAdmission = async function(id) {
        console.log('Editing admission ID:', id);

        try {
          const response = await fetch(routes.edit(id), {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest',
            }
          });

          if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
          }

          const data = await response.json();

          if (!data.success) {
            throw new Error(data.message || 'Failed to load admission');
          }

          const admission = data.admission;
          const form = document.getElementById('admissionForm');

          document.getElementById('modalTitle').textContent = 'Edit Admission';
          document.getElementById('method').value = 'PUT';
          form.action = routes.update(admission.id);
          document.getElementById('admissionId').value = admission.id;

          // Populate fields
          document.getElementById('title').value = admission.title || '';
          document.getElementById('subtitle').value = admission.subtitle || '';
          document.getElementById('program').value = admission.program || '';
          document.getElementById('year').value = admission.year || '';
          document.getElementById('country').value = admission.country || '';
          document.getElementById('university_id').value = admission.university_id || '';
          document.getElementById('deadline').value = admission.formatted_deadline || '';
          document.getElementById('content').value = admission.content || '';

          // Image preview
          if (admission.image) {
            const imageUrl = admission.image.startsWith('http') ? admission.image :
              `/storage/${admission.image}`;
            document.getElementById('currentImagePreview').src = imageUrl;
            document.getElementById('currentImage').classList.remove('hidden');
          } else {
            document.getElementById('currentImage').classList.add('hidden');
          }

          document.getElementById('admissionModal').classList.remove('hidden');
          document.body.style.overflow = 'hidden';

        } catch (error) {
          console.error('Edit error:', error);
          showToast('error', 'Error loading admission data. Please refresh and try again.');
        }
      }

      // Delete Admission
      window.deleteAdmission = function(id) {
        currentDeleteId = id;
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = routes.delete(id);
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // Form Submission
      document.getElementById('admissionForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        const isEdit = document.getElementById('admissionId').value;

        submitButton.innerHTML =
          '<svg class="mx-auto h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        submitButton.disabled = true;

        try {
          let url = this.action;

          if (isEdit) {
            url = routes.update(isEdit);
            formData.append('_method', 'PUT');
          }

          const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            }
          });

          const text = await response.text();
          console.log(text);

          try {
            const data = JSON.parse(text);

            if (data.success) {
              closeModal();
              showToast('success', data.message);
              setTimeout(() => location.reload(), 1500);
            } else {
              showToast('error', data.message || 'An error occurred');
              submitButton.innerHTML = originalText;
              submitButton.disabled = false;
            }
          } catch (e) {
            console.error('Non-JSON response:', text);
            showToast('error', 'Server returned an invalid response');
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
          }

        } catch (error) {
          console.error('Submit error:', error);
          showToast('error', 'An error occurred while saving the admission');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }
      });

      document.getElementById('deleteForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        submitButton.innerHTML =
          '<svg class="mx-auto h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        submitButton.disabled = true;

        try {
          const formData = new FormData(this);
          const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const data = await response.json();

          if (data.success) {
            closeDeleteModal();
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
          } else {
            showToast('error', data.message || 'An error occurred');
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
          }
        } catch (error) {
          console.error('Delete error:', error);
          showToast('error', 'An error occurred while deleting the event');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }
      });

      // Close modal when clicking outside
      document.getElementById('admissionModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeModal();
      });

      document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
      });
    </script>
  </x-slot:scripts>
</x-admin-layout>
