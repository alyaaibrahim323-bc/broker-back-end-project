<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
        <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
          <script src="https://cdn.tailwindcss.com"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.Echo.channel('notifications') // استخدم القناة 'unit'
                .listen('NotificationEvent', (e) => { // استخدم الحدث 'UnitEvent'
                    const notifications = document.getElementById('notifications');
                    const notification = document.createElement('div');
                    notification.textContent = e.message;
                    notifications.appendChild(notification);
                });
        });
    </script>
    <link rel="stylesheet" href="/build/assets/dashboradui-CETY4xDR.css">
    <link rel="stylesheet" href="/build/assets/style-l0sNRNKZ.js>
    <script src="/build/assets/app-WZ9PCuXp.js" type="module"></script>

    <!--@vite(['resources/js/app.js', 'resources/css/dashboradui.css','resources/css/style.css'])-->

</head>
<body>{{-- <div class="notification-badge">
    <div class="badge-circle"></div>
    <div class="badge-count">4</div>
</div> --}}




    <div class="sidebar">
        <div class="user-profile">
          <div class="profile-picture">
 @if(auth()->check() && auth()->user()->image)
                <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="User Image">
            @else
                <img src="{{ asset('default-user-image.png') }}" alt="Default Image">
            @endif               </div>
            <div class="user-info">
                @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')))
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                @else
                    <div class="user-name">Guest</div>
                    <div class="user-email">Not logged in</div>
                @endif
            </div>
        </div>
        <h4 class="sidebar-title">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; color: inherit;">Dashboard</a>
        </h4>
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('developers.show') ? 'active' : '' }}">
                <a href="{{ route('developers.show') }}">Developers</a>
            </li>
            <li class="{{ request()->routeIs('compounds.show') ? 'active' : '' }}">
                <a href="{{ route('compounds.show') }}">Projects</a>
            </li>
            <li class="{{ request()->routeIs('properties.show') ? 'active' : '' }}">
                <a href="{{ route('properties.show') }}">Units</a>
            </li>
             <li class="{{ request()->routeIs('offers.show') ? 'active' : '' }}">
                <a href="{{ route('offers.show') }}">Offers</a>
            </li>
            <li class="{{ request()->routeIs('sales.show') ? 'active' : '' }}">
                <a href="{{ route('sales.show') }}">Employees</a>
            </li>
            <li class="{{ request()->routeIs('users.show') ? 'active' : '' }}">
                <a href="{{ route('users.show') }}">users</a>
            </li>
             <li class="{{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                <a href="{{ route('bookings.index') }}">Request</a>
            </li>
            <li class="{{ request()->routeIs('roles.index') ? 'active' : '' }}">
                <a href="{{ route('roles.index') }}">roles</a>
            </li>
            <li class="{{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                <a href="{{ route('permissions.index') }}">permissions</a>
            </li>
            <li class="{{ request()->routeIs('settings') ? 'active' : '' }}">
                <a href="{{ route('settings') }}"> Settings</a>
            </li>
        </ul>
    </div>
<!-- Main Content -->
<div class="main-content">
    @yield('content')
</div>

@include('partials.notifications')


</body>
</html>
