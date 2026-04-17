@props([
    'filters' => [],
    'action' => url()->current(),
    'method' => 'GET',
    'contentId' => 'blogList',
    'paginationId' => 'paginationContainer'
])

{{-- <style>
  /* filter bar */
  .filter-bar {
    background: white;
    border-radius: 30px;
    padding: 25px 30px;
    margin-top: -40px;
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 10;
  }

  .filter-row {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
  }

  .search-box {
    flex: 2;
    min-width: 240px;
    display: flex;
    align-items: center;
    background: #F9F7F5;
    border-radius: 50px;
    padding: 0 20px;
    border: 1px solid #e0e0e0;
  }

  .search-box i {
    color: #C6A43F;
  }

  .search-box input {
    width: 100%;
    padding: 14px 10px;
    border: none;
    background: transparent;
    font-size: 16px;
    outline: none;
  }

  .filter-checkboxes {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center;
    flex: 3;
  }

  .filter-checkboxes label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    cursor: pointer;
  }

  .filter-checkboxes input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #C6A43F;
  }

  .filter-select {
    flex: 1;
    min-width: 150px;
    padding: 12px 20px;
    border: 1px solid #e0e0e0;
    border-radius: 50px;
    font-family: 'Inter', sans-serif;
    background: #F9F7F5;
    color: #0A192F;
    cursor: pointer;
    font-size: 15px;
  }

  .filter-select:focus {
    outline: none;
    border-color: #C6A43F;
    box-shadow: 0 0 0 2px rgba(198, 164, 63, 0.2);
  }

  .clear-btn {
    background: transparent;
    border: 2px solid #C6A43F;
    color: #0A192F;
    padding: 12px 28px;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    white-space: nowrap;
    text-decoration: none;
  }

  .clear-btn:hover {
    background: #C6A43F;
    color: white;
  }
</style> --}}

<div class="filter-bar relative z-10 -mt-10 rounded-3xl bg-white p-6 shadow-lg">
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
              class="flex min-w-[220px] flex-1 items-center rounded-full border border-gray-200 bg-gray-50 px-4">
              <input class="w-full bg-transparent py-3 text-sm outline-none" name="{{ $name }}"
                placeholder="{{ $filter['placeholder'] ?? '' }}" type="text"
                value="{{ $value }}">
            </div>
          @break

          {{-- TEXT INPUT --}}
          @case('text')
            <div class="search-box">
              <input class="w-full bg-transparent py-3 text-sm outline-none" name="{{ $name }}"
                placeholder="{{ $filter['placeholder'] ?? '' }}" type="text"
                value="{{ $value }}">
            </div>
          @break

          {{-- DATE INPUT --}}
          @case('date')
            <div class="search-box">
              <input class="w-full bg-transparent py-3 text-sm outline-none" name="{{ $name }}"
                type="date" value="{{ $value }}">
            </div>
          @break

          {{-- SELECT DROPDOWN --}}
          @case('select')
            <select
              class="min-w-[150px] rounded-full border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-[var(--color-primary)] outline-none focus:ring-2 focus:ring-[var(--color-accent)]"
              name="{{ $name }}">
              @foreach ($filter['options'] as $option)
                <option @selected(old($name, request($name)) == $option) value="{{ $option }}">
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
                  <label>
                    <input @checked(old($name, request($name)) == ($option['value'] ?? $option)) name="{{ $name }}" type="radio"
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

                <label class="flex items-center gap-2 text-sm font-medium">
                  <input @checked(in_array($optValue, old($name . '[]', (array) request($name)))) name="{{ $name }}[]" type="checkbox"
                    value="{{ $optValue }}" class="h-4 w-4 accent-[var(--color-accent)]">
                  {{ $optLabel }}
                </label>
              @endforeach
            </div>
          @break

          {{-- FALLBACK (plain input) --}}

          @default
            <div class="flex min-w-[220px] flex-1 items-center rounded-full border border-gray-200 bg-gray-50 px-4">
              <input name="{{ $name }}" type="text" value="{{ $value }}" class="w-full bg-transparent py-3 text-sm outline-none">
            </div>
        @endswitch
      @endforeach

      <a class="hidden whitespace-nowrap rounded-full border-2 border-[var(--color-accent)] px-5 py-2 text-sm font-semibold text-[var(--color-primary)] transition hover:bg-[var(--color-accent)] hover:text-white" href="{{ url()->current() }}" id="clearFilters" style="display:none;">
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
