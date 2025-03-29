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
    @include('layouts.user.header')
    <!-- Main -->
    <main>
        @yield('content')
    </main>

    @include('layouts.user.footer')
    @include('layouts.user.menu-mobile')



    <!-- Scripts -->
    @vite(['resources/assets/js/app.js'])
    @stack('scripts')
</body>

</html>