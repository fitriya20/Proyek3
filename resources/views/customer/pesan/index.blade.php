@extends('customer.index')
@section('content')
    <section id="produk" class="produk mt-20 mb-0">
        <div class="container mb-5 mt-20">
            <div class="row mb-4 mt-5 pt-5">
                <div class="col text-center mt-5">
                    <h2 class="pesan mt-1">Order now</h2>
                    <hr>
                </div>
                <div class="row mb-4 mt-3 pb-4">
                    <div class="col-lg-6 pe-4 d-flex justify-content-center align-items-center">
                        <div class="products-image text-center">
                            <img src="{{ asset($product->image) }}" class="w-75">
                            <h1 class="mt-2">Rp. <?php echo number_format($product->price, 0, ',', '.'); ?>/Month</h1>
                        </div>
                    </div>

                    <div class="col-lg-6 ps-5">
                        <form class="pesanan" method="POST"
                            action="{{ route('customer.proses', $product->product_name) }}">
                            @csrf
                            <h1>{{ $product->product_name }}</h1>
                            <p class="mt-2">{{ $product->deskripsi }}</p>
                            <h4 class="mt-3">Installation Address</h4>
                            <div class="form-group">
                                <textarea name="address" class="form-control" placeholder="Address Details"></textarea>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="order_date">Order Date:</label>
                                        <input type="date" name="order_date" id="order_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="installation_date">Installation Date:</label>
                                        <input type="date" name="installation_date" id="installation_date"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                            <!-- Tambahkan select drivers_id -->
                            <div class="form-group mt-3">
                                <label for="drivers_id">Select Driver:</label>
                                <select name="drivers_id" id="drivers_id" class="form-control">
                                    <option value="" disabled selected>Choose Driver</option>
                                    @foreach ($drivers as $driver)
                                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
