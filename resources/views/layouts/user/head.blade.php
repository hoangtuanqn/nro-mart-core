{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title', 'Website được thiết kế bởi TUANORI.VN') - {{ config_get('site_name') }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ config_get('site_description') }}" />
    <meta name="keywords" content="{{ config_get('site_keywords') }}" />
    <meta name="author" content="{{ config_get('site_name') }}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="@yield('title', 'Website được thiết kế bởi TUANORI.VN') - {{ config_get('site_name') }}" />
    <meta property="og:description" content="{{ config_get('site_description') }}" />
    <meta property="og:image" content="{{ config_get('site_logo') }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:title" content="@yield('title', 'Website được thiết kế bởi TUANORI.VN') - {{ config_get('site_name') }}" />
    <meta property="twitter:description" content="{{ config_get('site_description') }}" />
    <meta property="twitter:image" content="{{ config_get('site_logo') }}" />

    <!-- Favicon -->
    <link rel="icon" href="{{ config_get('site_favicon') }}" type="image/png" />
    <link rel="shortcut icon" href="{{ config_get('site_favicon') }}" type="image/png" />

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="stylesheet" href="{{ asset('assets/fonts/stylesheet.css') }}" />

    <!-- CSS -->
    {{-- @vite(['resources/assets/css/app.css']) --}}


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

    <!-- Embed Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('css')
</head>
