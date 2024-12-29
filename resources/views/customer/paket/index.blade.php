@extends('customer.index')
@section('content')
<!-- PRODUCT DETAILS -->
<section class="product h-100">
    <div class="container mt-2 mb-5">
        <div class="row">
            <!-- Pengecekan jika produk tidak tersedia -->
            @if ($countData < 1)
                <div class="vh-100 text-center">
                    <h4 class="text-center text-muted mt-5" style="padding-top:200px;">Produk yang Anda Cari Tidak
                        Tersedia</h4>
                    <img src="{{ asset('img/NoData.jpg') }}" alt="Deskripsi alternatif jika gambar tidak dapat dimuat"
                        style="opacity:70%; width: 500px; height: 500px;">
                </div>
            @else
                <!-- Looping produk -->
                @php    $previousCategory = null; @endphp

                @foreach ($product as $data)
                    @if ($data->category->categories_name !== $previousCategory)
                        <div class="title mt-5 mb-5 text-center" style="padding-top: 100px; border-bottom: 1px solid #ddd">
                            <h1>{{ $data->category->categories_name }}</h1>
                        </div>
                        @php            $previousCategory = $data->category->categories_name; @endphp
                    @endif

                    <div class="col-lg-3 text-center">
                        <div class="card mb-3" style="width: 18rem;">
                            <div class="card-image">
                                <img src="{{ asset($data->image) }}" class="w-100" />
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data->product_name }}</h5>
                                    <p class="card-text">Rp. {{ number_format($data->price, 0, ',', '.') }}/Month</p>
                                    <!-- Link untuk memesan paket -->
                                    <a href="{{ route('customer.pesan', $data->product_name) }}"
                                        class="btn btn-primary">Subscribe</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- END PRODUCT DETAILS -->
@endsection