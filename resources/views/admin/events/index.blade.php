<x-admin.layout header="Events Management">
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Events</h2>
        <p class="mt-1 text-gray-600">Manage your events and event registrations</p>
      </div>
      <a class="flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700"
        href="{{ route('admin.events.create') }}">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Create Event
      </a>
    </div>

    <!-- Events Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow-md">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Image</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Title</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Location
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                Registrations</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            @foreach ($events as $event)
              <tr>
                <td class="whitespace-nowrap px-6 py-4">
                  @if ($event->image)
                    <img alt="{{ $event->title }}" class="h-12 w-12 rounded object-cover"
                      src="{{ Storage::url($event->image) }}">
                  @else
                    <div class="flex h-12 w-12 items-center justify-center rounded bg-gray-200">
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                    </div>
                  @endif
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                  @if ($event->subtitle)
                    <div class="text-xs text-gray-500">{{ $event->subtitle }}</div>
                  @endif
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  {{ $event->location }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  {{ $event->registrations->count() }} registered
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                  <div class="flex space-x-2">
                    <a class="text-indigo-600 hover:text-indigo-900"
                      href="{{ route('admin.events.edit', $event) }}">Edit</a>
                    <form action="{{ route('admin.events.destroy', $event) }}" class="inline"
                      method="POST" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      @method('DELETE')
                      <button class="text-red-600 hover:text-red-900" type="submit">Delete</button>
                    </form>
                    <button class="text-green-600 hover:text-green-900"
                      onclick="viewRegistrations({{ $event->id }})">Registrations</button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4">
        {{ $events->links() }}
      </div>
    </div>
  </div>

  <!-- Registrations Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="registrationsModal">
    <div class="relative top-20 mx-auto w-full max-w-4xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Event Registrations</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <div class="overflow-x-auto" id="registrationsContent">
        <!-- Content loaded via AJAX -->
      </div>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      function viewRegistrations(eventId) {
        fetch(`/admin/events/${eventId}/registrations`)
          .then(response => response.json())
          .then(data => {
            const modal = document.getElementById('registrationsModal');
            const content = document.getElementById('registrationsContent');

            if (data.length === 0) {
              content.innerHTML =
                '<p class="text-center text-gray-500 py-8">No registrations yet</p>';
            } else {
              let html =
                '<table class="min-w-full divide-y divide-gray-200"><thead class="bg-gray-50"><tr>';
              html +=
                '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>';
              html +=
                '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>';
              html +=
                '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date of Birth</th>';
              html +=
                '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registered On</th>';
              html += '</tr></thead><tbody>';

              data.forEach(reg => {
                html += `<tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${reg.full_name}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${reg.email}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${reg.date_of_birth}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${new Date(reg.created_at).toLocaleDateString()}</td>
                            </tr>`;
              });

              html += '</tbody></table>';
              content.innerHTML = html;
            }

            modal.classList.remove('hidden');
          });
      }

      function closeModal() {
        document.getElementById('registrationsModal').classList.add('hidden');
      }
    </script>
  </x-slot:scripts>
</x-admin.layout>
