<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <title>Admin Login - {{ config('app.name', 'Mimshach') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      /* Additional styles for loading state and button transitions */
      .login-btn {
        transition: all 0.2s ease;
      }

      .login-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
      }

      .login-btn.loading {
        position: relative;
        pointer-events: none;
      }

      .login-btn.loading .btn-text {
        visibility: hidden;
      }

      .login-btn.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
      }

      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }

      /* Smooth transitions for form inputs */
      input:disabled {
        opacity: 0.7;
        cursor: not-allowed;
      }
    </style>
  </head>

  <body class="bg-primary font-sans antialiased">
    <div class="relative flex min-h-screen items-center justify-center px-4 py-12">
      <!-- Background Decorative Elements -->
      <div class="absolute inset-0 overflow-hidden">
        <div class="bg-accent -right-30 -top-30 absolute h-80 w-80 rounded-full opacity-10 blur-3xl">
        </div>
        <div
          class="bg-accent -bottom-30 -left-30 absolute h-80 w-80 rounded-full opacity-10 blur-3xl">
        </div>
      </div>

      <!-- Login Container -->
      <div class="relative w-full max-w-md">
        <!-- Logo/Brand Section -->
        <div class="mb-8 text-center">
          <div
            class="bg-accent mb-4 inline-flex h-20 w-20 items-center justify-center rounded-full">
            <svg class="text-primary h-10 w-10" fill="none" stroke="currentColor"
              viewBox="0 0 24 24">
              <path
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
          </div>
          <h1 class="mb-2 text-3xl font-bold text-white">Mimshach Admin</h1>
          <p class="text-white/60">Study Abroad Consultancy Portal</p>
        </div>

        <!-- Login Card -->
        <div class="rounded-2xl border border-white/10 bg-white/5 p-8 shadow-2xl backdrop-blur-sm">
          <h2 class="mb-6 text-center text-2xl font-semibold text-white">Admin Access</h2>

          <!-- Error Messages -->
          @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-500/20 bg-red-500/10 p-4">
              <div class="flex items-center">
                <svg class="mr-2 h-5 w-5 text-red-400" fill="none" stroke="currentColor"
                  viewBox="0 0 24 24">
                  <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span class="text-sm text-red-400">{{ $errors->first() }}</span>
              </div>
            </div>
          @endif

          <!-- Login Form -->
          <form action="{{ route('admin.login') }}" class="space-y-6"
            enctype="application/x-www-form-urlencoded" id="loginForm" method="POST">
            @csrf

            <!-- Email Field -->
            <div>
              <label class="mb-2 block text-sm font-medium text-white/80" for="email">Email
                Address</label>
              <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-white/40" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                      d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                  </svg>
                </div>
                <input autofocus
                  class="focus:border-accent focus:ring-accent w-full rounded-lg border border-white/20 bg-white/10 py-3 pl-10 pr-4 text-white placeholder-white/40 transition focus:outline-none focus:ring-1"
                  id="email" name="email" placeholder="admin@example.com" required
                  type="email" value="{{ old('email') }}">
              </div>
            </div>

            <!-- Password Field -->
            <div>
              <label class="mb-2 block text-sm font-medium text-white/80"
                for="password">Password</label>
              <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-white/40" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                  </svg>
                </div>
                <input
                  class="focus:border-accent focus:ring-accent w-full rounded-lg border border-white/20 bg-white/10 py-3 pl-10 pr-4 text-white placeholder-white/40 transition focus:outline-none focus:ring-1"
                  id="password" name="password" placeholder="••••••••" required type="password">
              </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
              <label class="flex items-center">
                <input
                  class="focus:ring-accent text-accent h-4 w-4 rounded border-white/20 bg-white/10"
                  name="remember" type="checkbox">
                <span class="ml-2 text-sm text-white/60">Remember me</span>
              </label>
              <a class="text-accent hover:text-accent/80 text-sm transition" href="#">Forgot
                password?</a>
            </div>

            <!-- Submit Button -->
            <button
              class="login-btn bg-accent text-primary w-full transform cursor-pointer rounded-lg py-3 font-semibold transition duration-200 hover:scale-[1.02] hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100 disabled:hover:opacity-50"
              disabled id="submitBtn" type="submit">
              <span class="btn-text">Sign In</span>
            </button>
          </form>

          <!-- Divider -->
          <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-white/10"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="bg-transparent px-4 text-white/40">Secure Access Only</span>
            </div>
          </div>

          <!-- Security Notice -->
          <div class="text-center">
            <div class="flex items-center justify-center space-x-2 text-xs text-white/40">
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              </svg>
              <span>SSL Encrypted Connection</span>
              <span>•</span>
              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
              </svg>
              <span>Secure Admin Portal</span>
            </div>
          </div>
        </div>

        <!-- Back to Website Link -->
        <div class="mt-6 text-center">
          <a class="inline-flex items-center text-sm text-white/40 transition hover:text-white/60"
            href="{{ route('home') }}">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"></path>
            </svg>
            Back to Website
          </a>
        </div>
      </div>
    </div>
    <script>
      (function() {
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        let isSubmitting = false;

        function validateForm() {
          const email = emailInput ? emailInput.value.trim() : '';
          const password = passwordInput ? passwordInput.value : '';
          const isValid = email !== '' && password !== '';
          submitBtn.disabled = !isValid;
          return isValid;
        }

        // Add event listeners
        if (emailInput) {
          emailInput.addEventListener('input', validateForm);
          emailInput.addEventListener('change', validateForm);
        }

        if (passwordInput) {
          passwordInput.addEventListener('input', validateForm);
          passwordInput.addEventListener('change', validateForm);
        }

        // Handle form submission
        if (form) {
          form.addEventListener('submit', function(event) {
            // Prevent double submission
            if (isSubmitting) {
              event.preventDefault();
              return false;
            }

            // Validate one more time
            const email = emailInput ? emailInput.value.trim() : '';
            const password = passwordInput ? passwordInput.value : '';

            if (email === '' || password === '') {
              event.preventDefault();
              submitBtn.disabled = true;
              return false;
            }

            // Mark as submitting
            isSubmitting = true;

            // ONLY disable the button - NOT the input fields!
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');

            // IMPORTANT: Do NOT disable emailInput or passwordInput
            // Disabling them prevents their values from being sent to the server

            // Allow the form to submit naturally
            // The form will submit with all input values intact
          });
        }

        // Handle browser autofill
        setTimeout(validateForm, 100);
        setTimeout(validateForm, 500);

        validateForm();
      })();
    </script>
  </body>

</html>
