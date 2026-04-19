@php
  // Filters and universities are provided by the controller
@endphp

<x-app-layout pageTitle="Partner Universities | Mimshach">
  <x-slot:styles>
    <style>
      /* pagination */
      .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 60px 0;
      }

      .page-item {
        list-style: none;
      }

      .page-link {
        display: block;
        padding: 10px 18px;
        background: white;
        border-radius: 50px;
        color: #0A192F;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
        border: 1px solid transparent;
      }

      .page-link:hover,
      .page-link.active {
        background: #C6A43F;
        color: #0A192F;
        border-color: #C6A43F;
      }

      /* universities grid */
      .uni-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin: 60px 0;
      }

      .uni-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
        display: flex;
        flex-direction: column;
      }

      .uni-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 30px -10px rgba(198, 164, 63, 0.15);
      }

      .uni-thumbnail {
        height: 180px;
        background-size: cover;
        background-position: center;
      }

      .uni-content {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
      }

      .uni-title {
        font-size: 22px;
        margin-bottom: 8px;
      }

      .uni-title a {
        text-decoration: none;
        color: #0A192F;
      }

      .uni-title a:hover {
        color: #C6A43F;
      }

      .uni-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
        color: #C6A43F;
        font-size: 14px;
        font-weight: 500;
      }

      .uni-meta i {
        margin-right: 4px;
      }

      .uni-description {
        color: #4a5568;
        margin-bottom: 20px;
        flex: 1;
      }

      .funding-tags {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
      }

      .funding-tag {
        background: #F0EEE9;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 500;
        color: #0A192F;
        display: inline-flex;
        align-items: center;
        gap: 6px;
      }

      .funding-tag i {
        color: #C6A43F;
      }

      .uni-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eee;
        padding-top: 16px;
      }

      .explore-link {
        color: #C6A43F;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
      }

      .explore-link i {
        transition: 0.2s;
      }

      .explore-link:hover i {
        transform: translateX(5px);
      }

      @media (max-width: 992px) {
        .uni-grid {
          grid-template-columns: repeat(2, 1fr);
        }
      }

      @media (max-width: 768px) {
        .uni-grid {
          grid-template-columns: 1fr;
        }

        .filter-row {
          flex-direction: column;
          align-items: stretch;
        }

        .filter-checkboxes {
          justify-content: center;
        }

        .footer-grid {
          grid-template-columns: 1fr;
        }
      }
    </style>
  </x-slot:styles>

  <x-page-header
    subtitle="Explore top institutions around the world offering programs for international students"
    title="Partner Universities" />

  <div class="container">
    <x-filter-bar :$filters contentId="uniGrid" paginationId="paginationContainer" classes='-mt-10' />

    <div class="uni-grid" id="uniGrid">
      @if ($universities->isEmpty())
        <div class="no-results"
          style="padding: 40px; text-align: center; background: white; border-radius: 30px; box-shadow: 0 8px 20px -5px rgba(0,0,0,.05); margin: 30px 0;">
          <h3>No universities found</h3>
          <p>Please adjust your filters to see more results.</p>
        </div>
      @else
        @foreach ($universities as $university)
          <x-university.university-card :$university />
        @endforeach
      @endif
    </div>

    <div id="paginationContainer">
      @if ($universities->hasPages())
        {{ $universities->links('vendor.pagination.custom') }}
      @endif
    </div>
  </div>
</x-app-layout>
