<x-admin.layout header="Admissions Management">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Admissions</h2>
        <p class="mt-1 text-gray-600">Manage admission posts and deadlines</p>
      </div>
      <button
        class="flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700"
        onclick="openCreateModal()">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Admission
      </button>
    </div>

    <!-- Filters -->
    <div class="rounded-lg bg-white p-4 shadow-md">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
        <input class="rounded-md border border-gray-300 px-3 py-2" id="search"
          placeholder="Search admissions..." type="text">
        <select class="rounded-md border border-gray-300 px-3 py-2" id="programFilter">
          <option value="">All Programs</option>
          @foreach ($programs as $program)
            <option value="{{ $program }}">{{ $program }}</option>
          @endforeach
        </select>
        <select class="rounded-md border border-gray-300 px-3 py-2" id="countryFilter">
          <option value="">All Countries</option>
          @foreach ($countries as $country)
            <option value="{{ $country }}">{{ $country }}</option>
          @endforeach
        </select>
        <select class="rounded-md border border-gray-300 px-3 py-2" id="universityFilter">
          <option value="">All Universities</option>
          @foreach ($universities as $university)
            <option value="{{ $university->id }}">{{ $university->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <!-- Admissions Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow-md">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Image</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">
                Title/Program</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">University
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Country
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Year</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Deadline
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Status
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions
              </th>
            </tr>
          </thead>
          <tbody id="admissionsTableBody">
            @include('admin.admissions.partials.table', ['admissions' => $admissions])
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4" id="paginationLinks">
        {{ $admissions->links() }}
      </div>
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="admissionModal">
    <div class="relative top-10 mx-auto w-full max-w-2xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Add Admission</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
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

        <div class="max-h-96 space-y-4 overflow-y-auto">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Title</label>
            <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="title"
              name="title" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle</label>
            <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="subtitle"
              name="subtitle" type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Program</label>
            <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="program"
              name="program" required type="text">
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">Year</label>
              <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="year"
                name="year" required type="number">
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">Country</label>
              <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="country"
                name="country" required type="text">
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">University</label>
            <select class="w-full rounded-md border border-gray-300 px-3 py-2" id="university_id"
              name="university_id" required>
              <option value="">Select University</option>
              @foreach ($universities as $university)
                <option value="{{ $university->id }}">{{ $university->name }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Deadline</label>
            <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="deadline"
              name="deadline" required type="date">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Content</label>
            <textarea class="w-full rounded-md border border-gray-300 px-3 py-2" id="content"
              name="content" required rows="5"></textarea>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Image</label>
            <input accept="image/*" class="w-full rounded-md border border-gray-300 px-3 py-2"
              id="image" name="image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <img alt="Current image" class="h-32 w-32 rounded object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>

          <div class="flex justify-end space-x-3 pt-4">
            <button class="rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300"
              onclick="closeModal()" type="button">Cancel</button>
            <button class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
              type="submit">Save</button>
          </div>
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
        document.getElementById('admissionForm').action = "{{ route('admin.admissions.store') }}";
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
</x-admin.layout>
