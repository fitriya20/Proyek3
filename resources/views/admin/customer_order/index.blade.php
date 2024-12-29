@extends('admin.index')
@section('content')
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title mt-5 ms-5">
                <span>Data Order</span>
            </div>
            <div class="content-body mt-5">
                <div class="mt-2 px-4">
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Drivers</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->users->name }}</td>
                                        <td>{{ $data->users->email }}</td>
                                        <td>{{ str_replace('0', '+62', $data->users->no_telp) }}</td>
                                        <td>{{ $data->address }}</td>
                                        <td>{{ $data->driver->name ?? 'Tidak ada driver' }}</td>
                                        <td>{{ $data->product->product_name }}</td>
                                        <td>{{ number_format($data->product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            {{ $data->status->status_name }}
                                        </td>
                                        <td class="text-center w-5">
                                            <!-- Installation Date -->
                                            {{ $data->installation_date }}
                                        </td>

                                        <td class="text-center">
                                            <form method="post"
                                                action="{{ route('admin.customer-order-update', $data->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="update-status d-flex justify-content-start px-3">
                                                    <select name="status_id" class="form-select form-select-sm">
                                                        @foreach ($statuses as $status)
                                                            <option value="{{ $status->id }}"
                                                                {{ $data->status_id == $status->id ? 'selected' : '' }}>
                                                                {{ $status->status_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <!-- Add Installation Date Input -->
                                                    <input type="date" name="installation_date"
                                                        value="{{ $data->installation_date }}">
                                                    <button type="submit" name="update_status"
                                                        class="btn btn-outline-success btn-sm"><i
                                                            data-feather="check"></i></button>
                                                </div>
                                            </form>
                                        </td>
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
@endsection
