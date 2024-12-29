@extends('admin.index')
@section('content')
    <div class="content col-md-10">

        @if (Session('success'))
            <script>
                Swal.fire({
                    'title': 'Success!',
                    'text': '{{ session('success') }}',
                    'icon': 'success'
                });
            </script>
        @endif

        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title mt-5 ms-5 ">
                <span>Data Product</span>
            </div>

            <div class="content-body mt-5 px-5">
                <div class="modal" id="addProductModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.product.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="product_name">Nama</label>
                                        <input type="text" id="product_name" name="product_name" class="form-control"
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="categories_id">Categories</label>
                                        <select name="categories_id" id="categories_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->categories_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <input type="text" id="deskripsi" name="deskripsi" class="form-control"
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Price</label>
                                        <input type="number" id="price" name="price" class="form-control"
                                            autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Colse</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <h3>List Product</h3>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addProductModal">
                                Add Product
                                <i data-feather="plus-circle"></i>
                            </button>
                        </div>
                        <div>
                            <form action="{{ route('admin.product') }}" method="GET" class="mb-3">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search Product..."
                                        value="{{ request()->search }}">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Categories</th>
                                    <th>Deskripsi</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $data)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->product_name }}</td>
                                        <td>{{ $data->category->categories_name }}</td>
                                        <td>{{ $data->deskripsi ?? 'null' }}</td>
                                        <td>{{ number_format($data->price, 0, ',', '.') }}</td>
                                        <td><img src="{{ asset($data->image) ?? 'null' }}" style="width: 50px;"
                                                alt="{{ $data->product_name }}"></td>
                                        <td>
                                            <div class="action d-flex justify-content-center">
                                                <form action="{{ route('admin.product.delete', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn me-2" name="delete"><i
                                                            data-feather="trash-2"></i></button>
                                                </form>
                                                <button type="submit" class="btn ms-2" name="edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editProductModal{{ $data->id }}"><i
                                                        data-feather="edit"></i></button>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editProductModal{{ $data->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Produk</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.product.edit', $data->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="product_name">Name</label>
                                                            <input type="text" id="product_name" name="product_name"
                                                                class="form-control" value="{{ $data->product_name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="categories_id">Categories</label>
                                                            <select name="categories_id" id="categories_id"
                                                                class="form-control" required>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        {{ $category->id == $data->categories_id ? 'selected' : '' }}>
                                                                        {{ $category->categories_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="deskripsi">Deskripsi</label>
                                                            <input type="text" id="deskripsi" name="deskripsi"
                                                                value="{{ $data->deskripsi }}" class="form-control"
                                                                autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="price">Price</label>
                                                            <input type="text" id="price" name="price"
                                                                class="form-control" value="{{ $data->price }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="image">Image : </label>
                                                            <img src="{{ asset($data->image) ?? 'null' }}" width="50px"
                                                                alt="{{ $data->product_name }}">
                                                            <input type="file" name="image" id="image"
                                                                class="form-control" value="{{ $data->product_name }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
