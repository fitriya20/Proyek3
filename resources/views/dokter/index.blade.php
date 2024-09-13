@extends('layouts.index')
@section('content')
    <div class="card shadow-sm  rounded-sm">
        <h4 class="card-header bg-white text-center">Data Dokter</h4>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="javascript:void[0]" id="btn-add" class="btn btn-success rounded-sm btn-sm px-4 font-weight-bold">Tambah Dokter</a>
            </div>
            <div class="alert alert-success my-3 d-none text-center font-weight-bold"></div>
            <div class="table-responsive my-3">
                <table class="table table-striped text-center" id="table-user">
                    <thead>
                        <th class="align-middle">Nama User</th>
                        <th class="align-middle">No Whatsapp</th>
                        <th class="align-middle">Opsi</th>
                    </thead>
                    <tbody id="table-body">
                        @foreach ($users as $key => $value)
                            <tr id="tr_{{ $value->id_user }}">
                                <td class="align-middle">{{ $value->nama }}</td>
                                <td class="align-middle">{{ $value->no_whatsapp }}</td>                                
                                <td class="align-middle">
                                    <a href="javascript:void[0]" onclick="show('{{ $value->id_user }}')" id="btn_edit" class="btn p-2  btn-sm text-white rounded-sm btn-secondary mr-1"><i class="ti-pencil-alt"></i></a>
                                    <a href="javascript:void[0]" onclick="deleteConfirm('{{ $value->id_user }}')"  id="btn_delete" class="btn btn-sm p-2 rounded-sm btn-danger"><i class="ti-trash"></i></a>
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
    <div class="modal fade" id="modal-user" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-capitalize"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="" class="form-label">Nama Dokter</label>
                    <input type="text" id="nama" placeholder="Nama" class="form-control form-control-sm">
                    <div class="invalid-feedback nama"></div>
                </div>                                                                             
                <div class="form-group mb-2">
                    <label for="" class="form-label">Nomor Whatsapp</label>
                    <input type="text" id="no_whatsapp" placeholder="Nomor Whatsapp" class="form-control form-control-sm">
                    <div class="invalid-feedback no_whatsapp"></div>
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
                no_whatsapp.value = ""
                $("#nama").removeClass('is-invalid')
                $("#no_whatsapp").removeClass('is-invalid')
                $('#modal-user').modal('show')
                $("#btn-save").attr("onclick", "addUser('dokter')")
                $(".modal-title").text('Tambah Data Dokter')
            })

            $("#table-user").dataTable({
                ordering:false,
                searching:false
            })
        })
        

        function addUser(level) {
            $("#nama").removeClass('is-invalid')
            $("#no_whatsapp").removeClass('is-invalid')
            var data_user = new FormData()
            data_user.append("nama", document.getElementById("nama").value)
            data_user.append("level", level)
            data_user.append("no_whatsapp", document.getElementById("no_whatsapp").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST","{{ route('user.store') }}", true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {                   
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {
                        nama.value = ""
                        no_whatsapp.value = ""                                               
                        $("#btn-save").text("Save Changes")       
                        $("#modal-user").modal("hide")  
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
            xhttp.send(data_user);

        }
        function editUser(id, level) {
            $("#nama").removeClass('is-invalid')
            $("#no_whatsapp").removeClass('is-invalid')
            var data_user = new FormData()
            data_user.append("nama", document.getElementById("nama").value)
            data_user.append("level", level)
            data_user.append("no_whatsapp", document.getElementById("no_whatsapp").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST",`/edit-user/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {                        
                        $("#btn-save").text("Save Changes")       
                        $("#modal-user").modal("hide") 
                        $(`#tr_${id}`).html((responses.data))  
                        alert_success(responses.message)   
                    } else {
                        printMsg(responses.error)
                    }
                }
            }
            xhttp.send(data_user);

        }

        function show(id) {
            $("#nama").removeClass('is-invalid')
            $("#no_whatsapp").removeClass('is-invalid')
            nama.value = ""
            no_whatsapp.value = ""      
            
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST", `/show-user/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {                            
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    nama.value = responses.data.nama
                    no_whatsapp.value = responses.data.no_whatsapp 
                    var level = (responses.data.level == "dokter") ? "dokter" : "pasien"
                    $(".modal-title").text(`Edit Data ${level}`)
                    $("#btn-save").attr(`onclick`, `editUser("${responses.data.id_user}", "${level}")`)
                    $("#modal-user").modal('show')
                }
            }
            xhttp.send();
        }
        function deleteData(id) { 
            var xhttp = new XMLHttpRequest()
            xhttp.open("DELETE", `/delete-user/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {                
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    $("#btn-delete-modals").attr(`onclick`, "")
                    $("#modal-confirm").modal('hide')
                    if (responses.count == 0) {
                        $("#table-body").html(`
                            <tr class="odd">
                                <td valign="top" colspan="3" class="dataTables_empty">No data available in table</td>
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