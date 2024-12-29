@extends('admin.index')
@section('content')
    <div class="content col-md-10">
        <div class="top-fixed line"></div>
        <div class="container">
            <div class="title mt-5 ms-5">
                <span>Data Category</span>
            </div>
            <div class="content-body mt-5 px-5">
                <!-- Modal Untuk Tambah Produk -->
                <div class="modal" id="addCategoryModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.category.store') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <label for="categories_name">Name Categories</label>
                                        <input type="text" id="categories_name" name="categories_name"
                                            class="form-control" autocomplete="off">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="simpan">Save</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <h3>List Category</h3>
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addCategoryModal">
                        Add Category
                        <i data-feather="plus-circle"></i>
                    </button> --}}
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name Categories</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->categories_name }}</td>
                                    </tr>

                                    <div class="modal" id="editCategoryModal{{ $data->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div>
                                                            <label for="categories_name">Name Categories New</label>
                                                            <input type="text" id="categories_name"
                                                                name="categories_name" class="form-control"
                                                                value="{{ $data->categories_name }}" autocomplete="off">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
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
