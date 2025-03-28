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
    @yield('script')

</body>

</html>