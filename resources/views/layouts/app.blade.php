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

        <!-- Breadcrumb navigation -->
        <nav aria-label="breadcrumb" class="">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
               
                @if (request()->routeIs('users.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('users.index') }}">Admins</a>
                    </li>
                    @if (request()->routeIs('users.edit'))
                    <li class="breadcrumb-item" aria-current="page">Edit Admin</li>
                    @elseif (request()->routeIs('users.create'))
                    <li class="breadcrumb-item" aria-current="page">Create Admin</li>
                    @elseif (request()->routeIs('users.show'))
                    <li class="breadcrumb-item" aria-current="page">Admin Details</li>
                    @endif
                @endif

                @if (request()->routeIs('roles.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('roles.index') }}">Roles</a>
                    </li>
                    @if (request()->routeIs('roles.edit'))
                    <li class="breadcrumb-item" aria-current="page">Edit Role</li>
                    @elseif (request()->routeIs('roles.create'))
                    <li class="breadcrumb-item" aria-current="page">Create Role</li>
                    @elseif (request()->routeIs('roles.show'))
                    <li class="breadcrumb-item" aria-current="page">Role Details</li>
                    @endif
                @endif

                @if (request()->routeIs('products.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}">Products</a>
                    </li>
                    @if (request()->routeIs('products.edit'))
                    <li class="breadcrumb-item" aria-current="page">Edit Product</li>
                    @elseif (request()->routeIs('products.create'))
                    <li class="breadcrumb-item" aria-current="page">Create Product</li>
                    @elseif (request()->routeIs('products.show'))
                    <li class="breadcrumb-item" aria-current="page">Product Detials</li>
                    @endif
                @endif

                @if (request()->routeIs('categories.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.index') }}">Categories</a>
                    </li>
                    @if (request()->routeIs('categories.edit'))
                    <li class="breadcrumb-item" aria-current="page">Edit Category</li>
                    @elseif (request()->routeIs('categories.create'))
                    <li class="breadcrumb-item" aria-current="page">Create Category</li>
                    @elseif (request()->routeIs('categories.show'))
                    <li class="breadcrumb-item" aria-current="page">Category Detials</li>
                    @endif
                @endif

                @if (request()->routeIs('brands.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('brands.index') }}">Brands</a>
                    </li>
                    @if (request()->routeIs('brands.edit'))
                        <li class="breadcrumb-item" aria-current="page">Edit Brand</li>
                    @elseif (request()->routeIs('brands.create'))
                        <li class="breadcrumb-item" aria-current="page">Create Brand</li>
                    @elseif (request()->routeIs('brands.show'))
                        <li class="breadcrumb-item" aria-current="page">Brand Details</li>
                    @endif
                @endif

                @if (request()->routeIs('customers.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('customers.index') }}">Customers</a>
                    </li>
                    @if (request()->routeIs('customers.show'))
                        <li class="breadcrumb-item" aria-current="page">Customer Details</li>
                    @elseif (request()->routeIs('customers.edit'))
                        <li class="breadcrumb-item" aria-current="page">Edit Customer</li>
                    @endif
                @endif

                @if (request()->routeIs('orders.*'))
                    <li class="breadcrumb-item">
                        <a href="{{ route('orders.index') }}">Orders</a>
                    </li>
                    @if (request()->routeIs('orders.show'))
                        <li class="breadcrumb-item" aria-current="page">Order Details</li>
                    @endif
                @endif
            </ol>
        </nav>
     <!-- User Name on the Right -->
     <div class="d-flex align-items-center ms-auto ">
     <i class="fa-solid fa-user me-2 header_username"> </i>
        <span class="header_username me-3">
             {{ Auth::user()->name }}
        </span>
       
    </div>
    </header>

    @if (!request()->routeIs('home') &&
    !request()->routeIs('users.index') &&
    !request()->routeIs('roles.index') &&
    !request()->routeIs('products.index') &&
    !request()->routeIs('categories.index') &&
    !request()->routeIs('brands.index') && 
    !request()->routeIs('customers.index')&&
    !request()->routeIs('orders.index'))
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm back-to-top">
        <i class="fas fa-arrow-left"></i> Back
    </a>
    @endif
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="{{ route('home') }}" class="nav_logo">
                    <i class="fa-brands fa-shopify fa-lg" style="color: #ffffff;"></i>
                    <span class="nav_logo-name ms-1">E-COMMERCE</span>
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
                    <a href="{{ route('customers.index') }}" class="nav_link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i>
                        <span class="nav_name">Customers</span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="nav_link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i>
                        <span class="nav_name">Orders</span>
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
    <div class="height-100 mb-5">
        <main class="py-4">
            <div class="container bg-white">
                <div class="row justify-content-center">
                    <div class="col-md-12 mb-3">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
