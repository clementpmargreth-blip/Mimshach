@props([
    'filters' => [],
    'action' => url()->current(),
    'method' => 'GET',
    'contentId' => 'blogList',
    'paginationId' => 'paginationContainer',
    'classes' => ''
])

<div
  class="filter-bar @if ($classes) {{ $classes }} @endif relative z-10 w-full rounded-2xl bg-white p-3 shadow-lg dark:bg-gray-800">
  <form action="{{ $action }}" method="{{ $method }}">
    <div class="flex flex-wrap items-center justify-center gap-4">

      @foreach ($filters as $filter)
        @php
          $type = $filter['type'] ?? 'text';
          $name = $filter['name'] ?? null;

          // Ensure we have a consistent value for multi-value controls
          $value = request($name);
          $values = is_array($value) ? $value : (array) $value;
        @endphp

        @switch($type)
          {{-- SEARCH INPUT --}}
          @case('search')
            <div
              class="flex min-w-[220px] flex-1 items-center rounded-lg bg-white text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
              <input
                class="focus:border-accent focus:ring-accent/20 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="{{ $name }}" placeholder="{{ $filter['placeholder'] ?? '' }}" type="search"
                value="{{ $value }}">
            </div>
          @break

          {{-- TEXT INPUT --}}
          @case('text')
            <div
              class="flex min-w-[220px] flex-1 items-center rounded-lg bg-white text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="{{ $name }}" placeholder="{{ $filter['placeholder'] ?? '' }}"
                type="text" value="{{ $value }}">
            </div>
          @break

          {{-- DATE INPUT --}}
          @case('date')
            <div
              class="flex min-w-[220px] flex-1 items-center rounded-lg bg-white text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
              <input
                class="datepicker-input focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 bg-red-500 px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="{{ $name }}" placeholder="{{ $filter['placeholder'] ?? 'Select date' }}"
                type="text" value="{{ $value }}">
            </div>
          @break

          {{-- SELECT DROPDOWN --}}
          @case('select')
            <select
              class="focus:border-accent focus:ring-accent/20 w-48 rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
              name="{{ $name }}">
              @foreach ($filter['options'] as $option)
                @php
                  // For "All Cities" or similar, use empty value
                  $optionValue =
                      str_starts_with($option, 'All ') || $option === 'All Cities' ? '' : $option;
                @endphp
                <option @selected(old($name, request($name)) == $option) class='text-sm' value="{{ $optionValue }}">
                  {{ $option }}
                </option>
              @endforeach
            </select>
          @break

          {{-- RADIO BUTTONS --}}
          @case('radio')
            <div class="flex flex-col gap-2">
              <label>{{ $filter['label'] }}</label>

              <div class="radio-group">
                @foreach ($filter['options'] as $option)
                  <label class='text-gray-900 dark:text-white'>
                    <input @checked(old($name, request($name)) == ($option['value'] ?? $option))
                      class='focus:border-primary focus:ring-primary/20 w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white'
                      name="{{ $name }}" type="radio"
                      value="{{ $option['value'] ?? $option }}">
                    {{ $option['label'] ?? $option }}
                  </label>
                @endforeach
              </div>
            </div>
          @break

          {{-- CHECKBOX GROUP --}}
          @case('checkboxes')
            <div class="flex flex-wrap items-center gap-4">
              @foreach ($filter['options'] as $option)
                @php
                  $optValue = $option['value'] ?? $option;
                  $optLabel = $option['label'] ?? $option;
                @endphp

                <label
                  class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white">

                  <input @checked(in_array($optValue, old($name . '[]', (array) request($name)))) class="peer hidden" name="{{ $name }}[]"
                    type="checkbox" value="{{ $optValue }}">

                  <div
                    class="peer-checked:bg-accent peer-checked:border-primary flex h-4 w-4 items-center justify-center rounded border border-gray-400 bg-gray-700">

                    <svg class="hidden h-3 w-3 text-white peer-checked:block" fill="none"
                      stroke="currentColor" viewBox="0 0 24 24">
                      <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="3" />
                    </svg>

                  </div>

                  {{ $optLabel }}
                </label>
              @endforeach
            </div>
          @break

          {{-- FALLBACK (plain input) --}}

          @default
            <div
              class="flex min-w-[220px] flex-1 items-center rounded-lg bg-white text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
              <input
                class="focus:border-primary focus:ring-primary/20 w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                name="{{ $name }}" type="text" value="{{ $value }}">
            </div>
        @endswitch
      @endforeach

      <a class="border-accent hover:bg-accent hidden whitespace-nowrap rounded-full border-2 px-5 py-2 text-sm font-semibold text-white transition hover:text-white"
        href="{{ url()->current() }}" id="clearFilters" style="display:none;">
        Clear Filters
      </a>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.querySelector('.filter-bar form');
    const contentId = '{{ $contentId }}';
    const paginationId = '{{ $paginationId }}';
    const contentList = document.querySelector(`#${contentId}`);
    const paginationContainer = document.querySelector(`#${paginationId}`);

    if (!filterForm || !contentList || !paginationContainer) {
      console.warn(
        `Filter component: Missing required elements. contentId: ${contentId}, paginationId: ${paginationId}`
      );
      return;
    }

    // Cache DOM elements
    let activeRequest = null; // For cancelling in-flight requests
    let updateTimeout = null;

    // Get all filter fields with better organization
    const searchFields = Array.from(filterForm.querySelectorAll('input[type="search"]'));
    const textFields = Array.from(filterForm.querySelectorAll('input[type="text"]'));
    const dateFields = Array.from(filterForm.querySelectorAll('input[type="date"]'));
    const selectFields = Array.from(filterForm.querySelectorAll('select'));
    const checkboxFields = Array.from(filterForm.querySelectorAll('input[type="checkbox"]'));
    const radioFields = Array.from(filterForm.querySelectorAll('input[type="radio"]'));

    const allFields = [...searchFields, ...textFields, ...dateFields, ...selectFields, ...
      checkboxFields, ...radioFields
    ];

    // Debounce function
    function debounce(func, wait) {
      let timeout;
      return function executedFunction(...args) {
        const later = () => {
          clearTimeout(timeout);
          func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
      };
    }

    // Build query parameters
    const buildQuery = () => {
      const params = new URLSearchParams();
      const checkboxValues = {};

      allFields.forEach(field => {
        if (field.type === 'checkbox') {
          if (field.checked) {
            checkboxValues[field.name] = checkboxValues[field.name] || [];
            checkboxValues[field.name].push(field.value);
          }
          return;
        }

        if (field.type === 'radio') {
          if (field.checked) {
            params.set(field.name, field.value.trim());
          }
          return;
        }

        if (field.tagName === 'SELECT') {
          const value = field.value.trim();
          if (value && !value.startsWith('All ')) {
            params.set(field.name, value);
          }
          return;
        }

        if (field.type === 'search' || field.type === 'text' || field.type === 'date') {
          const value = field.value.trim();
          if (value) {
            params.set(field.name, value);
          }
        }
      });

      // Handle checkbox arrays
      Object.entries(checkboxValues).forEach(([name, values]) => {
        values.forEach(v => params.append(name, v));
      });

      return params;
    };

    // Update page with abort capability
    const updatePage = async (url) => {
      // Cancel any in-flight request
      if (activeRequest) {
        activeRequest.abort();
      }

      // Create abort controller
      const controller = new AbortController();
      activeRequest = controller;

      try {
        const response = await fetch(url, {
          method: 'GET',
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          signal: controller.signal
        });

        if (!response.ok) throw new Error('Request failed');

        const html = await response.text();
        const temp = document.createElement('div');
        temp.innerHTML = html;

        const newList = temp.querySelector(`#${contentId}`);
        const newPagination = temp.querySelector(`#${paginationId}`);

        // Only update if we have new content
        if (newList && newList.innerHTML !== contentList.innerHTML) {
          contentList.innerHTML = newList.innerHTML;
        }

        if (newPagination) {
          paginationContainer.innerHTML = newPagination.innerHTML;
          attachPaginationHandlers();
        } else if (paginationContainer.innerHTML !== '') {
          paginationContainer.innerHTML = '';
        }

        // Update URL without reload
        if (window.location.href !== url) {
          history.replaceState({}, '', url);
        }

      } catch (error) {
        if (error.name !== 'AbortError') {
          console.error('Update page error:', error);
        }
      } finally {
        if (activeRequest === controller) {
          activeRequest = null;
        }
      }
    };

    // Apply filters with debounce for real-time fields
    const applyFilters = () => {
      if (updateTimeout) {
        clearTimeout(updateTimeout);
      }

      updateTimeout = setTimeout(() => {
        const query = buildQuery();
        const queryString = query.toString();
        const newUrl = `${filterForm.action}${queryString ? '?' + queryString : ''}`;
        updatePage(newUrl);
        updateTimeout = null;
      }, 100); // Small delay to batch rapid changes
    };

    // Debounced version for search fields (longer delay for better UX)
    const debouncedApplyFilters = debounce(applyFilters, 500);

    // Update clear button visibility (optimized)
    const updateClearButton = () => {
      const clearBtn = document.getElementById('clearFilters');
      if (!clearBtn) return;

      // More efficient check - break early if any filter is active
      let isActive = false;
      for (const field of allFields) {
        if ((field.type === 'checkbox' || field.type === 'radio') && field.checked) {
          isActive = true;
          break;
        }
        if (field.tagName === 'SELECT') {
          const selectedOption = field.options[field.selectedIndex];
          if (selectedOption && selectedOption.value && !selectedOption.value.startsWith(
              'All ')) {
            isActive = true;
            break;
          }
        }
        if (
          (field.type === 'search' ||
            field.type === 'text' ||
            field.type === 'date') &&
          field.value.trim() !== ''
        ) {
          isActive = true;
          break;
        }
      }

      clearBtn.style.display = isActive ? 'inline-flex' : 'none';
    };

    // Set up event listeners efficiently
    const setupEventListeners = () => {
      // Search fields - real-time with debounce
      searchFields.forEach(field => {
        field.removeEventListener('input', handleSearchInput);
        field.removeEventListener('paste', handleSearchPaste);
        field.addEventListener('input', handleSearchInput);
        field.addEventListener('paste', handleSearchPaste);
      });

      // Text fields - real-time with debounce
      textFields.forEach(field => {
        field.removeEventListener('input', handleTextInput);
        field.addEventListener('input', handleTextInput);
      });

      // Date fields - change only
      dateFields.forEach(field => {
        field.removeEventListener('change', handleFilterChange);
        field.addEventListener('change', handleFilterChange);
      });

      // Select fields
      selectFields.forEach(field => {
        field.removeEventListener('change', handleFilterChange);
        field.addEventListener('change', handleFilterChange);
      });

      // Checkbox fields
      checkboxFields.forEach(field => {
        field.removeEventListener('change', handleFilterChange);
        field.addEventListener('change', handleFilterChange);
      });

      // Radio fields
      radioFields.forEach(field => {
        field.removeEventListener('change', handleFilterChange);
        field.addEventListener('change', handleFilterChange);
      });
    };

    // Event handlers
    const handleSearchInput = (e) => {
      updateClearButton();
      debouncedApplyFilters();
    };

    const handleSearchPaste = (e) => {
      setTimeout(() => {
        updateClearButton();
        debouncedApplyFilters();
      }, 10);
    };

    const handleTextInput = (e) => {
      updateClearButton();
      debouncedApplyFilters();
    };

    const handleFilterChange = (e) => {
      updateClearButton();
      applyFilters(); // Immediate for non-search fields
    };

    // Pagination handlers with better event delegation
    const attachPaginationHandlers = () => {
      if (!paginationContainer) return;

      // Use event delegation instead of attaching to each link
      paginationContainer.removeEventListener('click', handlePaginationClick);
      paginationContainer.addEventListener('click', handlePaginationClick);
    };

    const handlePaginationClick = (event) => {
      const link = event.target.closest('a');
      if (!link) return;

      event.preventDefault();

      let targetUrl = link.href;
      const rewritten = new URL(targetUrl, window.location.origin);
      const filterParams = buildQuery();

      filterParams.forEach((value, key) => {
        rewritten.searchParams.set(key, value);
      });

      targetUrl = rewritten.toString();
      updatePage(targetUrl);
    };

    // Clear filters with proper reset
    const setupClearButton = () => {
      const clearBtn = document.getElementById('clearFilters');
      if (!clearBtn) return;

      // Remove existing listener
      const newClearBtn = clearBtn.cloneNode(true);
      clearBtn.parentNode.replaceChild(newClearBtn, clearBtn);

      newClearBtn.addEventListener('click', (event) => {
        event.preventDefault();

        // Reset all form fields
        allFields.forEach(field => {
          if (field.tagName === 'SELECT') {
            const emptyOption = Array.from(field.options).find(opt => opt.value ===
              '');
            if (emptyOption) {
              field.value = emptyOption.value;
            } else {
              field.selectedIndex = 0;
            }
          } else if (field.type === 'checkbox' || field.type === 'radio') {
            field.checked = false;
          } else if (field.type === 'search' || field.type === 'text' || field
            .type === 'date') {
            field.value = '';
          }
        });

        // Manually trigger update to ensure all filters are cleared
        updateClearButton();

        // Clear any pending debounced calls
        if (updateTimeout) {
          clearTimeout(updateTimeout);
          updateTimeout = null;
        }

        // Fetch the page without filters
        updatePage(filterForm.action);
      });
    };

    // Initialize fields from URL
    const initializeFieldsFromUrl = () => {
      const urlParams = new URLSearchParams(window.location.search);

      allFields.forEach(field => {
        if (field.type === 'checkbox') {
          const paramValues = urlParams.getAll(field.name);
          field.checked = paramValues.includes(field.value);
        } else if (field.type === 'radio') {
          const urlValue = urlParams.get(field.name);
          if (urlValue === field.value) {
            field.checked = true;
          }
        } else if (field.tagName === 'SELECT') {
          const urlValue = urlParams.get(field.name);
          if (urlValue && urlValue !== '') {
            const optionExists = Array.from(field.options).some(opt => opt.value ===
              urlValue);
            if (optionExists) {
              field.value = urlValue;
            }
          }
        } else if (field.type === 'search' || field.type === 'text' || field.type ===
          'date') {
          const urlValue = urlParams.get(field.name);
          if (urlValue && urlValue !== '') {
            field.value = urlValue;
          }
        }
      });
    };

    // Initialize everything
    initializeFieldsFromUrl();
    setupEventListeners();
    setupClearButton();
    updateClearButton(); // Show clear button if URL has filters
    attachPaginationHandlers();
  });
</script>
