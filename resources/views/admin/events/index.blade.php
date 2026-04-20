<x-admin-layout pageTitle="Events Management">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Events
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your events and event
          registrations</p>
      </div>
      <button
        class="from-primary to-accent inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl"
        onclick="openEventModal()">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Create Event
      </button>
    </div>

    <!-- Filter Bar -->
    <x-filter-bar :$filters contentId="eventsList" paginationId="paginationContainer" />

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
                Title</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Date</th>
              <th
                class="hidden px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 md:table-cell dark:text-gray-300">
                Location</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Registrations</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Status</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800"
            id='eventsList'>
            <x-admin.events.event-list :$events />
          </tbody>
        </table>
      </div>
      <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
        id="paginationContainer">
        {{ $events->links() }}
      </div>
    </div>
  </div>

  <!-- Event Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="eventModal">
    <div
      class="relative mx-auto my-10 w-full max-w-4xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div
        class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Create Event
        </h3>
        <button
          class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeEventModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.events.store') }}" class="p-6" enctype="multipart/form-data"
        id="eventForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="eventId" name="event_id" type="hidden">

        <div class="max-h-[60vh] space-y-4 overflow-y-auto px-1">
          <div class="grid gap-4 md:grid-cols-2">
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
          </div>

          <div>
            <label
              class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description
              *</label>
            <textarea
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="description" name="description" required rows="5"></textarea>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Date
                *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="date" name="date" required type="date">
            </div>
            <div>
              <label
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Location
                *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="location" name="location" required type="text">
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                Time *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="start_time" name="start_time" required type="time">
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">End
                Time *</label>
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="end_time" name="end_time" required type="time">
            </div>
          </div>

          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone
                *</label>
              <select
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="timezone" name="timezone" required>
                <option value="">Select Timezone</option>
                <option value="UTC">UTC</option>
                <option value="Africa/Lagos">Africa/Lagos (West Africa Time)</option>
                <option value="Africa/Cairo">Africa/Cairo (Eastern European Time)</option>
                <option value="Africa/Johannesburg">Africa/Johannesburg (South Africa Standard
                  Time)</option>
                <option value="America/New_York">America/New_York (Eastern Time)</option>
                <option value="America/Chicago">America/Chicago (Central Time)</option>
                <option value="America/Denver">America/Denver (Mountain Time)</option>
                <option value="America/Los_Angeles">America/Los_Angeles (Pacific Time)</option>
                <option value="America/Toronto">America/Toronto (Eastern Time - Canada)</option>
                <option value="America/Sao_Paulo">America/Sao_Paulo (Brasilia Time)</option>
                <option value="Europe/London">Europe/London (Greenwich Mean Time)</option>
                <option value="Europe/Paris">Europe/Paris (Central European Time)</option>
                <option value="Europe/Berlin">Europe/Berlin (Central European Time)</option>
                <option value="Europe/Rome">Europe/Rome (Central European Time)</option>
                <option value="Europe/Madrid">Europe/Madrid (Central European Time)</option>
                <option value="Europe/Moscow">Europe/Moscow (Moscow Time)</option>
                <option value="Asia/Dubai">Asia/Dubai (Gulf Standard Time)</option>
                <option value="Asia/Riyadh">Asia/Riyadh (Arabian Standard Time)</option>
                <option value="Asia/Kolkata">Asia/Kolkata (Indian Standard Time)</option>
                <option value="Asia/Shanghai">Asia/Shanghai (China Standard Time)</option>
                <option value="Asia/Tokyo">Asia/Tokyo (Japan Standard Time)</option>
                <option value="Asia/Singapore">Asia/Singapore (Singapore Time)</option>
                <option value="Asia/Hong_Kong">Asia/Hong_Kong (Hong Kong Time)</option>
                <option value="Australia/Sydney">Australia/Sydney (Australian Eastern Time)
                </option>
                <option value="Australia/Perth">Australia/Perth (Australian Western Time)</option>
                <option value="Pacific/Auckland">Pacific/Auckland (New Zealand Time)</option>
              </select>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Event
                Image</label>
              <input accept="image/*"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                id="image" name="image" type="file">
              <div class="mt-2 hidden" id="currentImage">
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">Current Image:</p>
                <img alt="Current image" class="h-32 w-32 rounded-lg object-cover"
                  id="currentImagePreview" src="">
              </div>
            </div>
          </div>
        </div>

        <div
          class="mt-6 flex justify-end space-x-3 border-t border-gray-200 pt-4 dark:border-gray-700">
          <button
            class="rounded-lg bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeEventModal()" type="button">Cancel</button>
          <button
            class="from-primary to-accent rounded-lg bg-gradient-to-r px-4 py-2 text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl"
            type="submit">Save Event</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm"
    id="deleteModal">
    <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-800">
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
        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Delete Event</h3>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete
          this event? This action cannot be undone.</p>
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

  <!-- Registrations Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="registrationsModal">
    <div
      class="relative mx-auto my-10 w-full max-w-4xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div
        class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Event Registrations</h3>
        <button
          class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeRegistrationsModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <div class="overflow-x-auto p-6" id="registrationsContent">
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

      // Toast notification helper
      function showToast(type, message) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = `
            flex items-center gap-3 rounded-xl px-4 py-3 text-sm shadow-lg backdrop-blur-xl border
            transition-all duration-300 opacity-0 translate-y-[-10px] mb-3
            ${type === 'success' 
                ? 'bg-green-500/20 border-green-400/30 text-green-800 dark:text-green-200' 
                : 'bg-red-500/20 border-red-400/30 text-red-800 dark:text-red-200'}
        `;

        toast.innerHTML = `
            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>'
                    : '<path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>'}
            </svg>
            <span>${message}</span>
        `;

        container.appendChild(toast);

        setTimeout(() => {
          toast.classList.remove('opacity-0', 'translate-y-[-10px]');
        }, 10);

        setTimeout(() => {
          toast.classList.add('opacity-0', 'translate-y-[-10px]');
          setTimeout(() => toast.remove(), 300);
        }, 3000);
      }

      // Routes configuration
      const routes = {
        store: "{{ route('admin.events.store') }}",
        edit: (id) => `/admin/events/${id}/edit`,
        update: (id) => `/admin/events/${id}`,
        delete: (id) => `/admin/events/${id}`,
        registrations: (id) => `/admin/events/${id}/registrations`
      };

      // ==========================
      // MODAL HANDLING
      // ==========================
      window.openEventModal = function() {
        const form = document.getElementById('eventForm');
        document.getElementById('modalTitle').textContent = 'Create Event';
        document.getElementById('method').value = 'POST';
        form.action = routes.store;
        form.reset();
        document.getElementById('eventId').value = '';
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('eventModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      window.closeEventModal = function() {
        document.getElementById('eventModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
        document.body.style.overflow = 'auto';
      }

      window.closeRegistrationsModal = function() {
        document.getElementById('registrationsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      // ==========================
      // EDIT EVENT
      // ==========================
      window.editEvent = async function(id) {
        console.log('Editing event ID:', id);

        try {
          const response = await fetch(routes.edit(id), {
            method: 'GET',
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
            throw new Error(data.message || 'Failed to load event');
          }

          const event = data.event;
          const form = document.getElementById('eventForm');

          document.getElementById('modalTitle').textContent = 'Edit Event';
          document.getElementById('method').value = 'PUT';
          form.action = routes.update(event.id);
          document.getElementById('eventId').value = event.id;

          // Populate fields
          document.getElementById('title').value = event.title || '';
          document.getElementById('subtitle').value = event.subtitle || '';
          document.getElementById('description').value = event.description || '';
          document.getElementById('date').value = event.date || '';
          document.getElementById('start_time').value = event.formatted_start_time || '';
          document.getElementById('end_time').value = event.formatted_end_time || '';
          document.getElementById('location').value = event.location || '';

          // Set timezone - check if it exists in dropdown, if not add it
          const timezoneSelect = document.getElementById('timezone');
          let timezoneFound = false;
          for (let i = 0; i < timezoneSelect.options.length; i++) {
            if (timezoneSelect.options[i].value === event.timezone) {
              timezoneSelect.selectedIndex = i;
              timezoneFound = true;
              break;
            }
          }

          // If timezone not found, add it as an option
          if (!timezoneFound && event.timezone) {
            const newOption = document.createElement('option');
            newOption.value = event.timezone;
            newOption.text = event.timezone;
            newOption.selected = true;
            timezoneSelect.appendChild(newOption);
          }

          // Image preview
          if (event.image) {
            document.getElementById('currentImagePreview').src = `/storage/${event.image}`;
            document.getElementById('currentImage').classList.remove('hidden');
          } else {
            document.getElementById('currentImage').classList.add('hidden');
          }

          document.getElementById('eventModal').classList.remove('hidden');
          document.body.style.overflow = 'hidden';

        } catch (error) {
          console.error('Edit error:', error);
          showToast('error', 'Error loading event data. Please refresh and try again.');
        }
      }

      // ==========================
      // DELETE EVENT
      // ==========================
      window.deleteEvent = function(id) {
        currentDeleteId = id;
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = routes.delete(id);
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // ==========================
      // VIEW REGISTRATIONS
      // ==========================
      window.viewRegistrations = async function(eventId) {
        const modal = document.getElementById('registrationsModal');
        const content = document.getElementById('registrationsContent');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        content.innerHTML =
          '<div class="flex items-center justify-center py-8"><div class="h-8 w-8 animate-spin rounded-full border-4 border-primary border-t-transparent"></div></div>';

        try {
          const response = await fetch(routes.registrations(eventId), {
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
            throw new Error(data.message || 'Failed to load registrations');
          }

          const registrations = data.registrations;

          if (registrations.length === 0) {
            content.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No registrations yet</p>
                    </div>
                `;
            return;
          }

          let html = `
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Date of Birth</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Registered On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
            `;

          registrations.forEach(reg => {
            html += `
                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">${escapeHtml(reg.name)}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${escapeHtml(reg.email)}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${escapeHtml(reg.phone)}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">${reg.date_of_birth || 'N/A'}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">${new Date(reg.created_at).toLocaleDateString()}</td>
                    </tr>
                `;
          });

          html += `
                    </tbody>
                </table>
            `;
          content.innerHTML = html;

        } catch (error) {
          console.error('Registrations error:', error);
          content.innerHTML = `
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">Error loading registrations</p>
                </div>
            `;
        }
      }

      // ==========================
      // FORM SUBMISSIONS
      // ==========================
      document.getElementById('eventForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        const isEdit = document.getElementById('eventId').value;

        submitButton.innerHTML =
          '<svg class="mx-auto h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        submitButton.disabled = true;

        try {
          let url = this.action;

          // If editing, use the update route with ID
          if (isEdit) {
            url = routes.update(isEdit);
            formData.append('_method', 'PUT');
          }
          const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          });

          const data = await response.json();

          if (data.success) {
            closeEventModal();
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
          } else {
            showToast('error', data.message || 'An error occurred');
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
          }
        } catch (error) {
          console.error('Submit error:', error);
          showToast('error', 'An error occurred while saving the event');
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

      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }

      // Close modals when clicking outside
      document.getElementById('eventModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeEventModal();
      });

      document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
      });

      document.getElementById('registrationsModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeRegistrationsModal();
      });
    </script>
  </x-slot:scripts>
  <script>
    // Debug: Monitor all button clicks
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM fully loaded');

      // Test if buttons are present
      const createBtn = document.querySelector('[onclick="openEventModal()"]');
      const editBtns = document.querySelectorAll('[onclick^="editEvent"]');
      const deleteBtns = document.querySelectorAll('[onclick^="deleteEvent"]');

      console.log('Create button found:', !!createBtn);
      console.log('Edit buttons found:', editBtns.length);
      console.log('Delete buttons found:', deleteBtns.length);

      // Add click listeners for debugging
      if (createBtn) {
        createBtn.addEventListener('click', function() {
          console.log('Create button clicked');
        });
      }

      editBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          console.log('Edit button clicked', this.getAttribute('onclick'));
        });
      });

      deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          console.log('Delete button clicked', this.getAttribute('onclick'));
        });
      });
    });
  </script>
</x-admin-layout>
