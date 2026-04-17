@props(['pageTitle' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport">
    <title>{{ $pageTitle }}</title>

    <!-- Fonts & Icons -->
    <link
      href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&display=swap"
      rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{ $styles ?? '' }}
  </head>

  <body class="overflow-x-hidden scroll-smooth bg-[#FEFCF8] font-sans text-primary">
    <!-- Hero Section -->
    <x-layouts.header />
    {{ $slot }}
    <x-layouts.footer />
    <div class="fixed right-6 top-6 z-2000 flex flex-col gap-3" id="toastContainer"></div>

    <!-- Smooth scroll and navbar script -->
    <script>
      // Smooth scroll for "Explore Services" button
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth'
            });
          }
        });
      });

      function showToast(type = 'success', message = '') {
        const container = document.getElementById('toastContainer');

        const toast = document.createElement('div');

        toast.className = `
          flex items-center gap-3 rounded-xl px-4 py-3 text-sm shadow-lg backdrop-blur-xl border
          transition-all duration-300 opacity-0 translate-y-[-10px]
          ${type === 'success' 
            ? 'bg-green-500/20 border-green-400/30 text-green-800' 
            : 'bg-red-500/20 border-red-400/30 text-red-800'}
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
    </script>
    {{ $scripts ?? '' }}
  </body>

</html>
