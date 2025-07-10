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
            <div
                style="margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 2rem; max-width: 80vw;">
                <div class="nav-brand">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo/triple-chasm-logo-light.png') }}" alt="Triple Chasm Calculator"
                            class="logo" />
                        <span>NavigatorPLUS</span><span>&copy;</span>
                    </a>
                </div>
                <div class="nav-menu" id="navMenu">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5A11.336 11.336 0 0 0 .75 15.923V18a1.5 1.5 0 0 0 1.5 1.5h19.5a1.5 1.5 0 0 0 1.5-1.5v-2.08A11.336 11.336 0 0 0 12 4.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 19.5v-.75a3 3 0 0 1 6 0v.75m-.75-10.497L12 15.753" />
                                        <path
                                            d="M4.875 15.75a.375.375 0 0 1 0-.75m0 .75a.375.375 0 0 0 0-.75m1.5-2.997a.375.375 0 0 1 0-.75m0 .75a.375.375 0 0 0 0-.75m3-2.25a.375.375 0 1 1 0-.75m0 .75a.375.375 0 1 0 0-.75M17.625 12a.375.375 0 0 1 0-.75m0 .75a.375.375 0 0 0 0-.75m1.5 4.503a.375.375 0 0 1 0-.75m0 .75a.375.375 0 0 0 0-.75" />
                                    </g>
                                </svg></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/profile') }}"
                                class="nav-link {{ request()->is('profile') ? 'active' : '' }}"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                    viewBox="0 0 36 36">
                                    <path fill="currentColor"
                                        d="m32.57 15.72l-3.35-1a11.7 11.7 0 0 0-.95-2.33l1.64-3.07a.61.61 0 0 0-.11-.72l-2.39-2.4a.61.61 0 0 0-.72-.11l-3.05 1.63a11.6 11.6 0 0 0-2.36-1l-1-3.31a.61.61 0 0 0-.59-.41h-3.38a.61.61 0 0 0-.58.43l-1 3.3a11.6 11.6 0 0 0-2.38 1l-3-1.62a.61.61 0 0 0-.72.11L6.2 8.59a.61.61 0 0 0-.11.72l1.62 3a11.6 11.6 0 0 0-1 2.37l-3.31 1a.61.61 0 0 0-.43.58v3.38a.61.61 0 0 0 .43.58l3.33 1a11.6 11.6 0 0 0 1 2.33l-1.64 3.14a.61.61 0 0 0 .11.72l2.39 2.39a.61.61 0 0 0 .72.11l3.09-1.65a11.7 11.7 0 0 0 2.3.94l1 3.37a.61.61 0 0 0 .58.43h3.38a.61.61 0 0 0 .58-.43l1-3.38a11.6 11.6 0 0 0 2.28-.94l3.11 1.66a.61.61 0 0 0 .72-.11l2.39-2.39a.61.61 0 0 0 .11-.72l-1.66-3.1a11.6 11.6 0 0 0 .95-2.29l3.37-1a.61.61 0 0 0 .43-.58v-3.41a.61.61 0 0 0-.37-.59M18 23.5a5.5 5.5 0 1 1 5.5-5.5a5.5 5.5 0 0 1-5.5 5.5"
                                        class="clr-i-solid clr-i-solid-path-1" />
                                    <path fill="none" d="M0 0h36v36H0z" />
                                </svg></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/questionnaire') }}"
                                class="nav-link {{ request()->is('questionnaire') ? 'active' : '' }}"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="-4 -2 24 24">
                                    <path fill="currentColor"
                                        d="M3 0h10a3 3 0 0 1 3 3v14a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3V3a3 3 0 0 1 3-3m0 2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm2 1h6a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2m0 12h2a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2m0-4h6a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2m0-4h6a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2" />
                                </svg></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/help') }}"
                                class="nav-link {{ request()->is('help') ? 'active' : '' }}"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M16 2a14 14 0 1 0 14 14A14 14 0 0 0 16 2m0 23a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 16 25m1.142-7.754v2.501h-2.25V15h2.125a2.376 2.376 0 0 0 0-4.753h-1.5a2.38 2.38 0 0 0-2.375 2.375v.638h-2.25v-.638A4.63 4.63 0 0 1 15.517 8h1.5a4.624 4.624 0 0 1 .125 9.246" />
                                    <path fill="none"
                                        d="M16 25a1.5 1.5 0 1 1 1.5-1.5A1.5 1.5 0 0 1 16 25m1.142-7.754v2.501h-2.25V15h2.125a2.376 2.376 0 0 0 0-4.753h-1.5a2.38 2.38 0 0 0-2.375 2.375v.638h-2.25v-.638A4.63 4.63 0 0 1 15.517 8h1.5a4.624 4.624 0 0 1 .125 9.246" />
                                </svg></a>
                        </li>
                    </ul>
                </div>
                <div class="nav-title">
                    @php
                        $segments = request()->segments();
                        $routeName = count($segments) ? ucfirst(str_replace('-', ' ', end($segments))) : 'Dashboard';
                    @endphp
                    {{ $routeName }}
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
