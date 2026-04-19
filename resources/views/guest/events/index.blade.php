<x-app-layout pageTitle="Events | Mimshach">
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

      /* events list */
      .events-list {
        margin: 60px 0;
      }

      .event-item {
        position: relative;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 30px;
        height: 320px;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: flex-end;
        color: white;
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
        text-decoration: none;
      }

      .event-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
      }

      .event-overlay {
        width: 100%;
        padding: 40px;
        background: linear-gradient(to top, rgba(10, 25, 47, 0.95) 0%, rgba(10, 25, 47, 0.4) 70%, transparent 100%);
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-end;
      }

      .event-info {
        flex: 2;
        min-width: 280px;
      }

      .event-title {
        font-size: 28px;
        margin-bottom: 8px;
      }

      .event-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        margin-bottom: 12px;
        font-size: 16px;
        color: #C6A43F;
        font-weight: 500;
      }

      .event-meta i {
        margin-right: 6px;
        color: #C6A43F;
      }

      .event-description {
        font-size: 16px;
        opacity: 0.9;
        max-width: 600px;
      }

      @media (max-width: 768px) {
        .event-overlay {
          flex-direction: column;
          align-items: flex-start;
          gap: 20px;
        }

        .event-register {
          margin-left: 0;
          width: 100%;
        }

        .btn-register {
          width: 100%;
          text-align: center;
        }

        .filter-bar {
          flex-direction: column;
          border-radius: 30px;
        }

        .footer-grid {
          grid-template-columns: 1fr;
        }
      }
    </style>
  </x-slot:styles>

  <x-page-header subtitle="Join webinars, university fairs, and networking sessions around the world"
    title="Upcoming Events" />

  <div class="container">
    <x-filter-bar :$filters contentId="eventsList" paginationId="paginationContainer" classes='-mt-10' />

    <div class="events-list" id="eventsList">
      @if ($events->isEmpty())
        <div class="no-results"
          style="padding: 40px; text-align: center; background: white; border-radius: 30px; box-shadow: 0 8px 20px -5px rgba(0,0,0,.05); margin: 30px 0;">
          <h3>No events found</h3>
          <p>Please adjust your filters to see more results.</p>
        </div>
      @else
        @foreach ($events as $event)
          <x-event.event-card :$event />
        @endforeach
      @endif
    </div>
    <div id="paginationContainer">
      @if ($events->hasPages())
        {{ $events->links('vendor.pagination.custom') }}
      @endif
    </div>
</x-app-layout>
