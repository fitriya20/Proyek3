<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand mx-5" href="index.php">
            <img src="{{ asset('img/3putra.png') }}" alt="logo tiga putra" width="150" height="80">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mt-3 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.dashboard') }}">Home</a>
                </li>
                <li class="dropdown nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="dropdown">Product ></a>
                    <ul class="dropdown-menu">
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item"
                                    href="{{ route('customer.paket', ['kategori' => $category->categories_name]) }}">{{ $category->categories_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.about') }}">About</a>
                </li>
            </ul>

            <div class="d-flex justify-content-start px-2 m-auto">
                <form method="GET" action="{{ route('customer.paket') }}">
                    @csrf
                    <div class="search">
                        <input type="text" name="keyword" class="search-input">
                        <a href="#" class="search-icon">
                            <i data-feather="search"></i>
                        </a>
                    </div>
                </form>
            </div>
            <div class="nav-extra mt-3 ms-10">
                <span class="login-icon">
                    @if (Route::has('login'))
                        @auth
                            <span class="dropdown">
                                <a role="button" data-bs-toggle="dropdown"
                                    class="userprofile text-decoration-none d-flex gap-1 align-items-center"
                                    style="color: black;">
                                    <img src="{{ asset(Auth::user()->image) }}" alt="{{ Auth::user()->name }}"
                                        class="profile-img rounded-circle"
                                        style="width: 30px; height: 30px; object-fit: cover;">
                                    <span class="username dropdown-toggle ">
                                        {{ Auth::user()->name }}
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('customer.profil') }}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </span>
                        @else
                            <i data-feather="user"></i>
                            <a href="{{ route('login') }}" class="btn login-button">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn login-button">Register</a>
                            @endif
                        @endauth
                    @endif
                </span>
            </div>
        </div>
    </div>
</nav>
