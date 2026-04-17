@if ($paginator->hasPages())
  <nav class="flex justify-center mt-10">
    <ul class="flex items-center gap-2">

      {{-- Previous --}}
      @if ($paginator->onFirstPage())
        <li>
          <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400">
            ←
          </span>
        </li>
      @else
        <li>
          <a href="{{ $paginator->previousPageUrl() }}"
             rel="prev"
             class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-[var(--color-primary)] shadow-sm transition hover:bg-[var(--color-accent)] hover:text-white">
            ←
          </a>
        </li>
      @endif


      {{-- Pages --}}
      @foreach ($elements as $element)

        {{-- Dots --}}
        @if (is_string($element))
          <li>
            <span class="flex h-10 w-10 items-center justify-center text-gray-400">
              {{ $element }}
            </span>
          </li>
        @endif


        {{-- Page Numbers --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)

            @if ($page == $paginator->currentPage())
              <li>
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[var(--color-accent)] font-semibold text-[var(--color-primary)] shadow">
                  {{ $page }}
                </span>
              </li>
            @else
              <li>
                <a href="{{ $url }}"
                   class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-[var(--color-primary)] shadow-sm transition hover:bg-[var(--color-accent)] hover:text-white">
                  {{ $page }}
                </a>
              </li>
            @endif

          @endforeach
        @endif

      @endforeach


      {{-- Next --}}
      @if ($paginator->hasMorePages())
        <li>
          <a href="{{ $paginator->nextPageUrl() }}"
             rel="next"
             class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-[var(--color-primary)] shadow-sm transition hover:bg-[var(--color-accent)] hover:text-white">
            →
          </a>
        </li>
      @else
        <li>
          <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-400">
            →
          </span>
        </li>
      @endif

    </ul>
  </nav>
@endif