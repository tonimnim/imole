@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'type' => 'website',
    'url' => null,
    'keywords' => null,
    'author' => null,
    'publishedTime' => null,
    'modifiedTime' => null,
    'noindex' => false,
    'course' => null,
    'category' => null,
    'breadcrumbs' => null,
    'courseList' => null,
    'faq' => null,
    'pageType' => null,
])

@php
    $siteName = config('app.name', 'Imole Africa');
    $siteUrl = config('app.url', 'https://imoleafrika.com');
    $defaultDescription = "Africa's premier learning platform offering world-class courses in agriculture, technology, business, and vocational skills. Join 10,000+ students transforming their futures.";
    $defaultImage = asset('imolelogo.jpeg');

    // Build title
    $pageTitle = $title ? "$title | $siteName" : "$siteName - Transform Your Future with Quality Education";

    // Get description
    $metaDescription = $description ?? $defaultDescription;

    // Get canonical URL
    $canonicalUrl = $url ?? request()->url();

    // Get OG image
    $ogImage = $image ?? $defaultImage;

    // Default keywords
    $defaultKeywords = 'online courses, e-learning, Africa education, professional development, skills training, agriculture courses, technology courses, business courses, vocational training, African learning platform';
    $metaKeywords = $keywords ?? $defaultKeywords;
@endphp

{{-- Primary Meta Tags --}}
<title>{{ $pageTitle }}</title>
<meta name="title" content="{{ $pageTitle }}">
<meta name="description" content="{{ Str::limit($metaDescription, 160) }}">
<meta name="keywords" content="{{ $metaKeywords }}">
@if($author)
<meta name="author" content="{{ $author }}">
@endif

{{-- Robots --}}
@if($noindex)
<meta name="robots" content="noindex, nofollow">
@else
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
@endif

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Favicon, Apple Touch Icon & PWA --}}
<link rel="icon" type="image/jpeg" href="{{ asset('imolelogo.jpeg') }}">
<link rel="apple-touch-icon" href="{{ asset('imolelogo.jpeg') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#15803d">

