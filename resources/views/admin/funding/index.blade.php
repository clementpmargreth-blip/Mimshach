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
      <button
        class="from-primary to-accent inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl"
        onclick="openFundingModal()">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Funding Opportunity
      </button>
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
      <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
        id="paginationContainer">
        {{ $fundings->links() }}
      </div>
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="fundingModal">
    <div
      class="relative mx-auto my-10 w-full max-w-2xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div
        class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Add Funding Opportunity</h3>
        <button
          class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeFundingModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.fundings.store') }}" class="p-6" enctype="multipart/form-data"
        id="fundingForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="fundingId" name="funding_id" type="hidden">

        <div class="max-h-[60vh] space-y-4 overflow-y-auto px-1">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Funding Name *</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="name" name="name" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description *</label>
            <textarea
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="description" name="description" required rows="5"></textarea>
          </div>

          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">University *</label>
              <select
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="university_id" name="university_id" required>
                <option value="">Select University</option>
                @foreach($universities as $university)
                  <option value="{{ $university->id }}">{{ $university->name }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Education Level *</label>
              <select
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="education_level" name="education_level" required>
                <option value="">Select Level</option>
                @foreach($fundings->pluck('education_level')->unique() as $level)
                  <option value="{{ $level }}">{{ $level }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Image</label>
            <input accept="image/*"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="image" name="image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">Current Image:</p>
              <img alt="Current image" class="h-24 w-24 rounded-lg object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>
        </div>

        <div
          class="mt-6 flex justify-end space-x-3 border-t border-gray-200 pt-4 dark:border-gray-700">
          <button
            class="rounded-lg bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeFundingModal()" type="button">Cancel</button>
          <button
            class="from-primary to-accent rounded-lg bg-gradient-to-r px-4 py-2 text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl"
            type="submit">Save Funding</button>
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
          <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Delete Funding Opportunity</h3>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete
            this funding opportunity? This action cannot be undone.</p>
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
        store: "{{ route('admin.fundings.store') }}",
        edit: (id) => `/admin/fundings/${id}/edit`,
        update: (id) => `/admin/fundings/${id}`,
        delete: (id) => `/admin/fundings/${id}`
      };

      // ==========================
      // MODAL HANDLING
      // ==========================
      window.openFundingModal = function() {
        const form = document.getElementById('fundingForm');
        document.getElementById('modalTitle').textContent = 'Add Funding Opportunity';
        document.getElementById('method').value = 'POST';
        form.action = routes.store;
        form.reset();
        document.getElementById('fundingId').value = '';
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('fundingModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      window.closeFundingModal = function() {
        document.getElementById('fundingModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      // ==========================
      // EDIT FUNDING
      // ==========================
      window.editFunding = async function(id) {
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
            throw new Error(data.message || 'Failed to load funding');
          }

          const funding = data.funding;
          const form = document.getElementById('fundingForm');

          document.getElementById('modalTitle').textContent = 'Edit Funding Opportunity';
          document.getElementById('method').value = 'PUT';
          form.action = routes.update(id);
          document.getElementById('fundingId').value = funding.id;

          // Populate fields
          document.getElementById('name').value = funding.name || '';
          document.getElementById('description').value = funding.description || '';
          document.getElementById('university_id').value = funding.university_id || '';
          document.getElementById('education_level').value = funding.education_level || '';

          // Image preview
          if (funding.image_url) {
            document.getElementById('currentImagePreview').src = funding.image_url;
            document.getElementById('currentImage').classList.remove('hidden');
          } else if (funding.image) {
            const imageUrl = funding.image.startsWith('http') ? funding.image :
              `/storage/${funding.image}`;
            document.getElementById('currentImagePreview').src = imageUrl;
            document.getElementById('currentImage').classList.remove('hidden');
          } else {
            document.getElementById('currentImage').classList.add('hidden');
          }

          document.getElementById('fundingModal').classList.remove('hidden');
          document.body.style.overflow = 'hidden';

        } catch (error) {
          console.error('Edit error:', error);
          showToast('error', 'Error loading funding data. Please refresh and try again.');
        }
      }

      // ==========================
      // DELETE FUNDING
      // ==========================
      window.deleteFunding = function(id) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = routes.delete(id);
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // ==========================
      // FORM SUBMISSION
      // ==========================
      document.getElementById('fundingForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        const fundingId = document.getElementById('fundingId').value;

        submitButton.innerHTML =
          '<svg class="mx-auto h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        submitButton.disabled = true;

        try {
          let url = this.action;

          if (fundingId) {
            url = routes.update(fundingId);
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
              closeFundingModal();
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
          showToast('error', 'An error occurred while saving the funding');
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
          showToast('error', 'An error occurred while deleting the funding');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }
      });

      // Close modals when clicking outside
      document.getElementById('fundingModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeFundingModal();
      });

      document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
      });
    </script>
  </x-slot:scripts>
</x-admin-layout>