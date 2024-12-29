@extends('customer.index')
@section('content')
    <section class="banner h-100 mt-5">
        <div class="container text-blue">
            <div class="row py-5">
                <div class="banner-fill col-lg-7 pt-1 ms-5">
                    <h1 class="fs-5 ms-4 mb-0">TigaPutraNet</h1>
                    <p class="fs-3 ms-4 mb-0">One Place for Everything</p>
                    <p class="fs-3 ms-4 mb-0">Best Local Wifi Service Provider</p>
                    <a class="btn btn2 ms-4 mb-0" href="{{ route('customer.map') }}" role="button">Check our Service Users
                        near you</a>
                </div>
            </div>
        </div>
    </section>
    <!-- end banner -->

    <!-- PILIHAN PAKET -->
    <section id="produk" class="produk">
        <div class="container mb-5">
            <div class="row mb-4 pt-5">
                <div class="col text-center">
                    <h2>Product TigaPutraNet</h2>
                    <hr>
                </div>
            </div>
            <div class="row mb-4 pt-5">
                @foreach ($product as $data)
                    <div class="col-lg-3 text-center">
                        <div class="card mb-3" style="width: 18rem;">
                            <div class="card-image">
                                <img src="{{ asset($data->image) }}" class="w-100" />
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data->product_name }}</h5>
                                    <p class="card-text">Rp {{ number_format($data->price, 0, ',', '.') }}/Month</p>
                                    <a href="{{ route('customer.pesan', $data->product_name) }}"
                                        class="btn btn-primary">Subscribe</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Tombol Lihat Semua -->
            <div class="semuapaket text-center mt-5">
                <a href="{{ route('customer.paket') }}">Lihat semua ></a>
            </div>
        </div>
    </section>
@endsection
