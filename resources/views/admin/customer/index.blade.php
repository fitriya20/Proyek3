@extends('admin.index')
@section('content')
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title mt-5 ms-5">
                <span>Data Customer</span>
            </div>
            <div class="content-body mt-5">
                <div class="mt-2 px-4">
                    <h3>List Customer</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Users</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.customer.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="form-label">Name</label>
                                            <input type="text" class="form-control" name="name">
                                        </div>
                                        <div class="mb-2">
                                            <label for="form-label">Email</label>
                                            <input type="email" class="form-control" name="email">
                                        </div>
                                        <div class="mb-2">
                                            <label for="form-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <div class="mb-2">
                                            <label for="form-label">Phone</label>
                                            <input type="text" class="form-control" name="no_telp">
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->no_telp }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $data->id }}">
                                                    Edit
                                                </button>

                                                <form action="{{ route('admin.customer.delete', $data->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Users
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('admin.customer.update', $data->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-2">
                                                                    <label for="form-label">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        value="{{ $data->name }}" name="name">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="form-label">Email</label>
                                                                    <input type="email" class="form-control" disabled
                                                                        name="email" value="{{ $data->email }}">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="form-label">Password</label>
                                                                    <input type="password" class="form-control" disabled
                                                                        name="password">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label for="form-label">Phone</label>
                                                                    <input type="text" class="form-control"
                                                                        name="no_telp" value="{{ $data->no_telp }}">
                                                                </div>
                                                                <div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
