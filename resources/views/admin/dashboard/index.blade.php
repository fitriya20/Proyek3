@extends('admin.index')
@section('content')
    <div class="content col-md-10">
        <div cl ass="top-fixed line"></div>
        <div class="container">
            <div class="title mt-5 ms-5">
                <span>Dashboard</span>
            </div>
            <div class="selection d-flex justify-content-center">
                <div class="row d-flex justify-content-center mt-5 pt-4">
                    <div class="col-md-3">
                        <a href="{{ route('admin.customer') }}">
                            <div class="card" id="card1">
                                <a href="{{ route('admin.customer') }}" class="card-link">
                                    <span class="d-flex"><i data-feather="users"></i>
                                        <h1 class="ms-2">{{ $user }}</h1>
                                    </span>
                                    <span class="card-text">Registered Customer</span>
                                </a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.product') }}">
                            <div class="card" id="card2">
                                <a href="{{ route('admin.product') }}" class="card-link">
                                    <span class="d-flex"><i data-feather="box"></i>
                                        <h1 class="ms-2">{{ $product }}</h1>
                                    </span>
                                    <span class="card-text">Product</span>
                                </a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.customer-order') }}">
                            <div class="card" id="card3">
                                <a href="{{ route('admin.customer-order') }}" class="card-link">
                                    <span class="d-flex"><i data-feather="shopping-cart"></i>
                                        <h1 class="ms-2">{{ $orders }}</h1>
                                    </span>
                                    <span class=" card-text">Order</span>
                                </a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">

                        <a href="{{ route('admin.profit') }}">
                            <div class="card" id="card3">
                                <a href="{{ route('admin.profit') }}" class="card-link">
                                    <span class="d-flex"><i data-feather="dollar-sign"></i>
                                        <h1 class="ms-2">{{ number_format($total_profit, 0, ',', '.') }}</h1>
                                    </span>
                                    <span class=" card-text">Profit</span>
                                </a>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
