@props(['pageTitle' => ''])

<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>{{ $pageTitle }}</title>
    <!-- Add to your layout head section -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

      /* Base calendar */
      .flatpickr-calendar {
        background: #1f2937 !important;
        border: 1px solid #374151 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
        border-radius: 0.5rem !important;
      }

      /* Calendar arrow buttons */
      .flatpickr-calendar .flatpickr-prev-month,
      .flatpickr-calendar .flatpickr-next-month {
        fill: #9ca3af !important;
        color: #9ca3af !important;
      }

      .flatpickr-calendar .flatpickr-prev-month:hover,
      .flatpickr-calendar .flatpickr-next-month:hover {
        fill: #C6A43F !important;
        color: #C6A43F !important;
      }

      .flatpickr-calendar .flatpickr-prev-month:hover svg,
      .flatpickr-calendar .flatpickr-next-month:hover svg {
        fill: #C6A43F !important;
      }

      /* Months navigation bar */
      .flatpickr-calendar .flatpickr-months {
        background: #111827 !important;
        border-radius: 0.5rem 0.5rem 0 0 !important;
      }

      .flatpickr-calendar .flatpickr-month {
        color: #f3f4f6 !important;
        background: #111827 !important;
      }

      /* Current month display */
      .flatpickr-calendar .flatpickr-current-month {
        color: #f3f4f6 !important;
        padding-top: 10px !important;
      }

      .flatpickr-calendar .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: #374151 !important;
        color: #f3f4f6 !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.25rem !important;
      }

      .flatpickr-calendar .flatpickr-current-month input.cur-year {
        background: #374151 !important;
        color: #f3f4f6 !important;
        border: 1px solid #4b5563 !important;
        border-radius: 0.25rem !important;
      }

      .flatpickr-calendar .flatpickr-current-month input.cur-year:focus {
        outline: none !important;
        border-color: #C6A43F !important;
      }

      /* Weekday headers */
      .flatpickr-calendar .flatpickr-weekdays {
        background: #1f2937 !important;
      }

      .flatpickr-calendar .flatpickr-weekday {
        color: #9ca3af !important;
      }

      /* Individual days */
      .flatpickr-calendar .flatpickr-day {
        color: #e5e7eb !important;
        background: #1f2937 !important;
        /* border: 1px solid #374151 !important; */
        border-radius: 50% !important;
      }

      .flatpickr-calendar .flatpickr-day:hover {
        background: #C6A43F !important;
        color: #ffffff !important;
        border-color: #C6A43F !important;
      }

      /* Selected day - YOUR ACCENT COLOR */
      .flatpickr-calendar .flatpickr-day.selected,
      .flatpickr-calendar .flatpickr-day.startRange,
      .flatpickr-calendar .flatpickr-day.endRange,
      .flatpickr-calendar .flatpickr-day.selected.inRange,
      .flatpickr-calendar .flatpickr-day.startRange.inRange,
      .flatpickr-calendar .flatpickr-day.endRange.inRange,
      .flatpickr-calendar .flatpickr-day.selected:focus,
      .flatpickr-calendar .flatpickr-day.startRange:focus,
      .flatpickr-calendar .flatpickr-day.endRange:focus,
      .flatpickr-calendar .flatpickr-day.selected:hover,
      .flatpickr-calendar .flatpickr-day.startRange:hover,
      .flatpickr-calendar .flatpickr-day.endRange:hover {
        background: #C6A43F !important;
        border-color: #C6A43F !important;
        color: #ffffff !important;
      }

      /* Today's date */
      .flatpickr-calendar .flatpickr-day.today {
        border-color: #C6A43F !important;
        background: #1f2937 !important;
      }

      .flatpickr-calendar .flatpickr-day.today:hover {
        background: #C6A43F !important;
        color: #0A192F !important;
        border-color: #C6A43F !important;
      }

      .flatpickr-calendar .flatpickr-day.today.selected {
        background: #C6A43F !important;
        color: #0A192F !important;
      }

      /* Previous and next month days */
      .flatpickr-calendar .flatpickr-day.prevMonthDay,
      .flatpickr-calendar .flatpickr-day.nextMonthDay {
        color: #6b7280 !important;
        background: #1f2937 !important;
      }

      /* Disabled days */
      .flatpickr-calendar .flatpickr-day.disabled,
      .flatpickr-calendar .flatpickr-day.disabled:hover {
        color: #4b5563 !important;
        background: #1f2937 !important;
        border-color: #374151 !important;
      }

      /* Range selection */
      .flatpickr-calendar .flatpickr-day.inRange,
      .flatpickr-calendar .flatpickr-day.prevMonthDay.inRange,
      .flatpickr-calendar .flatpickr-day.nextMonthDay.inRange,
      .flatpickr-calendar .flatpickr-day.today.inRange,
      .flatpickr-calendar .flatpickr-day.prevMonthDay.today.inRange,
      .flatpickr-calendar .flatpickr-day.nextMonthDay.today.inRange {
        background: #374151 !important;
        border-color: #374151 !important;
      }

      /* Time picker (if used) */
      .flatpickr-calendar .flatpickr-time {
        border-color: #374151 !important;
        background: #1f2937 !important;
        border-top: 1px solid #374151 !important;
      }

      .flatpickr-calendar .flatpickr-time input,
      .flatpickr-calendar .flatpickr-time .flatpickr-am-pm {
        color: #f3f4f6 !important;
        background: #1f2937 !important;
      }

      .flatpickr-calendar .flatpickr-time input:hover,
      .flatpickr-calendar .flatpickr-time .flatpickr-am-pm:hover {
        background: #374151 !important;
      }

      .flatpickr-calendar .flatpickr-time .flatpickr-time-separator {
        color: #f3f4f6 !important;
      }

      /* Arrow buttons SVG */
      .flatpickr-calendar .flatpickr-prev-month svg,
      .flatpickr-calendar .flatpickr-next-month svg {
        fill: #9ca3af !important;
      }

      .flatpickr-calendar .flatpickr-prev-month:hover svg,
      .flatpickr-calendar .flatpickr-next-month:hover svg {
        fill: #C6A43F !important;
      }

      /* Ensure dropdown menu has proper styling */
      .flatpickr-calendar .flatpickr-monthDropdown-months option {
        background: #374151 !important;
        color: #f3f4f6 !important;
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

    {{ $styles ?? '' }}
  </head>

  <body
    class="h-full overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased dark:from-gray-900 dark:to-gray-950">
    <div class="flex h-full">
      <x-layouts.admin.navbar />

      <!-- Main Content -->
      <div class="flex flex-1 flex-col overflow-hidden">
        <!-- Top Navigation -->
        <x-layouts.admin.header />

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
          {{ $slot }}
        </main>

        <div class="z-2000 fixed right-6 top-6 flex flex-col gap-3" id="toastContainer"></div>
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

      function showToast(type = 'success', message = '') {
        const container = document.getElementById('toastContainer');

        const toast = document.createElement('div');

        toast.className = `
          flex items-center gap-3 rounded-xl px-4 py-3 text-sm shadow-lg backdrop-blur-xl border
          transition-all duration-300 opacity-0 translate-y-[-10px]
          ${type === 'success' 
            ? 'bg-green-500/20 border-green-400/30 text-green-800' 
            : 'bg-red-500/20 border-red-400/30 text-red-800 dark:text-red-200'}
        `;

        toast.innerHTML = `
          <span>${message}</span>
        `;

        container.appendChild(toast);

        // animate in
        requestAnimationFrame(() => {
          toast.classList.remove('opacity-0', 'translate-y-[-10px]');
        });

        // remove after 3s
        setTimeout(() => {
          toast.classList.add('opacity-0', 'translate-y-[-10px]');
          setTimeout(() => toast.remove(), 300);
        }, 3000);
      }

      // Initialize all date pickers
      document.querySelectorAll('.datepicker-input').forEach(input => {
        flatpickr(input, {
          dateFormat: "Y-m-d",
          allowInput: true,
          placeholder: input.placeholder
        });
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
    {{ $scripts ?? '' }}
  </body>

</html>
