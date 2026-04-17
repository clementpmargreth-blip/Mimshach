<x-admin.layout header="Funding Opportunities">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Scholarships, Grants & Loans</h2>
        <p class="mt-1 text-gray-600">Manage funding opportunities for students</p>
      </div>
      <button
        class="flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700"
        onclick="openCreateModal()">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add Funding
      </button>
    </div>

    <!-- Filters -->
    <div class="rounded-lg bg-white p-4 shadow-md">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <input class="rounded-md border border-gray-300 px-3 py-2" id="search"
          placeholder="Search funding..." type="text">
        <select class="rounded-md border border-gray-300 px-3 py-2" id="educationLevelFilter">
          <option value="">All Education Levels</option>
          <option value="Undergraduate">Undergraduate</option>
          <option value="Graduate">Graduate</option>
          <option value="PhD">PhD</option>
          <option value="Diploma">Diploma</option>
        </select>
        <select class="rounded-md border border-gray-300 px-3 py-2" id="universityFilter">
          <option value="">All Universities</option>
          @foreach ($universities as $university)
            <option value="{{ $university->id }}">{{ $university->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <!-- Funding Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="fundingGrid">
      @foreach ($fundings as $funding)
        <div class="overflow-hidden rounded-lg bg-white shadow-md">
          @if ($funding->image)
            <img alt="{{ $funding->name }}" class="h-48 w-full object-cover"
              src="{{ Storage::url($funding->image) }}">
          @else
            <div
              class="flex h-48 w-full items-center justify-center bg-gradient-to-r from-green-400 to-blue-500">
              <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              </svg>
            </div>
          @endif
          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800">{{ $funding->name }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ $funding->university->name }}</p>
            <span
              class="mt-2 inline-block rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">
              {{ $funding->education_level }}
            </span>
            <p class="mt-2 line-clamp-2 text-sm text-gray-600">
              {{ Str::limit($funding->description, 100) }}</p>
            <div class="mt-4 flex justify-end space-x-2">
              <button class="text-sm text-indigo-600 hover:text-indigo-900"
                onclick="editFunding({{ $funding->id }})">Edit</button>
              <form action="{{ route('admin.funding.destroy', $funding) }}" class="inline"
                method="POST" onsubmit="return confirm('Delete this funding opportunity?')">
                @csrf
                @method('DELETE')
                <button class="text-sm text-red-600 hover:text-red-900"
                  type="submit">Delete</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $fundings->links() }}
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="fundingModal">
    <div class="relative top-10 mx-auto w-full max-w-2xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Add Funding Opportunity</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form enctype="multipart/form-data" id="fundingForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="fundingId" name="funding_id" type="hidden">

        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Name</label>
            <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="name"
              name="name" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
            <textarea class="w-full rounded-md border border-gray-300 px-3 py-2" id="description"
              name="description" required rows="5"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">Education Level</label>
              <select class="w-full rounded-md border border-gray-300 px-3 py-2"
                id="education_level" name="education_level" required>
                <option value="">Select Level</option>
                <option value="Undergraduate">Undergraduate</option>
                <option value="Graduate">Graduate</option>
                <option value="PhD">PhD</option>
                <option value="Diploma">Diploma</option>
              </select>
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">University</label>
              <select class="w-full rounded-md border border-gray-300 px-3 py-2"
                id="university_id" name="university_id" required>
                <option value="">Select University</option>
                @foreach ($universities as $university)
                  <option value="{{ $university->id }}">{{ $university->name }}</option>
                @endforeach
              </select>
            </div>
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
      document.getElementById('search').addEventListener('input', filterFunding);
      document.getElementById('educationLevelFilter').addEventListener('change', filterFunding);
      document.getElementById('universityFilter').addEventListener('change', filterFunding);

      function filterFunding() {
        const search = document.getElementById('search').value;
        const education = document.getElementById('educationLevelFilter').value;
        const university = document.getElementById('universityFilter').value;

        fetch(`/admin/funding/filter?search=${search}&education=${education}&university=${university}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('fundingGrid').innerHTML = data.html;
          });
      }

      function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add Funding Opportunity';
        document.getElementById('method').value = 'POST';
        document.getElementById('fundingForm').action = "{{ route('admin.funding.store') }}";
        document.getElementById('fundingForm').reset();
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('fundingModal').classList.remove('hidden');
      }

      function editFunding(id) {
        fetch(`/admin/funding/${id}/edit`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Funding Opportunity';
            document.getElementById('method').value = 'PUT';
            document.getElementById('fundingForm').action = `/admin/funding/${id}`;
            document.getElementById('fundingId').value = id;
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('education_level').value = data.education_level;
            document.getElementById('university_id').value = data.university_id;

            if (data.image) {
              document.getElementById('currentImagePreview').src = `/storage/${data.image}`;
              document.getElementById('currentImage').classList.remove('hidden');
            }

            document.getElementById('fundingModal').classList.remove('hidden');
          });
      }

      function closeModal() {
        document.getElementById('fundingModal').classList.add('hidden');
      }
    </script>
  </x-slot:scripts>
</x-admin.layout>
