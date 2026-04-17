@php
  $links = config('data.links');
@endphp

<!-- Navigation - Glassmorphic Premium (Fixed) -->
<nav
  class="fixed left-1/2 top-2 z-[1200] flex w-[94%] max-w-[1400px] -translate-x-1/2 items-center justify-between rounded-[80px] border border-white/20 bg-white/10 px-4 py-2 text-white shadow-md backdrop-blur-md transition-all duration-300 md:top-3 md:px-5 md:py-3 lg:px-6"
  id="navbar">

  <div
    class="logo font-display bg-linear-to-r from-[#C7A252] to-[#E4B363] bg-clip-text text-xl font-bold tracking-tight text-transparent sm:text-2xl md:text-[1.9rem]">
    MIMSHACH
  </div>

  <!-- Desktop Menu -->
  <ul class="hidden list-none items-center gap-3 lg:flex lg:gap-6 xl:gap-8">
    @foreach ($links as $link)
      <li class="whitespace-nowrap">
        <a class="{{ request()->routeIs($link['route']) ? 'after:w-full text-accent' : 'text-white/80' }} links relative pb-1 text-sm font-medium no-underline transition-colors duration-200 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-[#E4B363] after:transition-all after:duration-300 after:content-[''] hover:after:w-full lg:text-base"
          href="{{ route($link['route']) }}">
          {{ $link['label'] }}
        </a>
      </li>
    @endforeach
  </ul>

  <!-- Mobile Menu Button -->
  <button
    class="relative z-50 cursor-pointer border-none bg-transparent text-2xl text-white transition-colors focus:outline-none lg:hidden"
    id="menuBtn">
    <i class="fa-solid fa-bars" id='menuIcon'></i>
  </button>
</nav>

<div
  class="pointer-events-none fixed left-1/2 top-0 z-[1100] w-[94%] max-w-[1400px] -translate-x-1/2 -translate-y-2.5 rounded-2xl opacity-0 shadow-md lg:hidden"
  id="mobileSubNav">
  <div class="relative overflow-hidden rounded-2xl">
    <div
      class="flex touch-pan-x gap-3 overflow-x-auto whitespace-nowrap rounded-2xl border border-white/20 bg-white/10 px-3 py-2 shadow-md backdrop-blur-md"
      id='mobileSubNavInner'>

      @foreach ($links as $link)
        <a class="{{ request()->routeIs($link['route'])
            ? 'bg-accent text-white'
            : 'text-white/80 hover:bg-accent/10' }} links shrink-0 rounded-full px-4 py-2 text-sm font-medium transition-all duration-200"
          href="{{ route($link['route']) }}">
          {{ $link['label'] }}
        </a>
      @endforeach

    </div>
  </div>
</div>

<style>
  /* Custom styles for transparent primary color backgrounds */
  .navbar-primary-transparent {
    background: rgba(10, 25, 47, 0.4) !important;
    backdrop-filter: blur(14px) saturate(140%);
    border-color: rgba(255, 255, 255, 0.2) !important;
  }

  /* .navbar-primary-transparent .links {
    color: rgba(255, 255, 255, 0.9) !important;
  } */

  .navbar-primary-transparent .links:hover {
    color: #E4B363 !important;
  }

  /* Mobile subnav styles */
  .mobile-subnav-transparent {
    background: rgba(10, 25, 47, 0.4) !important;
    backdrop-filter: blur(12px) !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
  }

  .mobile-subnav-transparent .links {
    color: rgba(255, 255, 255, 0.9) !important;
  }

  /* Smooth transitions */
  #navbar,
  #navbar .links,
  #menuBtn,
  #mobileSubNavInner {
    transition: all 300ms ease !important;
  }

  #mobileSubNavInner {
    -webkit-overflow-scrolling: touch;
    overscroll-behavior-x: contain;

    /* Hide scrollbar (all browsers) */
    scrollbar-width: none;
    /* Firefox */
    -ms-overflow-style: none;
    /* IE/Edge */
  }

  #mobileSubNavInner::-webkit-scrollbar {
    display: none;
    /* Chrome, Safari */
  }
</style>

