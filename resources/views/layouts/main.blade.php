<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Triple Chasm Calculator')</title>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <a href="{{ url('/') }}" class="brand-link">
                        <img src="{{ asset('images/logo/triple-chasm-logo-full.webp') }}" alt="Triple Chasm Calculator"
                            class="logo" />
                    </a>
                </div>

                <div class="nav-menu" id="navMenu">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ url('/') }}"
                                class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/calculator') }}"
                                class="nav-link {{ request()->is('calculator') ? 'active' : '' }}">Calculator</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/about') }}"
                                class="nav-link {{ request()->is('about') ? 'active' : '' }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/contact') }}"
                                class="nav-link {{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="nav-toggle" id="navToggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
