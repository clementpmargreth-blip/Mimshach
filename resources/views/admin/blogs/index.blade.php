<x-admin.layout header="Blog Management">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Blog Posts</h2>
        <p class="mt-1 text-gray-600">Create and manage blog content</p>
      </div>
      <button
        class="flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700"
        onclick="openCreateModal()">
        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Create Blog Post
      </button>
    </div>

    <!-- Blogs Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow-md">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Featured
                Image</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Title</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Author
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Created
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions
              </th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 bg-white">
            @foreach ($blogs as $blog)
              <tr>
                <td class="whitespace-nowrap px-6 py-4">
                  @if ($blog->featured_image)
                    <img alt="{{ $blog->title }}" class="h-12 w-12 rounded object-cover"
                      src="{{ Storage::url($blog->featured_image) }}">
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
                  <div class="text-sm font-medium text-gray-900">{{ $blog->title }}</div>
                  @if ($blog->subtitle)
                    <div class="text-xs text-gray-500">{{ $blog->subtitle }}</div>
                  @endif
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                  {{ $blog->user->name }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                  {{ $blog->created_at->format('M d, Y') }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                  <div class="flex space-x-2">
                    <a class="text-indigo-600 hover:text-indigo-900"
                      href="{{ route('admin.blogs.edit', $blog) }}">Edit</a>
                    <form action="{{ route('admin.blogs.destroy', $blog) }}" class="inline"
                      method="POST" onsubmit="return confirm('Delete this blog post?')">
                      @csrf
                      @method('DELETE')
                      <button class="text-red-600 hover:text-red-900" type="submit">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4">
        {{ $blogs->links() }}
      </div>
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="blogModal">
    <div class="relative top-10 mx-auto w-full max-w-2xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Create Blog Post</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form enctype="multipart/form-data" id="blogForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="blogId" name="blog_id" type="hidden">

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
            <label class="mb-2 block text-sm font-medium text-gray-700">Content</label>
            <textarea class="w-full rounded-md border border-gray-300 px-3 py-2" id="content" name="content"
              required rows="8"></textarea>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Featured Image</label>
            <input accept="image/*" class="w-full rounded-md border border-gray-300 px-3 py-2"
              id="featured_image" name="featured_image" type="file">
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
      function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Create Blog Post';
        document.getElementById('method').value = 'POST';
        document.getElementById('blogForm').action = "{{ route('admin.blogs.store') }}";
        document.getElementById('blogForm').reset();
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('blogModal').classList.remove('hidden');
      }

      function editBlog(id) {
        fetch(`/admin/blogs/${id}/edit`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('modalTitle').textContent = 'Edit Blog Post';
            document.getElementById('method').value = 'PUT';
            document.getElementById('blogForm').action = `/admin/blogs/${id}`;
            document.getElementById('blogId').value = id;
            document.getElementById('title').value = data.title;
            document.getElementById('subtitle').value = data.subtitle;
            document.getElementById('content').value = data.content;

            if (data.featured_image) {
              document.getElementById('currentImagePreview').src = `/storage/${data.featured_image}`;
              document.getElementById('currentImage').classList.remove('hidden');
            }

            document.getElementById('blogModal').classList.remove('hidden');
          });
      }

      function closeModal() {
        document.getElementById('blogModal').classList.add('hidden');
      }
    </script>
  </x-slot:scripts>
</x-admin.layout>
