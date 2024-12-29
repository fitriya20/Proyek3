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

        <div cl ass="top-fixed line"></div>
        <div class="container">
            <div class="title mt-5 ms-5 ">
                <span>Data Driver</span>
            </div>

            <div class="content-body mt-5 px-5">
                <div class="mt-3">
                    <h3>List Driver</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        Add Driver
                        <i data-feather="plus-circle"></i>
                    </button>

                    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Driver</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.driver.store') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name">Driver Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                autocomplete="off">
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

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Driver Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($drivers as $data)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            <div class="action d-flex justify-content-center">
                                                <form action="{{ route('admin.driver.delete', $data->id) }}" method="POST">
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
                                                    <h5 class="modal-title">Edit Driver</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.driver.edit', $data->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="name">Driver Name</label>
                                                            <input type="text" id="name" name="name"
                                                                class="form-control" value="{{ $data->name }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