<script>
  (function() {
    // DOM Elements
    const menuBtn = document.getElementById('menuBtn');
    const menuIcon = document.getElementById('menuIcon');
    const mobileSubNav = document.getElementById('mobileSubNav');
    const subNav = document.getElementById('mobileSubNavInner');
    const navbar = document.getElementById('navbar');
    const links = document.querySelectorAll('.links');
    const heroSection = document.querySelector('#hero');

    let isMenuOpen = false;
    let isScrolledPastHero = false;

    // Function for navbar when in hero section (fully transparent with white text)
    function setHeroMode() {
      navbar.classList.remove('navbar-primary-transparent');
      navbar.classList.add('bg-white/10');

      links.forEach(link => {
        if (!link.classList.contains('text-accent')) {
          link.classList.add('text-white/80');
          link.classList.remove('text-[var(--color-primary)]');
        }
      });

      menuBtn?.classList.add('text-white');
      menuBtn?.classList.remove('text-[var(--color-primary)]');

      const mobileInner = document.getElementById('mobileSubNavInner');
      mobileInner?.classList.add('bg-white/10');
      mobileInner?.classList.remove('mobile-subnav-transparent');
    }

    // Function for navbar when scrolled past hero (using transparent primary color)
    function setScrolledMode() {
      navbar.classList.remove('bg-white/10');
      navbar.classList.add('navbar-primary-transparent');

      links.forEach(link => {
        if (!link.classList.contains('text-accent')) {
          link.classList.remove('text-white/80');
        }
      });

      menuBtn?.classList.add('text-white');

      const mobileInner = document.getElementById('mobileSubNavInner');
      mobileInner?.classList.remove('bg-white/10');
      mobileInner?.classList.add('mobile-subnav-transparent');
    }

    // Check scroll position relative to hero section
    function checkScrollPosition() {
      if (!heroSection) {
        // If no hero section, default to scrolled mode
        if (!isScrolledPastHero) {
          isScrolledPastHero = true;
          setScrolledMode();
        }
        return;
      }

      const heroBottom = heroSection.getBoundingClientRect().bottom;
      const navbarHeight = navbar?.offsetHeight || 80;

      // Check if we've scrolled past the hero section
      const scrolledPast = heroBottom <= navbarHeight + 10;

      if (scrolledPast && !isScrolledPastHero) {
        // Just scrolled past hero
        isScrolledPastHero = true;
        setScrolledMode();
      } else if (!scrolledPast && isScrolledPastHero) {
        // Scrolled back into hero
        isScrolledPastHero = false;
        setHeroMode();
      } else if (!scrolledPast && !isScrolledPastHero) {
        // Still in hero, ensure hero mode is applied
        setHeroMode();
      }
    }

    // Mobile nav positioning
    function positionMobileNav() {
      if (!navbar || !mobileSubNav) return;

      const navRect = navbar.getBoundingClientRect();
      const offset = navRect.top + navRect.height + 8;
      mobileSubNav.style.top = `${offset}px`;
    }

    // Mobile menu functions
    function openMenu() {
      positionMobileNav();

      mobileSubNav.classList.remove('pointer-events-none', 'opacity-0', 'translate-y-[-10px]');
      mobileSubNav.classList.add('opacity-100', 'translate-y-0');

      if (menuIcon) {
        menuIcon.classList.remove('fa-bars');
        menuIcon.classList.add('fa-times');
      }

      isMenuOpen = true;
    }

    function closeMenu() {
      mobileSubNav.classList.remove('opacity-100', 'translate-y-0');
      mobileSubNav.classList.add('opacity-0', 'translate-y-[-10px]', 'pointer-events-none');

      if (menuIcon) {
        menuIcon.classList.remove('fa-times');
        menuIcon.classList.add('fa-bars');
      }

      isMenuOpen = false;
    }

    function toggleMenu() {
      isMenuOpen ? closeMenu() : openMenu();
    }

    // Wheel event for mobile subnav
    if (subNav) {
      subNav.addEventListener('wheel', (e) => {
        if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
          e.preventDefault();
          subNav.scrollLeft += e.deltaY;
        }
      }, {
        passive: false
      });
    }

    // Event listeners
    menuBtn?.addEventListener('click', toggleMenu);

    document.addEventListener('click', (e) => {
      if (isMenuOpen && !mobileSubNav.contains(e.target) && !menuBtn.contains(e.target)) {
        closeMenu();
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && isMenuOpen) {
        closeMenu();
      }
    });

    // Throttled scroll handler
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(() => {
          checkScrollPosition();
          positionMobileNav();
          ticking = false;
        });
        ticking = true;
      }
    });

    // Initial setup
    window.addEventListener('load', () => {
      positionMobileNav();
      checkScrollPosition(); // Set initial theme
    });

    window.addEventListener('resize', () => {
      positionMobileNav();
      checkScrollPosition(); // Re-evaluate on resize
    });
  })();
</script>