{{-- Hreflang --}}
<link rel="alternate" hreflang="en" href="{{ $canonicalUrl }}">
<link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ Str::limit($metaDescription, 300) }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:locale" content="en_US">
@if($publishedTime)
<meta property="article:published_time" content="{{ $publishedTime }}">
@endif
@if($modifiedTime)
<meta property="article:modified_time" content="{{ $modifiedTime }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $canonicalUrl }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ Str::limit($metaDescription, 200) }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- JSON-LD Structured Data --}}
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@graph": [
        {{-- EducationalOrganization Schema --}}
        {
            "@type": "EducationalOrganization",
            "@id": "{{ $siteUrl }}/#organization",
            "name": "{{ $siteName }}",
            "url": "{{ $siteUrl }}",
            "description": "{{ $defaultDescription }}",
            "logo": {
                "@type": "ImageObject",
                "@id": "{{ $siteUrl }}/#logo",
                "url": "{{ asset('imolelogo.jpeg') }}",
                "contentUrl": "{{ asset('imolelogo.jpeg') }}",
                "caption": "{{ $siteName }}",
                "inLanguage": "en-US",
                "width": "512",
                "height": "512"
            },
            "image": { "@id": "{{ $siteUrl }}/#logo" },
            "sameAs": [
                "https://facebook.com/imoleafrika",
                "https://twitter.com/imoleafrika",
                "https://linkedin.com/company/imoleafrika",
                "https://instagram.com/imoleafrika"
            ],
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+254 789 378100",
                "contactType": "customer service",
                "areaServed": "Africa",
                "availableLanguage": ["English", "Swahili", "French"]
            },
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Nairobi",
                "addressCountry": "KE"
            }
        },
        {{-- Website Schema --}}
        {
            "@type": "WebSite",
            "@id": "{{ $siteUrl }}/#website",
            "url": "{{ $siteUrl }}",
            "name": "{{ $siteName }}",
            "description": "{{ $defaultDescription }}",
            "publisher": { "@id": "{{ $siteUrl }}/#organization" },
            "inLanguage": "en-US",
            "potentialAction": {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "{{ $siteUrl }}/courses?search={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            }
        }
        @if($course)
        ,
        {{-- Course Schema --}}
        {
            "@type": "Course",
            "@id": "{{ $canonicalUrl }}/#course",
            "name": "{{ $course->title }}",
            "description": "{{ Str::limit($course->description ?? $course->subtitle, 500) }}",
            "url": "{{ $canonicalUrl }}",
            "provider": { "@id": "{{ $siteUrl }}/#organization" },
            @if($course->instructor)
            "instructor": {
                "@type": "Person",
                "name": "{{ $course->instructor->name }}",
                "url": "{{ $siteUrl }}",
                "worksFor": { "@id": "{{ $siteUrl }}/#organization" }
            },
            @endif
            @if($course->thumbnail)
            "image": "{{ asset('storage/' . $course->thumbnail) }}",
            @endif
            @if($course->category)
            "about": {
                "@type": "Thing",
                "name": "{{ $course->category->name }}"
            },
            "courseCode": "{{ $course->category->slug }}-{{ $course->id }}",
            @endif
            "educationalLevel": "{{ ucfirst($course->level ?? 'beginner') }}",
            @if($course->language)
            "inLanguage": "{{ $course->language }}",
            @endif
            @if($course->has_certificate)
            "educationalCredentialAwarded": "Certificate of Completion",
            @endif
            "hasCourseInstance": {
                "@type": "CourseInstance",
                "courseMode": "online",
                "courseWorkload": "PT{{ $course->duration_minutes ?? 60 }}M"
            },
            @if($course->average_rating > 0)
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "{{ number_format($course->average_rating, 1) }}",
                "bestRating": "5",
                "worstRating": "1",
                "ratingCount": "{{ $course->reviews_count ?? 1 }}"
            },
            @endif
            @if($course->relationLoaded('reviews') && $course->reviews->count() > 0)
            "review": [
                @foreach($course->reviews->take(5) as $review)
                {
                    "@type": "Review",
                    "reviewRating": {
                        "@type": "Rating",
                        "ratingValue": "{{ $review->rating }}",
                        "bestRating": "5"
                    },
                    @if($review->comment)
                    "reviewBody": "{{ Str::limit(e($review->comment), 200) }}",
                    @endif
                    "author": {
                        "@type": "Person",
                        "name": "{{ $review->user->name ?? 'Student' }}"
                    },
                    "datePublished": "{{ $review->created_at->toIso8601String() }}"
                }@if(!$loop->last),@endif
                @endforeach
            ],
            @endif
            "offers": {
                "@type": "Offer",
                "price": "{{ $course->discount_price ?? $course->price ?? 0 }}",
                "priceCurrency": "{{ $course->currency ?? 'KES' }}",
                "availability": "https://schema.org/InStock",
                "url": "{{ $canonicalUrl }}",
                "validFrom": "{{ $course->created_at?->toIso8601String() }}"
            }
        }
        @endif
        @if($courseList && count($courseList) > 0)
        ,
        {{-- ItemList Schema for Course Catalog --}}
        {
            "@type": "ItemList",
            "@id": "{{ $canonicalUrl }}/#itemlist",
            "name": "Courses at {{ $siteName }}",
            "numberOfItems": {{ count($courseList) }},
            "itemListElement": [
                @foreach($courseList as $index => $item)
                {
                    "@type": "ListItem",
                    "position": {{ $index + 1 }},
                    "url": "{{ url('/courses/' . $item->slug) }}",
                    "name": "{{ $item->title }}"
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        @endif
        @if($faq && count($faq) > 0)
        ,
        {{-- FAQPage Schema --}}
        {
            "@type": "FAQPage",
            "@id": "{{ $canonicalUrl }}/#faq",
            "mainEntity": [
                @foreach($faq as $index => $item)
                {
                    "@type": "Question",
                    "name": "{{ $item['question'] }}",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "{{ $item['answer'] }}"
                    }
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        @endif
        @if($breadcrumbs && count($breadcrumbs) > 0)
        ,
        {{-- Breadcrumb Schema --}}
        {
            "@type": "BreadcrumbList",
            "@id": "{{ $canonicalUrl }}/#breadcrumb",
            "itemListElement": [
                @foreach($breadcrumbs as $index => $crumb)
                {
                    "@type": "ListItem",
                    "position": {{ $index + 1 }},
                    "name": "{{ $crumb['name'] }}",
                    "item": "{{ $crumb['url'] }}"
                }@if(!$loop->last),@endif
                @endforeach
            ]
        }
        @endif
    ]
}
</script>
