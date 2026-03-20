@php
  $filters = [
      [
          'type' => 'search',
          'name' => 'search',
          'placeholder' => 'Search blog posts...'
      ],
      [
          'type' => 'checkboxes',
          'name' => 'category',
          'options' => [
              'All',
              'Study Abroad',
              'Scholarships',
              'Visa Guide',
              'Student Life',
              'Career Advice',
              'University Reviews'
          ]
      ]
  ];

  $blogs = [
      [
          'title' => 'Complete Guide to UK Student Visas 2026',
          'excerpt' =>
              'Everything you need to know about the UK student visa application process, requirements, and timeline.',
          'content' => 'Full article content would go here...',
          'category' => 'Visa Guide',
          'author' => 'Sarah Johnson',
          'date' => 'March 15, 2026',
          'read_time' => '8 min read',
          'image' =>
              'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'Top 10 Scholarships for African Students in 2026',
          'excerpt' =>
              'Discover fully-funded scholarships available for African students to study in Europe, USA, and Canada.',
          'content' => 'Full article content would go here...',
          'category' => 'Scholarships',
          'author' => 'Michael Okafor',
          'date' => 'March 10, 2026',
          'read_time' => '10 min read',
          'image' =>
              'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'Student Life in Germany: What to Expect',
          'excerpt' =>
              'A comprehensive look at living costs, accommodation, culture, and student experiences in German universities.',
          'content' => 'Full article content would go here...',
          'category' => 'Student Life',
          'author' => 'Anna Schmidt',
          'date' => 'March 5, 2026',
          'read_time' => '6 min read',
          'image' =>
              'https://images.unsplash.com/photo-1555888997-1e4b3e3b0b0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'How to Write a Winning Statement of Purpose',
          'excerpt' =>
              'Expert tips and templates for crafting an SOP that stands out to admissions committees.',
          'content' => 'Full article content would go here...',
          'category' => 'Study Abroad',
          'author' => 'David Chen',
          'date' => 'February 28, 2026',
          'read_time' => '7 min read',
          'image' =>
              'https://images.unsplash.com/photo-1455390582262-044cdead277a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'Top Engineering Universities in Canada',
          'excerpt' =>
              'Ranking and review of the best Canadian universities for engineering and technology programs.',
          'content' => 'Full article content would go here...',
          'category' => 'University Reviews',
          'author' => 'Priya Patel',
          'date' => 'February 20, 2026',
          'read_time' => '9 min read',
          'image' =>
              'https://images.unsplash.com/photo-1517486808906-6ca8b3f8e1c1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'Part-Time Work Rules for International Students',
          'excerpt' =>
              'Understanding work hour limits, visa conditions, and job opportunities in major study destinations.',
          'content' => 'Full article content would go here...',
          'category' => 'Visa Guide',
          'author' => 'James Wilson',
          'date' => 'February 15, 2026',
          'read_time' => '5 min read',
          'image' =>
              'https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&auto=format&fit=crop&w=1169&q=80',
          'url' => '#'
      ],
      [
          'title' => 'MBA vs Masters: Which One is Right for You?',
          'excerpt' =>
              'Compare costs, career outcomes, and program structures to make an informed decision.',
          'content' => 'Full article content would go here...',
          'category' => 'Career Advice',
          'author' => 'Robert Taylor',
          'date' => 'February 10, 2026',
          'read_time' => '8 min read',
          'image' =>
              'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'Australian University Application Timeline',
          'excerpt' =>
              'Step-by-step guide to applying for Australian universities for the 2026-2027 academic year.',
          'content' => 'Full article content would go here...',
          'category' => 'Study Abroad',
          'author' => 'Emma Watson',
          'date' => 'February 5, 2026',
          'read_time' => '6 min read',
          'image' =>
              'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ],
      [
          'title' => 'Scholarship Interview Tips and Questions',
          'excerpt' =>
              'Prepare for scholarship interviews with common questions and proven strategies.',
          'content' => 'Full article content would go here...',
          'category' => 'Scholarships',
          'author' => 'Grace Kim',
          'date' => 'January 28, 2026',
          'read_time' => '4 min read',
          'image' =>
              'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
          'url' => '#'
      ]
  ];
@endphp

<x-app-layout pageTitle="Blog & Resources | Mimshach">
  <x-slot:styles>
    <style>
      /* Blog specific styles */
      .blog-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin: 60px 0;
      }

      /* Category filter pills */
      .category-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        margin: 40px 0 20px;
      }

      .category-pill {
        background: white;
        border: 1px solid #e0e0e0;
        color: #0A192F;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 500;
        cursor: pointer;
        transition: 0.2s;
      }

      .category-pill:hover,
      .category-pill.active {
        background: #C6A43F;
        border-color: #C6A43F;
        color: #0A192F;
      }

      .category-pill.disabled {
        opacity: 0.6;
        cursor: not-allowed;
      }

      @media (max-width: 992px) {
        .blog-grid {
          grid-template-columns: repeat(2, 1fr);
        }
      }

      @media (max-width: 768px) {
        .blog-grid {
          grid-template-columns: 1fr;
        }

        .category-filters {
          justify-content: flex-start;
          overflow-x: auto;
          padding-bottom: 10px;
        }
      }
    </style>
  </x-slot:styles>

  <x-page-header subtitle="Expert advice, guides, and resources for your study abroad journey"
    title="Blog & Resources" />

  <div class="container">
    <x-filter-bar :$filters />

    <div class="blog-grid">
      @foreach ($blogs as $blog)
        <x-blog.blog-card :$blog />
      @endforeach
    </div>
  </div>
</x-app-layout>
