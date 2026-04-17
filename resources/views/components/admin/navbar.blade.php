<!-- Mobile Menu Overlay -->
<div
  class="mobile-menu-overlay pointer-events-none fixed inset-0 z-20 bg-black/50 opacity-0 transition-opacity duration-300 lg:hidden"
  id="mobileOverlay"></div>

<!-- Sidebar -->
<aside
  class="fixed inset-y-0 left-0 z-30 w-72 -translate-x-full transform bg-white shadow-2xl transition-transform duration-300 lg:relative lg:translate-x-0 dark:bg-gray-800/95 dark:backdrop-blur-sm"
  id="sidebar">
  <div class="flex h-full flex-col">
    <!-- Sidebar Header -->
    <div
      class="relative flex h-20 items-center justify-between border-b border-gray-200 px-6 dark:border-gray-700">
      <div class="flex items-center space-x-3">
        <div class="relative">
          <div
            class="from-primary to-accent absolute inset-0 rounded-lg bg-gradient-to-r opacity-75 blur">
          </div>
          <div class="from-primary to-accent relative rounded-lg bg-gradient-to-r p-2">
            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </div>
        </div>
        <div>
          <span
            class="from-primary to-accent bg-gradient-to-r bg-clip-text text-xl font-bold text-transparent">Mimshach</span>
          <span class="ml-1 text-xs font-medium text-gray-500 dark:text-gray-400">Admin</span>
        </div>
      </div>
      <button
        class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 lg:hidden dark:hover:bg-gray-700"
        id="closeSidebarBtn">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2"></path>
        </svg>
      </button>
    </div>

    <!-- Navigation -->
    <nav class="flex h-full flex-col justify-between px-4 py-6">
      <div class=''>
        <a class="hover:from-primary/10 hover:to-accent/10 hover:text-primary dark:hover:from-primary/20 dark:hover:to-accent/20 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-primary/10 to-accent/10 text-primary shadow-sm' : '' }} group flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-700 transition-all duration-200 hover:bg-gradient-to-r dark:text-gray-300"
          href="{{ route('admin.dashboard') }}">
          <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          <span class="font-medium">Dashboard</span>
          @if (request()->routeIs('admin.dashboard'))
            <span class="bg-primary ml-auto h-1.5 w-1.5 rounded-full"></span>
          @endif
        </a>

        <a class="hover:from-primary/10 hover:to-accent/10 hover:text-primary group flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-700 transition-all duration-200 hover:bg-gradient-to-r dark:text-gray-300"
          href="#">
          <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          <span class="font-medium">Consultations</span>
          <span
            class="bg-primary/10 text-primary ml-auto rounded-full px-2 py-0.5 text-xs font-semibold">12</span>
        </a>

        <a class="hover:from-primary/10 hover:to-accent/10 hover:text-primary group flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-700 transition-all duration-200 hover:bg-gradient-to-r dark:text-gray-300"
          href="#">
          <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          <span class="font-medium">Newsletters</span>
        </a>

        <a class="hover:from-primary/10 hover:to-accent/10 hover:text-primary group flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-700 transition-all duration-200 hover:bg-gradient-to-r dark:text-gray-300"
          href="#">
          <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          <span class="font-medium">Events</span>
          <span
            class="bg-accent/10 text-accent ml-auto rounded-full px-2 py-0.5 text-xs font-semibold">{{ $upcomingEvents ?? 0 }}</span>
        </a>

        <a class="hover:from-primary/10 hover:to-accent/10 hover:text-primary group flex items-center space-x-3 rounded-xl px-4 py-3 text-gray-700 transition-all duration-200 hover:bg-gradient-to-r dark:text-gray-300"
          href="#">
          <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path
              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
          </svg>
          <span class="font-medium">Content</span>
        </a>
      </div>

      <div class="border-t border-gray-200 pt-6 dark:border-gray-700">
        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button
            class="group flex w-full items-center space-x-3 rounded-xl px-4 py-3 text-red-600 transition-all duration-200 hover:bg-red-50 dark:hover:bg-red-900/20"
            type="submit">
            <svg class="h-5 w-5 transition-transform group-hover:scale-110" fill="none"
              stroke="currentColor" viewBox="0 0 24 24">
              <path
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <span class="font-medium">Logout</span>
          </button>
        </form>
      </div>
    </nav>
  </div>
</aside>
