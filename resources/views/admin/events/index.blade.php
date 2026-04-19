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
      @if (isset($events) && method_exists($events, 'hasPages') && $events->hasPages())
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
          id="paginationContainer">
          {{ $events->links() }}
        </div>
      @endif
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
                <option value="America/New_York">America/New_York</option>
                <option value="America/Los_Angeles">America/Los_Angeles</option>
                <option value="Europe/London">Europe/London</option>
                <option value="Europe/Paris">Europe/Paris</option>
                <option value="Asia/Dubai">Asia/Dubai</option>
                <option value="Asia/Singapore">Asia/Singapore</option>
                <option value="Asia/Tokyo">Asia/Tokyo</option>
                <option value="Australia/Sydney">Australia/Sydney</option>
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

      const routes = {
        store: "{{ route('admin.events.store') }}",
        update: (id) => `/admin/events/${id}`,
        edit: (id) => `/admin/events/${id}/edit`,
        delete: (id) => `/admin/events/${id}`,
        registrations: (id) => `/admin/events/${id}/registrations`
      };

      // ==========================
      // MODAL HANDLING
      // ==========================
      window.openEventModal = function openEventModal() {
        const form = document.getElementById('eventForm');

        document.getElementById('modalTitle').textContent = 'Create Event';
        document.getElementById('method').value = 'POST';

        form.action = routes.store;
        form.reset();
        form.dataset.id = ''; // ✅ IMPORTANT FIX

        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('eventModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      window.closeEventModal = function closeEventModal() {
        document.getElementById('eventModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      window.closeDeleteModal = function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
        document.body.style.overflow = 'auto';
      }

      window.closeRegistrationsModal = function closeRegistrationsModal() {
        document.getElementById('registrationsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      // ==========================
      // EDIT EVENT (FIXED)
      // ==========================
      window.editEvent = async function editEvent(id) {
        try {
          const res = await fetch(routes.edit(id), {
            headers: {
              'Accept': 'application/json'
            }
          });

          const data = await res.json();

          if (!data.success) throw new Error();

          const event = data.event; // ✅ FIX

          const form = document.getElementById('eventForm');

          form.dataset.id = event.id; // ✅ FIX
          form.action = routes.update(event.id);

          document.getElementById('modalTitle').textContent = 'Edit Event';
          document.getElementById('method').value = 'PUT';

          // Populate fields
          document.getElementById('title').value = event.title || '';
          document.getElementById('subtitle').value = event.subtitle || '';
          document.getElementById('description').value = event.description || '';
          document.getElementById('date').value = event.date || '';
          document.getElementById('start_time').value = event.start_time || '';
          document.getElementById('end_time').value = event.end_time || '';
          document.getElementById('location').value = event.location || '';
          document.getElementById('timezone').value = event.timezone || 'UTC';

          // Image preview
          if (event.image) {
            document.getElementById('currentImagePreview').src = `/storage/${event.image}`;
            document.getElementById('currentImage').classList.remove('hidden');
          } else {
            document.getElementById('currentImage').classList.add('hidden');
          }

          document.getElementById('eventModal').classList.remove('hidden');
          document.body.style.overflow = 'hidden';

        } catch (e) {
          console.error(e);
          showToast('error', 'Error loading event data.');
        }
      }

      // ==========================
      // DELETE EVENT (FIXED)
      // ==========================
      window.deleteEvent = function deleteEvent(id) {
        currentDeleteId = id;
        document.getElementById('deleteForm').action = routes.delete(id); // ✅ FIX
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // ==========================
      // REGISTRATIONS (FIXED)
      // ==========================
      window.viewRegistrations = async function viewRegistrations(eventId) {
        const modal = document.getElementById('registrationsModal');
        const content = document.getElementById('registrationsContent');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        content.innerHTML = 'Loading...';

        try {
          const res = await fetch(routes.registrations(eventId), {
            headers: {
              'Accept': 'application/json'
            },
            credentials: 'same-origin'
          });
          const data = await res.json();

          if (!data.success) throw new Error();

          const registrations = data.registrations; // ✅ FIX

          if (registrations.length === 0) {
            content.innerHTML = `<p class="text-center py-6">No registrations yet</p>`;
            return;
          }

          let html = `<table class="min-w-full">`;

          registrations.forEach(reg => {
            html += `
                <tr>
                    <td>${escapeHtml(reg.name)}</td>
                    <td>${escapeHtml(reg.email)}</td>
                    <td>${escapeHtml(reg.phone)}</td>
                </tr>
            `;
          });

          html += `</table>`;
          content.innerHTML = html;

        } catch (e) {
          console.error(e);
          content.innerHTML = `<p class="text-red-500 text-center">Error loading registrations</p>`;
        }
      }

      // ==========================
      // CREATE / UPDATE (FIXED)
      // ==========================
      const form = document.getElementById('eventForm');

      form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const eventId = form.dataset.id;

        const url = eventId ? routes.update(eventId) : routes.store;

        if (eventId) {
          formData.append('_method', 'PUT'); // ✅ FIX
        }

        const res = await fetch(url, {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          credentials: 'same-origin'
        });

        const text = await res.text();

        try {
          const data = JSON.parse(text);
          if (data.success) {
            closeEventModal();
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1200);
          } else {
            showToast('error', data.message || 'Something went wrong');
          }
          return data;
        } catch {
          console.error('Non-JSON response:', text);
          throw new Error('Server returned HTML instead of JSON');
        }


      });

      // ==========================
      // DELETE SUBMIT (FIXED)
      // ==========================
      document.getElementById('deleteForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const res = await fetch(this.action, {
          method: 'POST',
          body: new URLSearchParams({
            _method: 'DELETE'
          }),
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          credentials: 'same-origin'
        });

        const text = await res.text();

        try {
          const data = JSON.parse(text);
          if (data.success) {
            closeEventModal();
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1200);
          } else {
            showToast('error', data.message || 'Something went wrong');
          }
          return data;
        } catch {
          console.error('Non-JSON response:', text);
          throw new Error('Server returned HTML instead of JSON');
        }
      });

      // ==========================
      // UTIL
      // ==========================
      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }
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
