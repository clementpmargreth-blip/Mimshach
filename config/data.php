<?php

return [
    'links' => [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'Admissions', 'route' => 'admissions.index'],
        ['label' => 'Student Funding', 'route' => 'fundings.index'],
        ['label' => 'Universities', 'route' => 'universities.index'],
        ['label' => 'Events', 'route' => 'events.index'],
        ['label' => 'Blog', 'route' => 'blogs.index'],
        ['label' => 'Contact', 'route' => 'contact.index'],
        ['label' => 'Start Here', 'route' => 'consultation.index', 'style' => 'nav-cta'],
    ],
    'partners' => [
        'University of Melbourne',
        'University of Toronto',
        'King\'s College London',
        'Boston University',
        'National University of Singapore',
    ],
    'stats' => [
        [
            'number' => '10+',
            'label' => 'Years',
        ],
        [
            'number' => '5000+',
            'label' => 'Students Placed',
        ],
        [
            'number' => '30+',
            'label' => 'Countries',
        ],
    ],
    'services' => [
        [
            'icon' => 'fas fa-globe',
            'title' => 'International Education Support',
            'description' => 'End-to-end guidance from university selection to visa counselling.',
            'link' => 'admissions.index',
            'link_text' => 'Learn More',
        ],
        [
            'icon' => 'fas fa-plane',
            'title' => 'Travel Assistance Services',
            'description' => 'Safe and affordable travel options for students and professionals.',
            'link' => 'contact.index',
            'link_text' => 'Learn More',
        ],
        [
            'icon' => 'fas fa-hand-holding-heart',
            'title' => 'Pre-Arrival Support',
            'description' => 'Logistical help and local insights for a smooth transition.',
            'link' => 'consultation.index',
            'link_text' => 'Learn More',
        ],
    ],
    'process_steps' => [
        [
            'number' => '01',
            'title' => 'Consultation',
            'description' => 'We listen to your aspirations and map out a personalized roadmap.',
        ],
        [
            'number' => '02',
            'title' => 'Placement Assistance',
            'description' => 'We match you with institutions and handle all applications.',
        ],
        [
            'number' => '03',
            'title' => 'Ongoing Support',
            'description' => 'From pre‑departure to alumni networking, we\'re always here.',
        ],
    ],
    'testimonials' => [
        [
            'quote' => 'Mimshach Education Centre guided me through every step of my journey abroad. Their team was incredibly supportive and dedicated to helping me succeed.',
            'author' => 'Sarah Johnson',
            'position' => 'MSc, University of Manchester',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
        ],
        [
            'quote' => 'The support I received from MEC was invaluable. They helped me secure a scholarship and navigate the complexities of studying internationally.',
            'author' => 'David Mwale',
            'position' => 'MBA, University of Toronto',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=687&q=80',
        ],
    ],
    'benefits' => [
        [
            'icon' => 'fas fa-user-check',
            'title' => 'Personalized Matching',
            'description' => 'We don\'t believe in one-size-fits-all.',
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => '95% Visa Success',
            'description' => 'Our experts know the process inside out.',
        ],
        [
            'icon' => 'fas fa-trophy',
            'title' => '$2M+ Scholarships',
            'description' => 'We\'ve helped secure millions in aid.',
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Global Alumni Network',
            'description' => 'Join 5000+ alumni worldwide.',
        ],
    ],
];
