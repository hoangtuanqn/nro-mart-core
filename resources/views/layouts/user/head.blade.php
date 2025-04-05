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

    <!-- Embed font -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" /> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika:wght@300..700&display=swap" rel="stylesheet">
    @stack('css')
</head>
