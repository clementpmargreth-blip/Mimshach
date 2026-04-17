<div class="relative">
   <div class="pointer-events-none absolute inset-x-0 bottom-0 h-100 bg-linear-to-t from-[--color-accent]/30 via-transparent to-transparent"></div>


<footer class="relative mt-24 px-4 z-10">
  <div class="pointer-events-none absolute inset-0">
    <div
      class="absolute inset-0 bg-gradient-to-br from-white/20 via-white/5 to-transparent opacity-40">
    </div>
    <div
      class="absolute left-0 top-0 h-24 w-full bg-gradient-to-b from-white/30 to-transparent opacity-30">
    </div>
  </div>
  <div
    class="relative mx-auto w-full max-w-[1400px] rounded-3xl border border-white/20 bg-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.12)] backdrop-blur-xl">
    <div
      class="absolute inset-0 bg-gradient-to-br from-white/20 via-white/5 to-transparent opacity-40">
    </div>
    <div
      class="absolute left-0 top-0 h-24 w-full bg-gradient-to-b from-white/30 to-transparent opacity-30">
    </div>
  </div>

  <div class="relative mx-auto w-[94%] max-w-[1400px] py-12">

    <!-- Grid -->
    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

      <!-- About -->
      <div>
        <div class="font-display mb-3 text-xl font-bold tracking-tight text-accent">
          MIMSHACH
        </div>
        <p class="mb-4 text-sm leading-relaxed text-primary/80">
          Empowering global education dreams with personalized guidance and unmatched support.
        </p>

        <!-- Socials -->
        <div class="flex items-center gap-3">
          @foreach ([
        'instagram' => 'fab fa-instagram',
        'linkedin' => 'fab fa-linkedin-in',
        'facebook' => 'fab fa-facebook-f',
        'youtube' => 'fab fa-youtube'
    ] as $name => $icon)
            <a class="group relative flex h-10 w-10 items-center justify-center rounded-full bg-white/20 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:scale-110 hover:bg-accent"
              href="#">

              <i
                class="{{ $icon }} text-sm text-primary transition group-hover:text-white"></i>

              <!-- Glow effect -->
              <span
                class="absolute inset-0 rounded-full bg-accent/30 opacity-0 blur-md transition group-hover:opacity-100"></span>
            </a>
          @endforeach
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h4 class="mb-4 text-sm font-semibold uppercase tracking-wide text-primary">
          Quick Links
        </h4>
        <ul class="space-y-2 text-sm">
          <li><a class="text-primary/80 transition hover:text-accent"
              href="{{ route('home') }}">Home</a></li>
          <li><a class="text-primary/80 transition hover:text-accent"
              href="{{ route('admissions.index') }}">Admission</a></li>
          <li><a class="text-primary/80 transition hover:text-accent"
              href="{{ route('fundings.index') }}">Student Funding</a></li>
          <li><a class="text-primary/80 transition hover:text-accent"
              href="{{ route('universities.index') }}">Universities</a></li>
          <li><a class="text-primary/80 transition hover:text-accent"
              href="{{ route('events.index') }}">Events</a></li>
          <li><a class="text-primary/80 transition hover:text-accent"
              href="{{ route('contact.index') }}">Contact</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h4 class="mb-4 text-sm font-semibold uppercase tracking-wide text-primary">
          Contact
        </h4>
        <ul class="space-y-3 text-sm text-primary/80">
          <li class="flex items-start gap-2">
            <i class="fas fa-map-marker-alt mt-0.5 text-accent"></i>
            <span>Simon Mwansa Kapwepwe Avenue, 12, Avondale</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-phone text-accent"></i>
            <span>+260973260412</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-envelope text-accent"></i>
            <span>Info@mimshachconsultancy.com</span>
          </li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div>
        <h4 class="mb-4 text-sm font-semibold uppercase tracking-wide text-primary">
          Subscribe
        </h4>
        <p class="mb-3 text-sm text-primary/80">
          Get free study abroad guides and updates.
        </p>

        <form class="flex flex-col gap-2" id="newsletterForm">
          @csrf
          <input
            class="w-full rounded-xl border border-white/20 bg-white/20 px-3 py-2 text-sm backdrop-blur-md focus:outline-none focus:ring-2 focus:ring-accent"
            name="email" placeholder="Your email" required type="email">
          <button
            class="rounded-xl bg-accent px-4 py-2 text-sm font-medium text-white transition hover:bg-[#b8953f] cursor-pointer"
            type="submit">
            Subscribe
          </button>
        </form>
      </div>

    </div>

    <!-- Bottom -->
    <div class="mt-10 border-t border-white/20 pt-6 text-center text-sm text-primary/70">
      © 2025 Mimshach Education Centre. All rights reserved.
    </div>

  </div>
</footer>
</div>

<script>
  const form = document.getElementById('newsletterForm');

  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const res = await fetch("{{ route('newsletter.subscribe') }}", {
        method: "POST",
        headers: {
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
      });

      const data = await res.json();

      showToast('success', 'Subscribed successfully!');
      form.reset();

    } catch (err) {
      showToast('error', 'Something went wrong. Try again.');
    }
  });
</script>
