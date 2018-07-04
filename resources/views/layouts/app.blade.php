<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Dashboard UI Kit">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Send</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="o-page">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

<div id="app">
    @include('layouts.nav')

    <main class="o-page__content">

        <header class="c-navbar u-hidden-up@desktop">
            <button class="c-sidebar-toggle u-mr-small">
                <span class="c-sidebar-toggle__bar"></span>
                <span class="c-sidebar-toggle__bar"></span>
                <span class="c-sidebar-toggle__bar"></span>
            </button><!-- // .c-sidebar-toggle -->
        </header>
        <div class="container-fluid  border-top-blue">
            @yield('content')
        </div><!-- // .container -->

    </main><!-- // .o-page__content -->
</div>

<script src="/js/main.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
