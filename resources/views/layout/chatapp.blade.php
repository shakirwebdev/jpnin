<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->
<title>@yield('title') - {{ config('app.name') }}</title>
<meta name="description" content="@yield('meta_description', config('app.name'))">
<meta name="author" content="@yield('meta_author', config('app.name'))">

@yield('meta')
@stack('before-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">    
@stack('after-styles')
@if (trim($__env->yieldContent('page-styles')))    
@yield('page-styles')
@endif    

<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/theme1.css') }}">
</head>

<body class="font-montserrat sidebar_dark">
    
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
    </div>
</div>

<div id="main_content">
    
    @include('layout.headertop')
    @include('layout.rightbar')
    @include('layout.userdiv')    
    @include('layout.sidebar')

    <div class="page">
        @yield('content')
    </div>        
</div>

@yield('popup')

<!-- Scripts -->
@stack('before-scripts')
<script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
<script src="{{ asset('assets/js/core.js') }}"></script>
@stack('after-scripts')

@if (trim($__env->yieldContent('page-script')))
@yield('page-script')
@endif

</body>
</html>
