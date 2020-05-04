<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/big/akikah_logo.jpg') }}">
    <title>@yield('title', 'Akikah Kita | Dashboard')</title>
    <!-- Custom CSS -->
    <link href="{{ asset('extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('extra-libs/jvector/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    @stack('css')
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            @include('layouts._header_logo')
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6">
            @include('layouts._sidebar')
        </aside>
        <div class="page-wrapper">
            <div class="container-fluid">
                {{-- Content Start --}}
                    @yield('content')
                {{-- Content End --}}
            </div>
            <footer class="footer text-center text-muted">
                &copy; Built with <img class="icon-hati" src="https://www.malasngoding.com/wp-content/uploads/2018/10/malas-ngoding-tutorial-pemrograman-terlengkap-bahasa-indonesia-untuk-pemula-sampai-mahir.gif" width="25"> by <a href="https://qodrbee.com" target="_blank" style="color: #fcba03;">QODR Bee</a>. Design by AdminMart.
                    {{-- href="https://wrappixel.com">WrapPixel</a>. --}}
            </footer>
        </div>
    </div>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('../dist/js/app-style-switcher.js')}}"></script>
    <script src="{{ asset('dist/js/feather.min.js') }}"></script>
    <script src="{{ asset('libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>

    {{-- Notify --}}
    @include('layouts.partials.noty')

    @yield('scripts')
    @stack('js')

</body>

</html>
