
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PascalEDU')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            margin: 0;
            background: #fbf7f2;
            color: #342820;
            font-family: Arial, sans-serif;
        }

        .pascal-navbar {
            background: #5b3528;
            padding: 15px 24px;
        }

        .pascal-navbar .navbar-brand {
            color: #fff;
            font-size: 23px;
            font-weight: 800;
        }

        .pascal-navbar .nav-link {
            color: #fff;
        }

        .pascal-navbar .nav-link:hover {
            color: #f5c49e;
        }

        main {
            min-height: calc(100vh - 75px);
        }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg pascal-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">PascalEDU</a>

        <button
            class="navbar-toggler bg-light"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#pascalNavbar"
            aria-controls="pascalNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="pascalNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="{{ auth()->user()->role === 'tutor'
                                ? route('tutor.dashboard')
                                : route('student.dashboard') }}"
                        >
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sessions.index') }}">
                            My Sessions
                        </a>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light ms-lg-2">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main>
    <div class="container-fluid">
        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
