<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <title>Your Application</title>
</head>

<body id="body-pd">

    @if(Auth::check())
    <header class="header" id="header">
        <div class="header_toggle"><i class='bx bx-menu' id="header-toggle"></i></div>
        <div class="header_img"><img src="https://i.imgur.com/hczKIze.jpg" alt=""></div>
    </header>

    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="{{ route('home') }}" class="nav_logo">
                    <i class='bx bx-layer nav_logo-icon'></i>
                    <span class="nav_logo-name">E-COMMERCE</span>
                </a>
                <div class="nav_list">
                    <a href="{{ route('home') }}" class="nav_link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt nav_icon'></i>
                        <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="{{ route('users.index') }}" class="nav_link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Admins</span>
                    </a>
                    <a href="{{ route('roles.index') }}" class="nav_link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class='bx bx-bookmark nav_icon'></i>
                        <span class="nav_name">Role</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="nav_link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class='bx bx-folder nav_icon'></i>
                        <span class="nav_name">Product</span>
                    </a>
                    <a href="{{ route('categories.index') }}" class="nav_link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class='bx bx-category nav_icon'></i>
                        <span class="nav_name">Categories</span>
                    </a>
                    <a href="{{ route('brands.index') }}" class="nav_link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                        <i class='bx bx-tag nav_icon'></i>
                        <span class="nav_name">Brands</span>
                    </a>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="nav_link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">SignOut</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </a>
        </nav>
    </div>
    @endif

    <!-- Container Main start -->
    <div class="height-100">
        <main class="py-4">
            <div class="container bg-white">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
