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
        class="from-primary to-accent inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl"
        onclick="openUniversityModal()">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add University
      </button>
    </div>

    <!-- Filter Component -->
    <x-filter-bar :$filters contentId="universitiesList" paginationId="paginationContainer" />

    <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead
            class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
            <tr>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Logo
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
          onclick="closeUniversityModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.universities.store') }}" class="p-6" enctype="multipart/form-data"
        id="universityForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="universityId" name="university_id" type="hidden">

        <div class="max-h-[60vh] space-y-4 overflow-y-auto px-1">
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
              class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="image" name="image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">Current Image:</p>
              <img alt="Current image" class="h-24 w-24 rounded-lg object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Logo</label>
            <input accept="image/*"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="logo" name="logo" type="file">
            <div class="mt-2 hidden" id="currentLogo">
              <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">Current Logo:</p>
              <img alt="Current logo" class="h-24 w-24 rounded-lg object-contain"
                id="currentLogoPreview" src="">
            </div>
          </div>
        </div>

        <div
          class="mt-6 flex justify-end space-x-3 border-t border-gray-200 pt-4 dark:border-gray-700">
          <button
            class="rounded-lg bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeUniversityModal()" type="button">Cancel</button>
          <button
            class="from-primary to-accent rounded-lg bg-gradient-to-r px-4 py-2 text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl"
            type="submit">Save University</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="fixed inset-0 z-50 hidden place-items-center bg-black/50 backdrop-blur-sm" id="deleteModal">
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
          <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Delete University</h3>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete
            this university? This action cannot be undone.</p>
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

  <!-- Admissions Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="admissionsModal">
    <div
      class="relative mx-auto my-10 w-full max-w-4xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div
        class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">University Admissions</h3>
        <button
          class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeAdmissionsModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <div class="overflow-x-auto p-6" id="admissionsContent">
        <div class="flex items-center justify-center py-8">
          <div
            class="border-primary h-8 w-8 animate-spin rounded-full border-4 border-t-transparent">
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      let currentDeleteId = null;

      // Routes configuration
      const routes = {
        store: "{{ route('admin.universities.store') }}",
        edit: (id) => `/admin/universities/${id}/edit`,
        update: (id) => `/admin/universities/${id}`,
        delete: (id) => `/admin/universities/${id}`,
        admissions: (id) => `/admin/universities/${id}/admissions`
      };

      // ==========================
      // MODAL HANDLING
      // ==========================
      window.openUniversityModal = function() {
        const form = document.getElementById('universityForm');
        document.getElementById('modalTitle').textContent = 'Add University';
        document.getElementById('method').value = 'POST';
        form.action = routes.store;
        form.reset();
        document.getElementById('universityId').value = '';
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('currentLogo').classList.add('hidden');
        document.getElementById('universityModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      window.closeUniversityModal = function() {
        document.getElementById('universityModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
        document.body.style.overflow = 'auto';
      }

      window.closeAdmissionsModal = function() {
        document.getElementById('admissionsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      // ==========================
      // EDIT UNIVERSITY
      // ==========================
      window.editUniversity = async function(id) {
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
            throw new Error(data.message || 'Failed to load university');
          }

          const university = data.university;
          const form = document.getElementById('universityForm');

          document.getElementById('modalTitle').textContent = 'Edit University';
          document.getElementById('method').value = 'PUT';
          form.action = routes.update(id);
          document.getElementById('universityId').value = university.id;

          // Populate fields
          document.getElementById('name').value = university.name || '';
          document.getElementById('subtitle').value = university.subtitle || '';
          document.getElementById('content').value = university.content || '';
          document.getElementById('country').value = university.country || '';
          document.getElementById('city').value = university.city || '';

          // Image preview
          if (university.image_url) {
            document.getElementById('currentImagePreview').src = university.image_url;
            document.getElementById('currentImage').classList.remove('hidden');
          } else if (university.image) {
            const imageUrl = university.image.startsWith('http') ? university.image :
              `/storage/${university.image}`;
            document.getElementById('currentImagePreview').src = imageUrl;
            document.getElementById('currentImage').classList.remove('hidden');
          } else {
            document.getElementById('currentImage').classList.add('hidden');
          }

          // Logo preview
          if (university.logo_url) {
            document.getElementById('currentLogoPreview').src = university.logo_url;
            document.getElementById('currentLogo').classList.remove('hidden');
          } else if (university.logo) {
            const logoUrl = university.logo.startsWith('http') ? university.logo :
              `/storage/${university.logo}`;
            document.getElementById('currentLogoPreview').src = logoUrl;
            document.getElementById('currentLogo').classList.remove('hidden');
          } else {
            document.getElementById('currentLogo').classList.add('hidden');
          }

          document.getElementById('universityModal').classList.remove('hidden');
          document.body.style.overflow = 'hidden';

        } catch (error) {
          console.error('Edit error:', error);
          showToast('error', 'Error loading university data. Please refresh and try again.');
        }
      }

      // ==========================
      // DELETE UNIVERSITY
      // ==========================
      window.deleteUniversity = function(id) {
        currentDeleteId = id;
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = routes.delete(id);
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // ==========================
      // VIEW ADMISSIONS
      // ==========================
      window.viewAdmissions = async function(universityId) {
        console.log('View Admissions called for university ID:', universityId);
        const modal = document.getElementById('admissionsModal');
        const content = document.getElementById('admissionsContent');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        content.innerHTML =
          '<div class="flex items-center justify-center py-8"><div class="h-8 w-8 animate-spin rounded-full border-4 border-primary border-t-transparent"></div></div>';

        try {
          const response = await fetch(routes.admissions(universityId), {
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
          }

          const data = await response.json();

          if (!data.success) {
            throw new Error(data.message || 'Failed to load admissions');
          }

          const admissions = data.admissions;

          if (admissions.length === 0) {
            content.innerHTML = `
              <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                </svg>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No admissions found for this university</p>
              </div>
            `;
            return;
          }

          let html = `
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
              <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Title</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Program</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Deadline</th>
                  <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
          `;

          admissions.forEach(admission => {
            const deadline = new Date(admission.deadline);
            const isActive = deadline >= new Date();
            html += `
              <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">${escapeHtml(admission.title)}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${escapeHtml(admission.program)}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${deadline.toLocaleDateString()}</td>
                <td class="whitespace-nowrap px-6 py-4">
                  <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${isActive ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'}">
                    ${isActive ? 'Active' : 'Expired'}
                  </span>
                </td>
              </tr>
            `;
          });

          html += `
              </tbody>
            </table>
          `;
          content.innerHTML = html;

        } catch (error) {
          console.error('Admissions error:', error);
          content.innerHTML = `
            <div class="text-center py-8">
              <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
              </svg>
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">Error loading admissions</p>
            </div>
          `;
        }
      }

      // ==========================
      // FORM SUBMISSION
      // ==========================
      document.getElementById('universityForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        const universityId = document.getElementById('universityId').value;

        submitButton.innerHTML =
          '<svg class="mx-auto h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        submitButton.disabled = true;

        try {
          let url = this.action;

          // If editing, use the update route with ID
          if (universityId) {
            url = routes.update(universityId);
            formData.append('_method', 'PUT');
          }

          // Debug logging
          console.log('Submitting to URL:', url);
          console.log('Is Edit:', !!universityId);

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
              closeUniversityModal();
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
          showToast('error', 'An error occurred while saving the university');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }
      });

      // Delete form submission
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
          showToast('error', 'An error occurred while deleting the university');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }
      });

      function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Close modals when clicking outside
      document.getElementById('universityModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeUniversityModal();
      });

      document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
      });

      document.getElementById('admissionsModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeAdmissionsModal();
      });
    </script>
  </x-slot:scripts>
</x-admin-layout>