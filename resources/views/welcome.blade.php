<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

    <title>Welcome Noya</title>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            background-color: black;
            height: 100vh;
            width: 100vw;
            color: white;
            font-family: 'Figtree', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .top-right-links {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 15px;
            z-index: 3;
        }

        .top-right-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .top-right-links a:hover {
            color: #92d000;
        }

        .circle-image {
            position: absolute;
            bottom: 1px;
            left: 0px;
            width: 400px;
            height: auto;
            transform: rotate(15deg);
            z-index: 1;
            animation: slide-in 1.5s ease-out forwards;
        }

        .logo {
            position: absolute;
            top: 70px;
            left: 50%;
            transform: translateX(calc(-50% - 30px));
            width: 700px;
            height: auto;
            max-width: 90%;
            z-index: 2;
        }

        .dashboard-text {
            position: absolute;
            top: 560px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.1rem;
            z-index: 2;
            white-space: nowrap;
        }

        @media (max-width: 1200px) {
            .logo {
                width: 600px;
                top: 50px;
            }

            .circle-image {
                width: 350px;
            }

            .dashboard-text {
                top: 500px;
            }
        }

        @media (max-width: 768px) {
            .logo {
                width: 500px;
                top: 30px;
            }

            .circle-image {
                width: 300px;
            }

            .dashboard-text {
                top: 450px;
                font-size: 1rem;
            }

            .top-right-links a {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .logo {
                width: 350px;
                top: 20px;
                transform: translateX(calc(-50% - 20px));
            }

            .circle-image {
                width: 250px;
            }

            .dashboard-text {
                top: 300px;
                font-size: 0.9rem;
            }

            .top-right-links {
                gap: 10px;
                right: 10px;
            }

            .top-right-links a {
                font-size: 0.9rem;
            }
        }

        @keyframes slide-in {
            from { left: -200px; }
            to { left: 1px; }
        }
    </style>
</head>
<body>
    <!-- Login Links -->
    <div class="top-right-links">
        @if (Route::has('login'))
            @auth
                @php
                    $user = auth()->user();
                @endphp
                @if ($user->hasRole('admin'))
                    <a href="{{ url('/adminUI/dashboardui') }}">Admin Dashboard</a>
                @elseif ($user->hasRole('superadmin'))
                    <a href="{{ url('/adminUI/dashboardui') }}">Super Admin Dashboard</a>
                @else
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        @endif
    </div>

    <!-- Circle Image -->
    <img src="{{ asset('images/circle.png') }}" alt="circles" class="circle-image" />

    <!-- Logo -->
    <img src="{{ asset('images/noya icon logo .png') }}" alt="logo" class="logo" />

    <!-- Welcome Text -->
    <div class="dashboard-text">Welcome to Noya Dashboard</div>
</body>
</html>
