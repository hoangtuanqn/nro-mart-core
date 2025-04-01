<!DOCTYPE html>
<html lang="en">
@include('layouts.admin.head')

<body>
    {{-- <div id="global-loader">
        <div class="whirly-loader"></div>
    </div> --}}

    <div class="main-wrapper">
        @include('layouts.admin.header')
        @include('layouts.admin.sidebar')

        @yield('content')
    </div>

    @include('layouts.admin.footer')
</body>

</html>
