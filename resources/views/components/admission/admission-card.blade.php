@props(['admission' => []])

<div
  class="group relative flex flex-col overflow-hidden rounded-[28px] border border-black/5 bg-white shadow-sm transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl md:flex-row">

  <!-- Image Wrapper -->
  <div class="relative h-56 w-full overflow-hidden md:h-auto md:w-[280px]">

    <!-- Image -->
    <div
      class="h-full w-full bg-cover bg-center transition duration-700 group-hover:scale-110"
      style="background-image: url('{{ $admission['image'] }}');">
    </div>

    <!-- Gradient Overlay -->
    <div
      class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/40 via-black/10 to-transparent opacity-70 md:hidden">
    </div>

    <!-- Floating Tag (optional premium touch) -->
    <div class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-[var(--color-primary)] shadow backdrop-blur">
      {{ $admission->country }}
    </div>

  </div>

  <!-- Content -->
  <div class="flex flex-1 flex-col p-6 md:p-7">

    <!-- Meta -->
    <div class="mb-4 flex flex-wrap items-center gap-4 text-xs font-medium text-gray-500">

      <span class="flex items-center gap-1">
        <i class="far fa-calendar-alt text-[var(--color-accent)]"></i>
        {{ $admission->deadline->format('M d, Y') }}
      </span>

      <span class="flex items-center gap-1">
        <i class="fas fa-university text-[var(--color-accent)]"></i>
        {{ $admission->university->name }}
      </span>

    </div>

    <!-- Title -->
    <h3 class="mb-3 text-[1.35rem] font-semibold leading-snug text-[var(--color-primary)] md:text-[1.5rem]">
      <a
        href="{{ route('admissions.admission', $admission) }}"
        class="transition duration-300 group-hover:text-[var(--color-accent)]">
        {{ $admission->title }}
      </a>
    </h3>

    <!-- Excerpt -->
    <p class="mb-6 text-sm leading-relaxed text-gray-600">
      {{ $admission->subtitle }}
    </p>

    <!-- Footer -->
    <div class="mt-auto flex flex-col-reverse md:flex-row md:items-center gap-4 md:gap-0 justify-between">

      <!-- Read More -->
      <a
        href="{{ route('admissions.admission', $admission) }}"
        class="flex items-center gap-2 text-sm font-semibold text-[var(--color-accent)] transition">
        Read more
        <i class="fas fa-arrow-right transition duration-300 group-hover:translate-x-1"></i>
      </a>

      <!-- Tags -->
      <div class="flex gap-2">

        <span
          class="rounded-full bg-[var(--color-accent)]/10 px-3 py-1 text-xs font-medium text-[var(--color-primary)]">
          {{ $admission->program }}
        </span>

        <span
          class="rounded-full bg-[var(--color-accent)]/10 px-3 py-1 text-xs font-medium text-[var(--color-primary)]">
          {{ $admission->year }}
        </span>

      </div>

    </div>

  </div>
</div>