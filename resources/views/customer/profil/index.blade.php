@extends('customer.index')
@section('content')
    <div class="user-profile h-100">
        @if (Session('success'))
            <script>
                Swal.fire({
                    'title': 'Success!',
                    'text': '{{ session('success') }}',
                    'icon': 'success'
                });
            </script>
        @endif
        <div class="container" style="padding-top: 200px; margin-bottom: 100px;">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="title text-center mt-3">
                            <h1>Profile</h1>
                        </div>
                        <div class="card-body text-center">
                            <div class="user-info">
                                <div class="data">
                                    <form method="POST" enctype="multipart/form-data"
                                        action="{{ route('customer.profil.edit') }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <span class="profileImg">
                                            <label class="form-label btn-upload " for="image"><i
                                                    data-feather="camera"></i></label>
                                            <input type="file" id="image" name="image" class="form-control d-none">
                                            <img src="{{ Auth::user()->image ?? 'null' }}" alt="{{ Auth::user()->name }}"
                                                class="profile-img rounded-circle">
                                        </span>
                                        <h3>{{ Auth::user()->name }}</h3>
                                        <p>{{ Auth::user()->no_telp }}</p>
                                        <p>{{ Auth::user()->email }}</p>
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ Auth::user()->name }}">
                                            <label for="name">Your Name</label>
                                        </div>
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ Auth::user()->email }}">
                                            <label for="email">Your Email</label>
                                        </div>
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="text" class="form-control" id="no_telp" name="no_telp"
                                                value="{{ str_replace('0', '+62', Auth::user()->no_telp) }}">
                                            <label for="telp">Phone</label>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction History Card -->
                <div class="col-lg-9">
                    <div class="card w-100">
                        <div class="title mt-3 ms-5">
                            <h1>Activity</h1>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Order Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Drivers</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Statuses</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $data)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $data->order_date }}
                                            </td>
                                            <td>
                                                {{ $data->users->name }}
                                            </td>
                                            <td>
                                                {{ $data->users->email }}
                                            </td>
                                            <td>
                                                {{ str_replace('0', '+62', $data->users->no_telp) }}
                                            </td>
                                            <td>
                                                {{ $data->address }}
                                            </td>
                                            <td>
                                                {{ $data->driver->name }}
                                            </td>
                                            <td>
                                                {{ $data->product->product_name }}
                                            </td>
                                            <td>
                                                {{ number_format($data->product->price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                {{ $data->status->status_name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
