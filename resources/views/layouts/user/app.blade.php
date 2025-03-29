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
    @stack('scripts')

</body>

</html>