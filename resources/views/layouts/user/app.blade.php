{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<!DOCTYPE html>
<html lang="en">
<!-- Head -->
@include('layouts.user.head')

<body>
    <!-- CSRF Token Meta for JS usage -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.user.header')
    <!-- Main -->
    <main>
        @yield('content')
    </main>

    @include('layouts.user.footer')
    @include('layouts.user.menu-mobile')

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- Lightbox script -->
    <script src="{{ asset('assets/libs/simplelightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/image-lightbox.js') }}"></script>

    <!-- Mobile Menu script -->
    <script src="{{ asset('assets/js/mobile-menu.js') }}"></script>

    <!-- Core scripts -->
    <script src="{{ asset('assets/js/discount-code.js') }}"></script>

    @stack('scripts')
    <script src="{{ asset('assets/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/alert-notice.js') }}"></script>

    <!-- Add before closing body tag -->
</body>

</html>
