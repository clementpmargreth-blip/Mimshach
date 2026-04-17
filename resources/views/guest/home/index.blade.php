@php
  $partners = config('data.partners');
  $stats = config('data.stats');
  $services = config('data.services');
  $process_steps = config('data.process_steps');
  $testimonials = config('data.testimonials');
  $benefits = config('data.benefits');
@endphp

<x-app-layout pageTitle="Mimshach | Empowering Global Education Dreams">

  <!-- HERO -->
  <section class="relative flex min-h-[90vh] items-center bg-primary text-white"
    data-navbar-theme="light" id='hero'>
    <div class="mx-auto w-[94%] max-w-[1400px]">

      <div class="max-w-2xl">
        <h1 class="font-display text-4xl font-bold leading-tight md:text-6xl">
          Unlock a World of Opportunities
        </h1>

        <p class="mt-6 text-lg text-white/80">
          Personalized guidance for your international education journey – from application to
          arrival and beyond.
        </p>

        <div class="mt-8 flex flex-wrap gap-4">
          <a class="rounded-full bg-accent px-6 py-3 font-semibold text-primary transition hover:opacity-90"
            href="{{ route('consultation.index') }}">
            Start Your Journey
          </a>

          <a class="rounded-full border border-white/30 px-6 py-3 font-semibold text-white transition hover:bg-white/10"
            href="#services">
            Explore Services
          </a>
        </div>
      </div>

    </div>

    <!-- scroll -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce text-white/60">
      <i class="fas fa-chevron-down"></i>
    </div>
  </section>

  <!-- PARTNERS -->
  <section class="border-y border-black/5 bg-white py-6" data-navbar-theme="dark" id='partners'>
    <div class="mx-auto w-[94%] max-w-350 overflow-hidden">
      <div
        class="partners-marquee text-primary/60 flex items-center gap-10 whitespace-nowrap text-sm font-medium">
        @foreach ($partners as $partner)
          <span class="transition hover:text-accent">{{ $partner }}</span>
        @endforeach
        <!-- Duplicate for seamless loop -->
        @foreach ($partners as $partner)
          <span class="transition hover:text-accent">{{ $partner }}</span>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="bg-white py-20" data-navbar-theme="dark" id='about'>
    <div class="mx-auto grid w-[94%] max-w-350 items-center gap-12 lg:grid-cols-2">

      <div>
        <span class="text-sm font-semibold uppercase tracking-wide text-accent">
          About Mimshach
        </span>

        <h2 class="mt-3 text-3xl font-bold text-primary">
          Bridging Dreams & Destinations
        </h2>

        <p class="text-primary/70 mt-6 text-lg">
          For over a decade, Mimshach Education Centre has been the trusted companion for thousands
          of students.
          We don't just process applications; we mentor, guide, and celebrate every acceptance.
        </p>

        <!-- stats -->
        <div class="mt-8 flex flex-wrap gap-10">
          @foreach ($stats as $stat)
            <div>
              <div class="text-2xl font-bold text-accent">{{ $stat['number'] }}</div>
              <div class="text-primary/70 text-sm">{{ $stat['label'] }}</div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- images -->
      <div class="grid grid-cols-2 gap-4">
        <img class="h-40 w-full rounded-2xl object-cover" src="grad.jpg">
        <img class="h-40 w-full rounded-2xl object-cover" src="chri.jpg">
        <img class="col-span-2 h-40 w-full rounded-2xl object-cover" src="christy.jpg">
      </div>

    </div>
  </section>

  <!-- SERVICES -->
  <section class="bg-[#F0EEE9] py-20" data-navbar-theme="dark" id="services">
    <div class="mx-auto w-[94%] max-w-350 text-center">

      <span class="text-sm font-semibold uppercase tracking-wide text-accent">
        Our Services
      </span>

      <h2 class="mt-3 text-3xl font-bold text-primary">
        Comprehensive Support for International Education
      </h2>

      <p class="text-primary/70 mt-3">
        We guide you through every stage with personalized care.
      </p>

      <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $service)
          <div
            class="rounded-2xl bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

            <div class="mb-4 text-xl text-accent">
              <i class="{{ $service['icon'] }}"></i>
            </div>

            <h3 class="font-semibold text-primary">
              {{ $service['title'] }}
            </h3>

            <p class="text-primary/70 mt-2 text-sm">
              {{ $service['description'] }}
            </p>

            <a class="mt-4 inline-block text-sm font-medium text-accent"
              href="{{ route($service['link']) }}">
              Learn More →
            </a>
          </div>
        @endforeach
      </div>

    </div>
  </section>

  <!-- PROCESS -->
  <section class="bg-white py-20" data-navbar-theme="dark" id='process'>
    <div class="mx-auto w-[94%] max-w-350 text-center">

      <span class="text-sm font-semibold uppercase tracking-wide text-accent">
        How We Operate
      </span>

      <h2 class="mt-3 text-3xl font-bold text-primary">
        Your Journey, Step by Step
      </h2>

      <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 justify-center">
        @foreach ($process_steps as $step)
          <div class="text-center sm:last:col-span-2 sm:last:mx-auto lg:last:col-span-1">
            <div
              class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-accent font-bold text-primary">
              {{ $step['number'] }}
            </div>
            <h4 class="font-semibold text-primary">{{ $step['title'] }}</h4>
            <p class="text-primary/70 mt-2 text-sm">{{ $step['description'] }}</p>
          </div>
        @endforeach
      </div>

    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="bg-primary py-20 text-white" data-navbar-theme="light"
    id='testimonials'>
    <div class="mx-auto w-[94%] max-w-350 text-center">

      <span class="text-sm font-semibold uppercase tracking-wide text-accent">
        Client Praise
      </span>

      <h2 class="mt-3 text-3xl font-bold">
        What Our Students Say
      </h2>

      <div class="mt-12 grid gap-5 [grid-template-columns:repeat(auto-fit,minmax(280px,1fr))]">
        @foreach ($testimonials as $testimonial)
          <div class="rounded-2xl bg-white/10 p-6 backdrop-blur-md">

            <p class="text-sm text-white/80">"{{ $testimonial['quote'] }}"</p>

            <div class="mt-6 flex items-center gap-3">
              <img class="h-10 w-10 rounded-full object-cover" src="{{ $testimonial['image'] }}">
              <div>
                <div class="text-sm font-semibold">{{ $testimonial['author'] }}</div>
                <div class="text-xs text-white/60">{{ $testimonial['position'] }}</div>
              </div>
            </div>

          </div>
        @endforeach
      </div>

    </div>
  </section>

  <!-- WHY -->
  <section class="bg-white py-20" data-navbar-theme="dark" id='why'>
    <div class="mx-auto w-[94%] max-w-[1400px] text-center">

      <span class="text-sm font-semibold uppercase tracking-wide text-accent">
        Why Mimshach
      </span>

      <h2 class="mt-3 text-3xl font-bold text-primary">
        The Difference We Make
      </h2>

      <div class="mt-12 grid gap-6 md:grid-cols-2">
        @foreach ($benefits as $benefit)
          <div class="rounded-2xl border border-gray-100 p-6 ">

            <div class="mb-4 text-accent">
              <i class="{{ $benefit['icon'] }}"></i>
            </div>

            <h4 class="font-semibold text-primary">{{ $benefit['title'] }}</h4>
            <p class="text-primary/70 mt-2 text-sm">{{ $benefit['description'] }}
            </p>

          </div>
        @endforeach
      </div>

    </div>
  </section>

  <!-- CTA -->
  <section class="py-20" data-navbar-theme="dark" id='cta'>
    <div class="mx-auto w-[94%] max-w-350">
      <div
        class="rounded-3xl bg-accent p-10 text-center text-primary">

        <h2 class="text-3xl font-bold">
          Start Your Global Education Journey Today
        </h2>

        <p class="mt-4">
          Let's turn your dream into a plan.
        </p>

        <a class="mt-6 inline-block rounded-full bg-primary px-6 py-3 text-white"
          href="{{route('contact.index')}}">
          Contact Us
        </a>

      </div>
    </div>
  </section>

</x-app-layout>

  <style>
    .partners-marquee {
      animation: scroll-left 20s linear infinite;
    }

    @keyframes scroll-left {
      0% {
        transform: translateX(0);
      }

      100% {
        transform: translateX(-50%);
      }
    }
  </style>
