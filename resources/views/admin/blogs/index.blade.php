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
        onclick="openBlogModal()">
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
      <div class="border-t border-gray-200 px-4 py-4 sm:px-6 dark:border-gray-700"
        id="paginationContainer">
        {{ $blogs->links() }}
      </div>
    </div>
  </div>

  <!-- Create/Edit Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-black/50 backdrop-blur-sm"
    id="blogModal">
    <div class="relative mx-auto my-10 w-full max-w-4xl rounded-2xl bg-white shadow-2xl dark:bg-gray-800">
      <div class="flex items-center justify-between border-b border-gray-200 p-6 dark:border-gray-700">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white" id="modalTitle">Create Blog Post</h3>
        <button class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700"
          onclick="closeBlogModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.blogs.store') }}" class="p-6" enctype="multipart/form-data"
        id="blogForm" method="POST">
        @csrf
        <input id="method" name="_method" type="hidden" value="POST">
        <input id="blogId" name="blog_id" type="hidden">

        <div class="max-h-[60vh] space-y-4 overflow-y-auto px-1">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Title *</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="title" name="title" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Subtitle</label>
            <input
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="subtitle" name="subtitle" type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Content *</label>
            <textarea
              class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="content" name="content" required rows="10"></textarea>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>
            <input accept="image/*"
              class="w-full rounded-lg border border-gray-300 px-4 py-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              id="featured_image" name="featured_image" type="file">
            <div class="mt-2 hidden" id="currentImage">
              <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">Current Image:</p>
              <img alt="Current image" class="h-32 w-32 rounded-lg object-cover"
                id="currentImagePreview" src="">
            </div>
          </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3 border-t border-gray-200 pt-4 dark:border-gray-700">
          <button
            class="rounded-lg bg-gray-200 px-4 py-2 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600"
            onclick="closeBlogModal()" type="button">Cancel</button>
          <button
            class="from-primary to-accent rounded-lg bg-gradient-to-r px-4 py-2 text-white shadow-lg transition-all hover:scale-105 hover:shadow-xl"
            type="submit">Save Blog Post</button>
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
          <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">Delete Blog Post</h3>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Are you sure you want to delete
            this blog post? This action cannot be undone.</p>
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
        store: "{{ route('admin.blogs.store') }}",
        edit: (id) => `/admin/blogs/${id}/edit`,
        update: (id) => `/admin/blogs/${id}`,
        delete: (id) => `/admin/blogs/${id}`
      };

      // ==========================
      // MODAL HANDLING
      // ==========================
      window.openBlogModal = function() {
        const form = document.getElementById('blogForm');
        document.getElementById('modalTitle').textContent = 'Create Blog Post';
        document.getElementById('method').value = 'POST';
        form.action = routes.store;
        form.reset();
        document.getElementById('blogId').value = '';
        document.getElementById('currentImage').classList.add('hidden');
        document.getElementById('blogModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      window.closeBlogModal = function() {
        document.getElementById('blogModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      window.closeDeleteModal = function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      // ==========================
      // EDIT BLOG
      // ==========================
      window.editBlog = async function(id) {
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
            throw new Error(data.message || 'Failed to load blog post');
          }

          const blog = data.blog;
          const form = document.getElementById('blogForm');

          document.getElementById('modalTitle').textContent = 'Edit Blog Post';
          document.getElementById('method').value = 'PUT';
          form.action = routes.update(blog.id);
          document.getElementById('blogId').value = blog.id;

          // Populate fields
          document.getElementById('title').value = blog.title || '';
          document.getElementById('subtitle').value = blog.subtitle || '';
          document.getElementById('content').value = blog.content || '';

          // Image preview
          if (blog.featured_image_url) {
            document.getElementById('currentImagePreview').src = blog.featured_image_url;
            document.getElementById('currentImage').classList.remove('hidden');
          } else if (blog.featured_image) {
            const imageUrl = blog.featured_image.startsWith('http') ? blog.featured_image :
              `/storage/${blog.featured_image}`;
            document.getElementById('currentImagePreview').src = imageUrl;
            document.getElementById('currentImage').classList.remove('hidden');
          } else {
            document.getElementById('currentImage').classList.add('hidden');
          }

          document.getElementById('blogModal').classList.remove('hidden');
          document.body.style.overflow = 'hidden';

        } catch (error) {
          console.error('Edit error:', error);
          showToast('error', 'Error loading blog post data. Please refresh and try again.');
        }
      }

      // ==========================
      // DELETE BLOG
      // ==========================
      window.deleteBlog = function(id) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = routes.delete(id);
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
      }

      // ==========================
      // FORM SUBMISSION
      // ==========================
      document.getElementById('blogForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        const blogId = document.getElementById('blogId').value;

        submitButton.innerHTML =
          '<svg class="mx-auto h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
        submitButton.disabled = true;

        try {
          let url = this.action;

          if (blogId) {
            url = routes.update(blogId);
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
              closeBlogModal();
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
          showToast('error', 'An error occurred while saving the blog post');
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
          showToast('error', 'An error occurred while deleting the blog post');
          submitButton.innerHTML = originalText;
          submitButton.disabled = false;
        }
      });

      // Close modals when clicking outside
      document.getElementById('blogModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeBlogModal();
      });

      document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
      });
    </script>
  </x-slot:scripts>
</x-admin-layout>