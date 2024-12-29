<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="sidebar col-md-2 min-vh-100">
            <span class="brand-logo bg-light d-flex justify-content-center mb-2">
                <img src="{{ asset('img/3putra.png') }}" alt="TigaPutraNet">
            </span>
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" aria-current="page">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customer') }}" class="nav-link">
                        Data Customer
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.customer-order') }}" class="nav-link">
                        Data Order
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.profit') }}" class="nav-link">
                        Data Profit
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.product') }}" class="nav-link">
                        Data Product
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.category') }}" class="nav-link">
                        Data Category
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.driver') }}" class="nav-link">
                        Data Driver
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
