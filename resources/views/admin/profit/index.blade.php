@extends('admin.index')
@section('content')
    <div class="content col-md-10">
        <div class="container">
            <div class="title mt-5 ms-5">
                <span>Monthly Profit Report</span>
            </div>
            <div class="content-body mt-5">

                <div>
                    <div>
                        <form method="GET" action="{{ route('admin.profit') }}" class="mb-4">
                            @csrf
                            <div class="d-flex align-items-end gap-2">
                                <div>
                                    <label for="selected_month" class="form-label">Select Month:</label>
                                    <select name="selected_month" id="selected_month" class="form-select">
                                        <option value="">Select Month</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}"
                                                {{ isset($selected_month) && $selected_month == $m ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="selected_year" class="form-label">Select Year:</label>
                                    <select name="selected_year" id="selected_year" class="form-select">
                                        <option value="">Select Year</option>
                                        @for ($y = date('Y'); $y >= 2000; $y--)
                                            <option value="{{ $y }}"
                                                {{ isset($selected_year) && $selected_year == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" name="filter_profits" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <a href="{{route('admin.export')}}" class="btn btn-primary">
                            Export
                        </a>
                    </div>
                </div>

                @if ($orders->isEmpty())
                    <div class="alert alert-info">
                        No orders available.
                    </div>
                @else
                    <div class="mt-2 px-4">
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Driver</th>
                                        <th>Address</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Time Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->users->name }}</td>
                                            <td>{{ $data->users->email }}</td>
                                            <td>{{ str_replace('0', '+62', $data->users->no_telp) }}</td>
                                            <td>{{ $data->driver->name }}</td>
                                            <td>{{ $data->address }}</td>
                                            <td>{{ $data->product->product_name }}</td>
                                            <td>{{ number_format($data->product->price, 0, ',', '.') }}</td>
                                            <td>{{ $data->order_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <div class="mt-2 px-4">
                    @if (isset($total_profit))
                        <h3>Total :</h3>
                        <p>Rp {{ number_format($total_profit, 0, ',', '.') }}</p>
                    @else
                        <p>Tidak ada data keuntungan untuk bulan yang dipilih.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
