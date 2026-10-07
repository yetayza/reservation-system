<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'BestBKK Reservation')</title>


<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 3;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f5f6fa;
        color: #333;
    }

    .navbar {
        background: #1f2937;
        color: white;
        padding: 18px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo a {
        color: white;
        text-decoration: none;
        font-size: 22px;
        font-weight: bold;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-links {
        display: flex;
        gap: 20px;
        list-style: none;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
    }

    .nav-links a:hover {
        text-decoration: underline;
    }

    .user-name {
        color: #d1d5db;
        font-size: 14px;
    }

    .logout-button {
        background: #dc2626;
        color: white;
        border: none;
        padding: 8px 14px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    .logout-button:hover {
        background: #b91c1c;
    }

    .container {
        width: 100%;
        max-width: none;
        margin: 30px 0;
        padding: 0 30px;
    }

    .page-title {
        margin-bottom: 25px;
    }

    .page-title h1 {
        margin-bottom: 8px;
    }

    .page-title p {
        color: #666;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .card h3 {
        color: #666;
        font-size: 15px;
        margin-bottom: 10px;
    }

    .card .number {
        font-size: 30px;
        font-weight: bold;
    }

    @media (max-width: 1000px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .nav-right {
            flex-wrap: wrap;
        }

        .cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .cards {
            grid-template-columns: 1fr;
        }

        .nav-links {
            flex-wrap: wrap;
            gap: 10px;
            font-size: 14px;
        }

        .nav-right {
            gap: 12px;
        }
    }
</style>


</head>

<body>


<nav class="navbar">

    <div class="logo">
        <a href="{{ route('dashboard') }}">
            BestBKK Reservation
        </a>
    </div>

    @auth

        <div class="nav-right">

            <ul class="nav-links">

                {{-- Dashboard — all roles --}}
                <li>
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>


                {{-- Room Structure — Admin and Manager only --}}
                @if(in_array(auth()->user()->role, ['admin', 'manager']))

                    <li>
                        <a href="{{ route('categories.index') }}">
                            Categories
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('room-types.index') }}">
                            Room Types
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('rooms.index') }}">
                            Rooms
                        </a>
                    </li>

                @endif


                {{-- Guests — all roles --}}
                <li>
                    <a href="{{ route('guests.index') }}">
                        Guests
                    </a>
                </li>


                {{-- Reservations — all roles --}}
                <li>
                    <a href="{{ route('reservations.index') }}">
                        Reservations
                    </a>
                </li>


                {{-- User Management — Admin and Manager only --}}
                @if(in_array(auth()->user()->role, ['admin', 'manager']))

                    <li>
                        <a href="{{ route('users.index') }}">
                            Users
                        </a>
                    </li>

                @endif

            </ul>


            <span class="user-name">
                {{ auth()->user()->name }}
            </span>


            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit" class="logout-button">
                    Logout
                </button>

            </form>

        </div>

    @endauth

</nav>


<main class="container">

    @yield('content')

</main>


</body>
</html>
