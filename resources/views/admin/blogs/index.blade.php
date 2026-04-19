<x-admin-layout pageTitle="Blog Management">
  <div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
      <div>
        <h2
          class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
          Blog Posts
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Create and manage blog content</p>
      </div>
      <button
        class="from-primary to-accent inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition-all duration-200 hover:scale-105 hover:shadow-xl"
        onclick="openCreateModal()">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
          </path>
        </svg>
        Create Blog Post
      </button>
    </div>

    <!-- Filter Bar -->
    <x-filter-bar :$filters contentId="blogsList" paginationId="paginationContainer" />

    <!-- Blogs Table -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-lg dark:bg-gray-800">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead
            class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
            <tr>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Featured Image</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Title</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Author</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Created</th>
              <th
                class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-6 dark:text-gray-300">
                Actions</th>
            </tr>
          </thead>
          <tbody id="blogsList" class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
            <x-admin.blogs.table :$blogs />
          </tbody>
        </table>
      </div>
      @if (isset($blogs) && method_exists($blogs, 'hasPages') && $blogs->hasPages())
        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
          id="paginationContainer">
          {{ $blogs->links() }}
        </div>
      @endif
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="blogModal">
    <div class="relative mx-auto my-10 w-full max-w-4xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Create Blog Post</h3>
        <button class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form enctype="multipart/form-data" id="blogForm" method="POST" class="p-6">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="blogId" name="blog_id" type="hidden">

        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="title" name="title" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Subtitle</label>
            <input class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="subtitle" name="subtitle" type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
            <textarea class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="content" name="content" required rows="10"></textarea>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>
            <input accept="image/*" class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="featured_image" name="featured_image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">Current Image:</p>
              <img alt="Current image" class="h-32 w-32 rounded-lg object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
          <button class="rounded-lg bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeModal()" type="button">Cancel</button>
          <button class="rounded-lg bg-gradient-to-r from-primary to-accent px-4 py-2 text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl"
            type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Create Blog Post';
        document.getElementById('method').value = 'POST';
        document.getElementById('blogForm').action = "{{ route('admin.blog.store') }}";
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

      // Close modal when clicking outside
      document.getElementById('blogModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
          closeModal();
        }
      });
    </script>
  </x-slot:scripts>
</x-admin-layout>