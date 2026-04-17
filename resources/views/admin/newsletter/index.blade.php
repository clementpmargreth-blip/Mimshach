<x-admin.layout header="Newsletter Subscribers">
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Email Subscribers</h2>
        <p class="mt-1 text-gray-600">Manage newsletter subscribers and send broadcasts</p>
      </div>
      <div class="flex space-x-3">
        <button
          class="flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700"
          onclick="sendNewsletter()">
          <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          Send Newsletter
        </button>
        <button class="rounded-lg bg-green-600 px-4 py-2 text-white transition hover:bg-green-700"
          onclick="exportEmails()">
          Export Emails
        </button>
      </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
      <div class="rounded-lg bg-white p-6 shadow-md">
        <p class="text-sm text-gray-500">Total Subscribers</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalSubscribers }}</p>
      </div>
      <div class="rounded-lg bg-white p-6 shadow-md">
        <p class="text-sm text-gray-500">New This Week</p>
        <p class="text-3xl font-bold text-green-600">+{{ $newThisWeek }}</p>
      </div>
      <div class="rounded-lg bg-white p-6 shadow-md">
        <p class="text-sm text-gray-500">New This Month</p>
        <p class="text-3xl font-bold text-blue-600">+{{ $newThisMonth }}</p>
      </div>
      <div class="rounded-lg bg-white p-6 shadow-md">
        <p class="text-sm text-gray-500">Most Active Day</p>
        <p class="text-xl font-bold text-gray-800">{{ $mostActiveDay }}</p>
      </div>
    </div>

    <!-- Search -->
    <div class="rounded-lg bg-white p-4 shadow-md">
      <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="search"
        placeholder="Search by email..." type="text">
    </div>

    <!-- Subscribers Table -->
    <div class="overflow-hidden rounded-lg bg-white shadow-md">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Email</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Subscribed
                Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Actions
              </th>
            </tr>
          </thead>
          <tbody id="subscribersTableBody">
            @include('admin.newsletters.partials.table', [
                'subscribers' => $subscribers
            ])
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4" id="paginationLinks">
        {{ $subscribers->links() }}
      </div>
    </div>
  </div>

  <!-- Send Newsletter Modal -->
  <div class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50"
    id="newsletterModal">
    <div class="relative top-20 mx-auto w-full max-w-2xl rounded-md border bg-white p-5 shadow-lg">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-900">Send Newsletter</h3>
        <button class="text-gray-400 hover:text-gray-600" onclick="closeNewsletterModal()">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"></path>
          </svg>
        </button>
      </div>
      <form action="{{ route('admin.newsletters.send') }}" id="newsletterForm" method="POST">
        @csrf
        <div class="space-y-4">
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Subject</label>
            <input class="w-full rounded-md border border-gray-300 px-3 py-2" id="subject"
              name="subject" required type="text">
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">Content</label>
            <textarea class="w-full rounded-md border border-gray-300 px-3 py-2" id="content" name="content"
              required rows="10"></textarea>
            <p class="mt-1 text-xs text-gray-500">You can use HTML for formatting</p>
          </div>

          <div class="rounded-md border border-yellow-200 bg-yellow-50 p-3">
            <p class="text-sm text-yellow-800">
              <strong>Note:</strong> This will send an email to all {{ $totalSubscribers }}
              subscribers.
            </p>
          </div>

          <div class="flex justify-end space-x-3 pt-4">
            <button class="rounded-md bg-gray-200 px-4 py-2 hover:bg-gray-300"
              onclick="closeNewsletterModal()" type="button">Cancel</button>
            <button class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700"
              type="submit">Send Newsletter</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <x-slot:scripts>
    <script>
      document.getElementById('search').addEventListener('input', function() {
        const search = this.value;
        fetch(`/admin/newsletters/search?search=${search}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('subscribersTableBody').innerHTML = data.html;
          });
      });

      function sendNewsletter() {
        document.getElementById('newsletterModal').classList.remove('hidden');
      }

      function closeNewsletterModal() {
        document.getElementById('newsletterModal').classList.add('hidden');
      }

      function exportEmails() {
        window.location.href = "{{ route('admin.newsletters.export') }}";
      }

      function deleteSubscriber(id) {
        if (confirm('Delete this subscriber?')) {
          fetch(`/admin/newsletters/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          }).then(() => {
            location.reload();
          });
        }
      }
    </script>
  </x-slot:scripts>
</x-admin.layout>
