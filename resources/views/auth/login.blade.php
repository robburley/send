<!doctype html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Log in | Send</title>
    <meta name="description" content="Dashboard UI Kit">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="c-login-wrapper">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

<div class="c-login c-login--horizontal">
    <div class="c-login__content-wrapper">
        <header class="c-login__head">
            <a class="c-login__icon c-login__icon--rounded c-login__icon--left" href="#!">
                <img src="img/logo-login.svg" alt="Dashboard's Logo">
            </a>

            <h2 class="c-login__title">Sign In</h2>
        </header>

        <form class="c-login__content" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="c-field u-mb-small">
                <label class="c-field__label" for="username">Username</label>
                <input class="c-input{{ $errors->has('username') ? ' c-input--danger' : '' }}"
                       type="text"
                       name="username"
                       placeholder=""
                       value="{{ old('username') }}"
                >

                @if ($errors->has('username'))
                    <small class="c-field__message u-color-danger">
                        <i class="fa fa-times-circle"></i>{{ $errors->first('username') }}
                    </small>
                @endif
            </div>

            <div class="c-field u-mb-small">
                <label class="c-field__label" for="password">Password</label>

                <input class="c-input{{ $errors->has('password') ? ' c-input--danger' : '' }}"
                       type="password"
                       name="password"
                       placeholder=""
                >

                @if ($errors->has('password'))
                    <small class="c-field__message u-color-danger">
                        <i class="fa fa-times-circle"></i>{{ $errors->first('password') }}
                    </small>
                @endif
            </div>

            <button class="c-btn c-btn--success c-btn--fullwidth" type="submit">Sign in</button>
        </form>
    </div>

    <div class="c-login__content-image">
        <img src="img/login2.jpg" alt="Welcome to Dashboard UI Kit">

        <h3>Welcome to Send</h3>
        <p class="u-text-large">You email and calendar solution.</p>
    </div>
</div>

<script src="/js/main.js"></script>
</body>
</html>

