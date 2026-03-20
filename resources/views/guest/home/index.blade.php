@php
  $partners = config('data.partners');
  $stats = config('data.stats');
  $services = config('data.services');
  $process_steps = config('data.process_steps');
  $testimonials = config('data.testimonials');
  $benefits = config('data.benefits');
@endphp

<x-app-layout pageTitle="Mimshach | Empowering Global Education Dreams">
    <section class="hero">
    <div class="hero-content">
      <h1>Unlock a World of Opportunities</h1>
      <p>Personalized guidance for your international education journey – from application to
        arrival and beyond.</p>
      <div class="hero-buttons">
        <a class="btn-primary" href="{{ route('consultation.index') }}">Start Your Journey</a>
        <a class="btn-secondary" href="#services">Explore Services</a>
      </div>
    </div>
    <div class="scroll-down"><i class="fas fa-chevron-down"></i></div>
  </section>

  <!-- Partners Strip -->
  <div class="partners">
    <div class="container">
      <div class="partner-logos">
        @foreach ($partners as $partner)
          <span>{{ $partner }}</span>
        @endforeach
      </div>
    </div>
  </div>

  <!-- About Section -->
  <section>
    <div class="container">
      <div class="about-grid">
        <div>
          <span class="section-label">About Mimshach</span>
          <h2 class="section-title">Bridging Dreams & Destinations</h2>
          <p style="margin-bottom: 30px; font-size: 18px;">For over a decade, Mimshach Education
            Centre has been the trusted companion for thousands of students. We don't just process
            applications; we mentor, we guide, and we celebrate every acceptance. Our team of
            experienced counselors and global alumni network ensures you're never alone.</p>
          <div class="about-stats">
            @foreach ($stats as $stat)
              <div class="stat-item">
                <div class="stat-number">{{ $stat['number'] }}</div>
                <div class="stat-label">{{ $stat['label'] }}</div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="about-collage">
          <img alt="Students smiling" class="collage-img" src="grad.jpg">
          <img alt="Graduation" class="collage-img" src="chri.jpg">
          <img alt="Campus library" class="collage-img" src="christy.jpg">
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section (with id="services") -->
  <section id="services" style="background: #F0EEE9;">
    <div class="container">
      <span class="section-label">Our Services</span>
      <h2 class="section-title">Comprehensive Support for International Education</h2>
      <p class="section-desc">We guide you through every stage with personalized care and
        expertise.</p>
      <div class="services-grid">
        @foreach ($services as $service)
          <div class="service-card">
            <div class="service-icon"><i class="{{ $service['icon'] }}"></i></div>
            <h3>{{ $service['title'] }}</h3>
            <p>{{ $service['description'] }}</p>
            <a class="learn-more" href="{{ $service['link'] }}">Learn More <i
              class="fas fa-arrow-right"></i></a>
          </div>
        @endforeach
      </div>
      <div style="text-align: center; margin-top: 50px;">
        <a href="startyourjourneyform.html"
          style="color: #0A192F; font-weight: 600; border-bottom: 2px solid #C6A43F; padding-bottom: 4px;">View
          all services →</a>
      </div>
    </div>
  </section>

  <!-- Process Section -->
  <section>
    <div class="container">
      <span class="section-label">How We Operate</span>
      <h2 class="section-title">Your Journey, Step by Step</h2>
      <div class="process-timeline">
        @foreach ($process_steps as $step)
          <div class="step">
            <div class="step-circle">{{ $step['number'] }}</div>
            <h4>{{ $step['title'] }}</h4>
            <p>{{ $step['description'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials">
    <div class="container">
      <span class="section-label">Client Praise</span>
      <h2 class="section-title">What Our Students Say</h2>
      <div class="testimonial-grid">
        @foreach ($testimonials as $testimonial)
          <div class="testimonial-card">
            <i class="fas fa-quote-right"></i>
            <p>"{{ $testimonial['quote'] }}"</p>
            <img alt="{{ $testimonial['author'] }}" class="testimonial-img" src="{{ $testimonial['image'] }}">
            <div class="testimonial-author">{{ $testimonial['author'] }}</div>
            <div class="testimonial-detail">{{ $testimonial['position'] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section>
    <div class="container">
      <span class="section-label">Why Mimshach</span>
      <h2 class="section-title">The Difference We Make</h2>
      <div class="why-grid">
        @foreach ($benefits as $benefit)
          <div class="why-item">
            <div class="why-icon"><i class="{{ $benefit['icon'] }}"></i></div>
            <h4>{{ $benefit['title'] }}</h4>
            <p>{{ $benefit['description'] }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta">
    <div class="container">
      <h2>Start Your Global Education Journey Today</h2>
      <p>Let's turn your dream into a plan. Book your free consultation now.</p>
      <a class="btn-primary" href="contact.html">Contact Us</a>
    </div>
  </section>
</x-app-layout>
