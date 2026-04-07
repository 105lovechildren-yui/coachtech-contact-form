<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FashionablyLate')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body class="layout">
    <div class="layout__container">
        <header class="site-header">
            <div class="site-header__inner">
                <h1 class="site-header__logo">
                    <a class="site-header__logo-link" href="{{ url('/') }}">FashionablyLate</a>
                </h1>
                <div class="site-header__actions">
                    @yield('header_actions')
                </div>
            </div>
        </header>

        <main class="layout__main">
            @yield('content')
        </main>
    </div>
</body>

</html>