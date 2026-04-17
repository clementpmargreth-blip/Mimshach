<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>Dashboard - {{ config('app.name', 'Mimshach') }} Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      /* Custom scrollbar for modern look */
      ::-webkit-scrollbar {
        width: 0;
        height: 0;
      }

      ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
      }

      /* Smooth transitions */
      .sidebar-transition {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      }

      /* Card hover effects */
      .stat-card {
        transition: all 0.3s ease;
      }

      .stat-card:hover {
        transform: translateY(-4px);
      }

      /* Chart container */
      .chart-container {
        position: relative;
        height: 250px;
        width: 100%;
      }

      /* Mobile menu overlay */
      .mobile-menu-overlay {
        transition: opacity 0.3s ease;
      }

      /* Hide scrollbar on mobile when menu is open */
      body.menu-open {
        overflow: hidden;
      }

      /* Skeleton loading animation */
      @keyframes pulse {

        0%,
        100% {
          opacity: 1;
        }

        50% {
          opacity: 0.5;
        }
      }

      .skeleton {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
      }

      /* Table row hover effect */
      .table-row-hover {
        transition: background-color 0.2s ease;
      }
    </style>
  </head>

  <body
    class="h-full overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased dark:from-gray-900 dark:to-gray-950">
    <div class="flex h-full">


      <!-- Main Content -->
      <div class="flex flex-1 flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header
          class="sticky top-0 z-10 bg-white/80 shadow-sm backdrop-blur-lg dark:bg-gray-800/80">
          <div class="flex h-16 items-center justify-between px-4 sm:px-6">
            <div class="flex items-center space-x-4">
              <button
                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden dark:text-gray-400 dark:hover:bg-gray-700"
                id="openSidebarBtn">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M4 6h16M4 12h16M4 18h16" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2"></path>
                </svg>
              </button>
              <div>
                <h1
                  class="from-primary to-accent bg-gradient-to-r bg-clip-text text-2xl font-bold text-transparent">
                  Dashboard</h1>
                <p class="text-xs text-gray-500 dark:text-gray-400">Welcome back, Admin</p>
              </div>
            </div>

            <div class="flex items-center space-x-3">
              <!-- Search -->
              <button
                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2"></path>
                </svg>
              </button>

              <!-- Notifications -->
              <button
                class="relative rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-red-500"></span>
              </button>

              <!-- Theme Toggle -->
              <button
                class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700"
                id="themeToggle">
                <svg class="hidden h-5 w-5 dark:block" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <svg class="block h-5 w-5 dark:hidden" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
              </button>

              <!-- User Menu -->
              <div class="relative" x-cloak x-data="{ open: false }">
                <button @click="open = !open"
                  class="flex items-center space-x-2 rounded-lg p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <div class="relative">
                    <div
                      class="from-primary to-accent flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r">
                      <span class="text-sm font-medium text-white">AD</span>
                    </div>
                    <div
                      class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white bg-green-500 dark:border-gray-800">
                    </div>
                  </div>
                  <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"></path>
                  </svg>
                </button>
                <div @click.away="open = false"
                  class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800"
                  style="display: none;" x-show="open">
                  <div class="p-2">
                    <div class="border-b border-gray-200 px-3 py-2 dark:border-gray-700">
                      <p class="text-sm font-medium text-gray-900 dark:text-white">Admin User</p>
                      <p class="text-xs text-gray-500 dark:text-gray-400">admin@mimshach.com</p>
                    </div>
                    <a class="flex items-center space-x-2 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                      href="#">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                      <span>Profile</span>
                    </a>
                    <a class="flex items-center space-x-2 rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                      href="#">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                      <span>Settings</span>
                    </a>
                    <div class="border-t border-gray-200 dark:border-gray-700"></div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                      @csrf
                      <button
                        class="flex w-full items-center space-x-2 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20"
                        type="submit">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                          </path>
                        </svg>
                        <span>Logout</span>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
          <div class="space-y-6">
            <!-- Welcome Banner -->
            <div
              class="from-primary to-accent relative overflow-hidden rounded-2xl bg-gradient-to-r p-6 text-white shadow-xl">
              <div
                class="absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-8 transform rounded-full bg-white/20 blur-2xl">
              </div>
              <div
                class="absolute bottom-0 left-0 h-40 w-40 -translate-x-8 translate-y-8 transform rounded-full bg-white/10 blur-2xl">
              </div>
              <div class="relative">
                <h2 class="text-2xl font-bold">Welcome back, Admin! 👋</h2>
                <p class="mt-2 text-white/90">Here's what's happening with your platform today.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                  <span
                    class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-sm backdrop-blur-sm">
                    <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    Last updated: {{ now()->format('F j, Y, g:i a') }}
                  </span>
                </div>
              </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
              <!-- Consultations Card -->
              <div
                class="stat-card group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div
                  class="bg-primary/10 group-hover:bg-primary/20 absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-8 transform rounded-full blur-2xl transition-all duration-300">
                </div>
                <div class="relative">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total
                        Consultations</p>
                      <p class="mt-2 text-4xl font-bold text-gray-800 dark:text-white">
                        {{ $totalConsultations ?? 0 }}</p>
                    </div>
                    <div
                      class="bg-primary/10 group-hover:bg-primary/20 rounded-2xl p-3 transition-all duration-300 group-hover:scale-110">
                      <svg class="text-primary h-8 w-8" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="mt-4 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span
                      class="text-sm font-semibold text-green-600 dark:text-green-400">+{{ $newConsultationsToday ?? 0 }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">from yesterday</span>
                  </div>
                </div>
              </div>

              <!-- Newsletters Card -->
              <div
                class="stat-card group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div
                  class="bg-accent/10 group-hover:bg-accent/20 absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-8 transform rounded-full blur-2xl transition-all duration-300">
                </div>
                <div class="relative">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Newsletter
                        Subscribers</p>
                      <p class="mt-2 text-4xl font-bold text-gray-800 dark:text-white">
                        {{ $totalNewsletters ?? 0 }}</p>
                    </div>
                    <div
                      class="bg-accent/10 group-hover:bg-accent/20 rounded-2xl p-3 transition-all duration-300 group-hover:scale-110">
                      <svg class="text-accent h-8 w-8" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="mt-4 flex items-center space-x-2">
                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <span
                      class="text-sm font-semibold text-green-600 dark:text-green-400">+{{ $newNewslettersToday ?? 0 }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">today</span>
                  </div>
                </div>
              </div>

              <!-- Events Card -->
              <div
                class="stat-card group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div
                  class="absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-8 transform rounded-full bg-purple-500/10 blur-2xl transition-all duration-300 group-hover:bg-purple-500/20">
                </div>
                <div class="relative">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Events</p>
                      <p class="mt-2 text-4xl font-bold text-gray-800 dark:text-white">
                        {{ $totalEvents ?? 0 }}</p>
                    </div>
                    <div
                      class="rounded-2xl bg-purple-500/10 p-3 transition-all duration-300 group-hover:scale-110 group-hover:bg-purple-500/20">
                      <svg class="h-8 w-8 text-purple-600 dark:text-purple-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="mt-4 space-y-1">
                    <p class="text-primary-600 dark:text-primary-400 text-sm">
                      {{ $upcomingEvents ?? 0 }} upcoming events</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      {{ $totalEventRegistrations ?? 0 }} total registrations</p>
                  </div>
                </div>
              </div>

              <!-- Content Card -->
              <div
                class="stat-card group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div
                  class="absolute right-0 top-0 h-32 w-32 -translate-y-8 translate-x-8 transform rounded-full bg-orange-500/10 blur-2xl transition-all duration-300 group-hover:bg-orange-500/20">
                </div>
                <div class="relative">
                  <div class="flex items-center justify-between">
                    <div>
                      <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Content
                        Overview</p>
                      <div class="mt-2 space-y-1">
                        <p class="text-2xl font-bold text-gray-800 dark:text-white">
                          {{ $totalUniversities ?? 0 }} Universities</p>
                      </div>
                    </div>
                    <div
                      class="rounded-2xl bg-orange-500/10 p-3 transition-all duration-300 group-hover:scale-110 group-hover:bg-orange-500/20">
                      <svg class="h-8 w-8 text-orange-600 dark:text-orange-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                      </svg>
                    </div>
                  </div>
                  <div class="mt-4 space-y-1">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                      {{ $totalAdmissions ?? 0 }} Admissions <span
                        class="text-green-600 dark:text-green-400">({{ $activeAdmissions ?? 0 }}
                        active)</span></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ $totalFunding ?? 0 }}
                      Funding | {{ $totalBlogs ?? 0 }} Blogs</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
              <div
                class="rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Consultations
                      Trend</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Last 7 days activity</p>
                  </div>
                  <select
                    class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                  </select>
                </div>
                <div class="chart-container">
                  <canvas id="consultationChart"></canvas>
                </div>
              </div>
              <div
                class="rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Newsletter
                      Growth</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Subscription trends</p>
                  </div>
                  <select
                    class="rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                  </select>
                </div>
                <div class="chart-container">
                  <canvas id="newsletterChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Recent Data Tables -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
              <!-- Recent Consultations -->
              <div
                class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                  <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                      <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent
                        Consultation Requests</h3>
                      <p class="text-xs text-gray-500 dark:text-gray-400">Latest inquiries from
                        students</p>
                    </div>
                    <a class="text-primary hover:text-primary/80 dark:text-primary-400 inline-flex items-center space-x-1 text-sm font-medium"
                      href="#">
                      <span>View all</span>
                      <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"></path>
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                      <tr>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Name</th>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Email</th>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Date</th>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Status</th>
                      </tr>
                    </thead>
                    <tbody
                      class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                      @forelse ($recentConsultations ?? [] as $consultation)
                        <tr
                          class="table-row-hover transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                          <td
                            class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                            {{ $consultation->full_name }}
                          </td>
                          <td
                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                            {{ $consultation->email }}
                          </td>
                          <td
                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $consultation->created_at->format('M d, Y') }}
                          </td>
                          <td class="whitespace-nowrap px-6 py-4">
                            <span
                              class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800 dark:bg-green-900 dark:text-green-200">New</span>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td class="px-6 py-12 text-center text-gray-500 dark:text-gray-400"
                            colspan="4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                              stroke="currentColor" viewBox="0 0 24 24">
                              <path
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                              </path>
                            </svg>
                            <p class="mt-2">No consultations yet</p>
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Recent Newsletters -->
              <div
                class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
                <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                  <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                      <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Recent
                        Newsletter Subscriptions</h3>
                      <p class="text-xs text-gray-500 dark:text-gray-400">New subscribers</p>
                    </div>
                    <a class="text-primary hover:text-primary/80 dark:text-primary-400 inline-flex items-center space-x-1 text-sm font-medium"
                      href="#">
                      <span>View all</span>
                      <svg class="h-4 w-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"></path>
                      </svg>
                    </a>
                  </div>
                </div>
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                      <tr>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Email</th>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Subscribed Date</th>
                        <th
                          class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                          Status</th>
                      </tr>
                    </thead>
                    <tbody
                      class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                      @forelse ($recentNewsletters ?? [] as $newsletter)
                        <tr
                          class="table-row-hover transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                          <td
                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">
                            {{ $newsletter->email }}
                          </td>
                          <td
                            class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $newsletter->subscribed_at->format('M d, Y H:i') }}
                          </td>
                          <td class="whitespace-nowrap px-6 py-4">
                            <span
                              class="inline-flex rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-800 dark:bg-blue-900 dark:text-blue-200">Active</span>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td class="px-6 py-12 text-center text-gray-500 dark:text-gray-400"
                            colspan="3">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                              stroke="currentColor" viewBox="0 0 24 24">
                              <path
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                              </path>
                            </svg>
                            <p class="mt-2">No subscribers yet</p>
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <!-- Recent Events -->
            <div
              class="overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:shadow-xl dark:bg-gray-800">
              <div class="border-b border-gray-200 px-6 py-4 dark:border-gray-700">
                <div class="flex flex-wrap items-center justify-between gap-4">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Upcoming Events
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Scheduled events and
                      activities</p>
                  </div>
                  <a class="text-primary hover:text-primary/80 dark:text-primary-400 inline-flex items-center space-x-1 text-sm font-medium"
                    href="#">
                    <span>View all</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"></path>
                    </svg>
                  </a>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                  <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                      <th
                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Title</th>
                      <th
                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Location</th>
                      <th
                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Date</th>
                      <th
                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Time</th>
                      <th
                        class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        Status</th>
                    </tr>
                  </thead>
                  <tbody
                    class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                    @forelse ($recentEvents ?? [] as $event)
                      <tr
                        class="table-row-hover transition-colors hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td
                          class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                          {{ $event->title }}
                        </td>
                        <td
                          class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                          {{ $event->location }}
                        </td>
                        <td
                          class="whitespace-nowrap px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                          {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                        </td>
                        <td
                          class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                          {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                          <span
                            class="inline-flex rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-semibold text-purple-800 dark:bg-purple-900 dark:text-purple-200">Upcoming</span>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td class="px-6 py-12 text-center text-gray-500 dark:text-gray-400"
                          colspan="5">
                          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            </path>
                          </svg>
                          <p class="mt-2">No upcoming events</p>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
      // Mobile sidebar functionality
      const sidebar = document.getElementById('sidebar');
      const openBtn = document.getElementById('openSidebarBtn');
      const closeBtn = document.getElementById('closeSidebarBtn');
      const overlay = document.getElementById('mobileOverlay');

      function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.classList.add('opacity-100', 'pointer-events-auto');
        document.body.classList.add('menu-open');
      }

      function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.classList.remove('opacity-100', 'pointer-events-auto');
        document.body.classList.remove('menu-open');
      }

      if (openBtn) openBtn.addEventListener('click', openSidebar);
      if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
      if (overlay) overlay.addEventListener('click', closeSidebar);

      // Theme toggle
      const themeToggle = document.getElementById('themeToggle');
      if (themeToggle) {
        themeToggle.addEventListener('click', () => {
          if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
          } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
          }
        });
      }

      // Check for saved theme preference
      if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window
          .matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      }

      // Close sidebar on window resize if open
      let resizeTimer;
      window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
          if (window.innerWidth >= 1024 && sidebar.classList.contains('translate-x-0')) {
            closeSidebar();
          }
        }, 250);
      });

      // Initialize Charts with sample data (replace with your actual data)
      document.addEventListener('DOMContentLoaded', function() {
        // Consultation Chart
        const consultationCtx = document.getElementById('consultationChart');
        if (consultationCtx) {
          @php
            $consultationLabels = $consultationChart['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $consultationValues = $consultationChart['values'] ?? [12, 19, 15, 17, 14, 23, 28];
          @endphp
          const consultationLabels = @json($consultationLabels);
          const consultationValues = @json($consultationValues);

          new Chart(consultationCtx.getContext('2d'), {
            type: 'line',
            data: {
              labels: consultationLabels,
              datasets: [{
                label: 'Consultations',
                data: consultationValues,
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: 'rgb(59, 130, 246)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  backgroundColor: 'rgba(0, 0, 0, 0.8)',
                  titleColor: '#fff',
                  bodyColor: '#e5e5e5',
                  padding: 10,
                  cornerRadius: 8
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                  }
                },
                x: {
                  grid: {
                    display: false
                  }
                }
              }
            }
          });
        }

        // Newsletter Chart
        const newsletterCtx = document.getElementById('newsletterChart');
        if (newsletterCtx) {
          @php
            $newsletterLabels = $newsletterChart['labels'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            $newsletterValues = $newsletterChart['values'] ?? [8, 12, 10, 15, 18, 22, 25];
          @endphp
          const newsletterLabels = @json($newsletterLabels);
          const newsletterValues = @json($newsletterValues);

          new Chart(newsletterCtx.getContext('2d'), {
            type: 'line',
            data: {
              labels: newsletterLabels,
              datasets: [{
                label: 'Subscriptions',
                data: newsletterValues,
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: 'rgb(34, 197, 94)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  backgroundColor: 'rgba(0, 0, 0, 0.8)',
                  titleColor: '#fff',
                  bodyColor: '#e5e5e5',
                  padding: 10,
                  cornerRadius: 8
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                  }
                },
                x: {
                  grid: {
                    display: false
                  }
                }
              }
            }
          });
        }
      });
    </script>
  </body>

</html>
