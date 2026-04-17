<x-admin.layout header="Consultation Requests">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Consultation Requests</h2>
        <p class="mt-1 text-gray-600">View and manage student consultation requests</p>
      </div>
      <button
        class="flex items-center rounded-lg bg-green-600 px-4 py-2 text-white transition hover:bg-green-700"
        onclick="exportToCSV()">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 10v6m0 0l-3-3m3 3l3-3m-6 4h6m-6 0a9 9 0 110-18 9 9 0 010 18z"
            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
        </svg>
        Export CSV
      </button>
    </div>

    <!-- Filters -->
    <div class="rounded-lg bg-white p-4 shadow-md">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <input class="rounded-md border border-gray-300 px-3 py-2" id="search"
          placeholder="Search by name or email..." type="text">
        <input class="rounded-md border border-gray-300 px-3 py-2" id="programFilter"
          placeholder="Filter by program..." type="text">
        <input class="rounded-md border border-gray-300 px-3 py-2" id="countryFilter"
          placeholder="Filter by country..." type="text">
        <select class="rounded-md border border-gray-300 px-3 py-2" id="dateFilter">
          <option value="">All Time</option>
          <option value="today">Today</option>
          <option value="week">This Week</option>
          <option value="month">This Month</option>
        </select>
      </div>
    </div>

    <!-- Consultations Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow-md">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Contact
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Education
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Program
                Interest</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Preferred
                Countries</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Budget
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions
              </th>
            </tr>
          </thead>
          <tbody id="consultationsTableBody">
            @include('admin.consultations.partials.table', [
                'consultations' => $consultations
            ])
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4" id="paginationLinks">
        {{ $consultations->links() }}
      </div>
    </div>
  </div>

  <!-- View Details Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="detailsModal">
    <div class="relative top-20 mx-auto w-full max-w-2xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Consultation Details</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeDetailsModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <div class="space-y-4" id="detailsContent">
        <!-- Content loaded via AJAX -->
      </div>
      <div class="mt-6 flex justify-end">
        <button class="rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300"
          onclick="closeDetailsModal()">Close</button>
      </div>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      // Filter functionality
      document.getElementById('search').addEventListener('input', filterConsultations);
      document.getElementById('programFilter').addEventListener('input', filterConsultations);
      document.getElementById('countryFilter').addEventListener('input', filterConsultations);
      document.getElementById('dateFilter').addEventListener('change', filterConsultations);

      function filterConsultations() {
        const search = document.getElementById('search').value;
        const program = document.getElementById('programFilter').value;
        const country = document.getElementById('countryFilter').value;
        const date = document.getElementById('dateFilter').value;

        fetch(
            `/admin/consultations/filter?search=${search}&program=${program}&country=${country}&date=${date}`
            )
          .then(response => response.json())
          .then(data => {
            document.getElementById('consultationsTableBody').innerHTML = data.html;
          });
      }

      function viewDetails(id) {
        fetch(`/admin/consultations/${id}`)
          .then(response => response.json())
          .then(data => {
            const content = document.getElementById('detailsContent');
            content.innerHTML = `
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                            <p class="text-gray-900">${data.full_name}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-gray-900">${data.email}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Phone</p>
                            <p class="text-gray-900">${data.phone || 'Not provided'}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Education</p>
                            <p class="text-gray-900">${data.education}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Program of Interest</p>
                            <p class="text-gray-900">${data.programme_of_interest}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Preferred Countries</p>
                            <p class="text-gray-900">${data.preferred_countries}</p>
                        </div>
                        <div class="border-b pb-3">
                            <p class="text-sm font-medium text-gray-500">Tuition Budget</p>
                            <p class="text-gray-900">${data.tuition_budget || 'Not specified'}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Request Date</p>
                            <p class="text-gray-900">${new Date(data.created_at).toLocaleString()}</p>
                        </div>
                    `;
            document.getElementById('detailsModal').classList.remove('hidden');
          });
      }

      function closeDetailsModal() {
        document.getElementById('detailsModal').classList.add('hidden');
      }

      function exportToCSV() {
        window.location.href = "{{ route('admin.consultations.export') }}";
      }
    </script>
  </x-slot:scripts>
</x-admin.layout>
