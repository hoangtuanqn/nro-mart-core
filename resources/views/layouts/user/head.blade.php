{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="robots" content="index, follow" />

    <title>@yield('title', config_get('site_name')) - {{ config_get('site_name') }}</title>

    <!-- Primary Meta Tags -->
    <meta name="description" content="{{ config_get('site_description') }}" />
    <meta name="keywords" content="{{ config_get('site_keywords') }}" />
    <meta name="author" content="{{ config_get('site_name') }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config_get('site_name') }}" />
    <meta property="og:title" content="@yield('title', config_get('site_name')) - {{ config_get('site_name') }}" />
    <meta property="og:description" content="{{ config_get('site_description') }}" />
    <meta property="og:image" content="{{ config_get('site_share_image', config_get('site_logo')) }}" />
    <meta property="og:image:alt" content="{{ config_get('site_name') }}" />
    <meta property="og:locale" content="vi_VN" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="@yield('title', config_get('site_name')) - {{ config_get('site_name') }}" />
    <meta name="twitter:description" content="{{ config_get('site_description') }}" />
    <meta name="twitter:image" content="{{ config_get('site_share_image', config_get('site_logo')) }}" />
    <meta name="twitter:image:alt" content="{{ config_get('site_name') }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ config_get('site_favicon') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ config_get('site_favicon') }}" type="image/png" />
    <link rel="apple-touch-icon" href="{{ config_get('site_favicon') }}" />

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- DNS Prefetch -->
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />

    <!-- Preload Important Resources -->
    <link rel="preload" href="{{ asset('assets/fonts/stylesheet.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/css/global.css') }}" as="style" />

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/stylesheet.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/deposit.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/category.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/detail-account.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/service.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/wheel.css') }}" />
    <!-- Random Accounts CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/random-accounts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/random-account-detail.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/random-categories.css') }}" />

    <!-- Game Accounts CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/game-accounts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/game-account-detail.css') }}" />

    <!-- Services CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/service-cards.css') }}" />

    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="{{ asset('assets/libs/simplelightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lightbox-custom.css') }}" />

    <!-- Responsive Fixes -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive-fixes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-responsive.css') }}" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @if (request()->is('/'))
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "{{ config_get('site_name') }}",
            "url": "{{ url('/') }}",
            "logo": "{{ config_get('site_logo') }}",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "{{ config_get('phone') }}",
                "contactType": "customer service",
                "availableLanguage": "Vietnamese"
            },
            "sameAs": [
                "{{ config_get('facebook') }}",
                "{{ config_get('youtube') }}"
            ]
        }
    </script>
    @endif

    <!-- Page-specific CSS -->
    @stack('css')
</head>
