<x-admin.layout header="Universities Management">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Universities</h2>
        <p class="mt-1 text-gray-600">Manage partner universities and institutions</p>
      </div>
      <button
        class="flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700"
        onclick="openCreateModal()">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Add University
      </button>
    </div>

    <!-- Universities Grid -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
      @foreach ($universities as $university)
        <div class="overflow-hidden rounded-lg bg-white shadow-md">
          @if ($university->image)
            <img alt="{{ $university->name }}" class="h-48 w-full object-cover"
              src="{{ Storage::url($university->image) }}">
          @else
            <div class="flex h-48 w-full items-center justify-center bg-gray-200">
              <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              </svg>
            </div>
          @endif
          <div class="p-4">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $university->name }}</h3>
                <p class="text-sm text-gray-600">{{ $university->city }}, {{ $university->country }}
                </p>
              </div>
              @if ($university->logo)
                <img alt="Logo" class="h-12 w-12 object-contain"
                  src="{{ Storage::url($university->logo) }}">
              @endif
            </div>
            <p class="mt-2 line-clamp-2 text-sm text-gray-600">{{ $university->subtitle ?? '' }}</p>
            <div class="mt-4 flex justify-end space-x-2">
              <button class="text-sm text-indigo-600 hover:text-indigo-900"
                onclick="editUniversity({{ $university->id }})">Edit</button>
              <form action="{{ route('admin.universities.destroy', $university) }}" class="inline"
                method="POST" onsubmit="return confirm('Delete this university?')">
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
      {{ $universities->links() }}
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="universityModal">
    <div class="relative top-10 mx-auto w-full max-w-2xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Add University</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
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

        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">University Name</label>
            <input
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
              id="name" name="name" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Subtitle</label>
            <input
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
              id="subtitle" name="subtitle" type="text">
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">Country</label>
              <input
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
                id="country" name="country" required type="text">
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-gray-700">City</label>
              <input
                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
                id="city" name="city" required type="text">
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Content</label>
            <textarea
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
              id="content" name="content" required rows="5"></textarea>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Featured Image</label>
            <input accept="image/*"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
              id="image" name="image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <img alt="Current image" class="h-32 w-32 rounded object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Logo</label>
            <input accept="image/*"
              class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500"
              id="logo" name="logo" type="file">
          </div>

          <div class="flex justify-end space-x-3 pt-4">
            <button class="rounded-md bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300"
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
      function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add University';
        document.getElementById('method').value = 'POST';
        document.getElementById('universityForm').action = "{{ route('admin.universities.store') }}";
        document.getElementById('universityForm').reset();
        document.getElementById('currentImage').classList.add('hidden');
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
            document.getElementById('subtitle').value = data.subtitle;
            document.getElementById('country').value = data.country;
            document.getElementById('city').value = data.city;
            document.getElementById('content').value = data.content;

            if (data.image) {
              document.getElementById('currentImagePreview').src = `/storage/${data.image}`;
              document.getElementById('currentImage').classList.remove('hidden');
            }

            document.getElementById('universityModal').classList.remove('hidden');
          });
      }

      function closeModal() {
        document.getElementById('universityModal').classList.add('hidden');
      }
    </script>
  </x-slot:scripts>
</x-admin.layout>
