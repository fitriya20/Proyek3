@extends('layouts.index')
@section('content')
    <div class="card shadow-sm  rounded-sm">
        <h4 class="card-header bg-white text-center">Data Obat-Obatan</h4>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="javascript:void[0]" id="btn-add" class="btn btn-success rounded-sm btn-sm px-4 font-weight-bold">Tambah Obat</a>
            </div>
            <div class="alert alert-success my-3 d-none text-center font-weight-bold"></div>
            <div class="table-responsive my-3">
                <table class="table table-striped text-center" id="table-obat">
                    <thead>
                        <th class="align-middle">Nama Obat</th>
                        <th class="align-middle">Bentuk Obat</th>
                        <th class="align-middle">Kedaluwarsa</th>
                        <th class="align-middle">Opsi</th>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($obat as $key => $value)
                            <tr id="tr_{{ $value->id_obat }}">
                                <td class="align-middle">{{ $value->nama_obat }}</td>
                                <td class="align-middle">{{ $value->bentuk_obat }}</td>
                                <td class="align-middle">{{ date('d M Y', strtotime($value->kedaluwarsa)) }}</td>
                                <td class="align-middle">
                                    <a href="javascript:void[0]" onclick="show('{{ $value->id_obat }}')" id="btn_edit" class="btn p-2  btn-sm text-white rounded-sm btn-secondary mr-1"><i class="ti-pencil-alt"></i></a>
                                    <a href="javascript:void[0]" onclick="deleteConfirm('{{ $value->id_obat }}')"  id="btn_delete" class="btn btn-sm p-2 rounded-sm btn-danger"><i class="ti-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-obat" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="" class="form-label">Nama Obat</label>
                    <input type="text" id="nama" placeholder="Nama" class="form-control form-control-sm">
                    <div class="invalid-feedback nama"></div>
                </div>
                <div class="form-group mb-2">
                    <label for="" class="form-label">Bentuk Obat</label>
                    <select id="bentuk" class="form-control form-control-sm">
                        <option value="">--Pilih bentuk obat--</option>
                        <option value="Pill">Pill</option>
                        <option value="Tablet">Tablet</option>
                        <option value="Pulvis">Pulvis</option>
                        <option value="Pulveres">Pulveres</option>
                        <option value="Kapsul">Kapsul</option>
                        <option value="Kaplet">Kaplet</option>
                        <option value="Larutan">Larutan</option>
                        <option value="Suspensi">Suspensi</option>
                    </select>
                    <div class="invalid-feedback bentuk"></div>
                </div>
                <div class="form-group mb-2">
                    <label for="" class="form-label">Tanggal Kedaluwarsa</label>
                    <input type="date" id="tanggal" class="form-control form-control-sm">
                    <div class="invalid-feedback tanggal"></div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" onclick="" id="btn-save" class="btn btn-sm rounded-sm btn-primary">Save changes</button>
            <button type="button" class="btn btn-sm rounded-sm text-white btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
  </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#btn-add").click(() => {
                nama.value = ""
                tanggal.value = ""
                $("#bentuk").val("")
                $("#nama").removeClass('is-invalid')
                $("#tanggal").removeClass('is-invalid')
                $("#bentuk").removeClass('is-invalid')
                $('#modal-obat').modal('show')
                $("#btn-save").attr("onclick", "addObat()")
                $(".modal-title").text('Tambah Data Obat')
            })

            $("#table-obat").dataTable({
                ordering:false,
                searching:false
            })
        })
        

        function addObat() {
            $("#nama").removeClass('is-invalid')
                    $("#tanggal").removeClass('is-invalid')
                    $("#bentuk").removeClass('is-invalid')
            var data_obat = new FormData()
            data_obat.append("nama", document.getElementById("nama").value)
            data_obat.append("bentuk", document.getElementById("bentuk").value)
            data_obat.append("tanggal", document.getElementById("tanggal").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST","{{ route('obat.store') }}", true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                   
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {
                        nama.value = ""
                        tanggal.value = ""
                        $("#bentuk").val("")                        
                        $("#btn-save").text("Save Changes")       
                        $("#modal-obat").modal("hide")  
                        if (responses.count == 1) {
                            $("#table-body").html(responses.data)      
                        }else{
                            var html = $("#table-body").html()                            
                            html += responses.data
                            $("#table-body").html(html)
                        }     
                        alert_success(responses.message)   
                    } else {
                        printMsg(responses.error)
                    }
                }
            }
            xhttp.send(data_obat);

        }
        function editObat(id) {
            $("#nama").removeClass('is-invalid')
                    $("#tanggal").removeClass('is-invalid')
                    $("#bentuk").removeClass('is-invalid')
            var data_obat = new FormData()           
            data_obat.append("nama", document.getElementById("nama").value)
            data_obat.append("bentuk", document.getElementById("bentuk").value)
            data_obat.append("tanggal", document.getElementById("tanggal").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST",`edit-obat/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {                        
                        $("#btn-save").text("Save Changes")       
                        $("#modal-obat").modal("hide") 
                        $(`#tr_${id}`).html((responses.data))  
                        alert_success(responses.message)   
                    } else {
                        printMsg(responses.error)
                    }
                }
            }
            xhttp.send(data_obat);

        }

        function show(id) {
            $("#nama").removeClass('is-invalid')
                    $("#tanggal").removeClass('is-invalid')
                    $("#bentuk").removeClass('is-invalid')
            nama.value = ""
            tanggal.value = ""
            $("#bentuk").val("")
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST", `show-obat/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {                            
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    nama.value = responses.data.nama_obat
                    tanggal.value = responses.data.kedaluwarsa
                    $("#bentuk").val(responses.data.bentuk_obat)
                    $(".modal-title").text('Edit Data Obat')
                    $("#btn-save").attr(`onclick`, `editObat(${responses.data.id_obat})`)
                    $("#modal-obat").modal('show')
                }
            }
            xhttp.send();
        }
        function deleteData(id) { 
            var xhttp = new XMLHttpRequest()
            xhttp.open("DELETE", `delete-obat/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {                
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    $("#btn-delete-modals").attr(`onclick`, "")
                    $("#modal-confirm").modal('hide')
                    if (responses.count == 0) {
                        $("#table-body").html(`
                            <tr class="odd">
                                <td valign="top" colspan="4" class="dataTables_empty">No data available in table</td>
                            </tr>
                        `)
                    }
                    alert_success(responses.message)   
                    $(`#tr_${responses.id}`).remove()
                }
            }
            xhttp.send();
        }

        function deleteConfirm(id) {
            $("#btn-delete-modals").attr('onclick', `deleteData(${id})`)
            $("#modal-confirm").modal('show')
        }


    </script>
@endsection