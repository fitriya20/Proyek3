@extends('layouts.index')
@section('content')
    <div class="card shadow-sm  rounded-sm">
        <h4 class="card-header bg-white text-center">Data {{ auth()->user()->level == "admin" ? "Jadwal" : "Riwayat" }} Checkup</h4>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                @if (auth()->user()->level == "admin")
                <a href="javascript:void[0]" id="btn-add" class="btn btn-success rounded-sm btn-sm px-4 font-weight-bold">Tambah Jadwal Checkup</a>                    
                @else
                @endif
            </div>
            <div class="alert alert-success my-3 d-none text-center font-weight-bold"></div>
            <div class="table-responsive my-3">
                <table class="table table-striped text-center" id="table-user">
                    <thead>
                        <th class="align-middle">Tanggal Checkup</th>
                        <th class="align-middle">Waktu Checkup</th>
                        {!! auth()->user()->level == "admin" ? '<th class="align-middle">Nama Pasien</th>' : '' !!}
                        <th class="align-middle">Nama Dokter</th>
                        <th class="align-middle">Status</th>
                        {!! auth()->user()->level == "admin" ? '<th class="align-middle">Opsi</th>' : '' !!}
                    </thead>
                    <tbody id="table-body">
                        @foreach ($jadwal as $key => $value)
                            <tr id="tr_{{ $value->id_jadwal }}">
                                <td class="align-middle">{{ date("d M Y", strtotime($value->waktu_check)) }}</td>
                                <td class="align-middle">{{ date("H:i", strtotime($value->waktu)) }}</td>
                                {!! Auth::user()->level == "admin" ? '<td class="align-middle">'.$value->nama.'</td>' : '' !!}
                                <td class="align-middle">{{ $value->nama_dokter }}</td>                                
                                <td class="align-middle">{!! (date("d M Y", strtotime($value->waktu_check)) < date("d M Y") && date("H:i", strtotime($value->waktu)) < date("H:i")) ? '<span class="badge text-white bg-danger">Passed</span>' : '<span class="badge text-white bg-success">OnGoing</span>' !!}</td>
                                @if (auth()->user()->level == "admin")
                                <td class="align-middle">
                                    <a href="javascript:void[0]" onclick="show('{{ $value->id_jadwal }}')" id="btn_edit" class="btn p-2  btn-sm text-white rounded-sm btn-secondary mr-1"><i class="ti-pencil-alt"></i></a>
                                    <a href="javascript:void[0]" onclick="deleteConfirm('{{ $value->id_jadwal }}')"  id="btn_delete" class="btn btn-sm p-2 rounded-sm btn-danger"><i class="ti-trash"></i></a>
                                </td>                                    
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-jadwal" tabindex="-1" role="dialog">
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
                    <label for="" class="form-label">Pilih Pasien</label>
                    <select id="pasien" class="form-control form-control-sm">
                        <option value="">--Pilih Pasien--</option>
                        @foreach ($pasien as $item)
                            <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback pasien"></div>
                </div>                                                                                                                                                                                                                                                                                                                                                                     
                <div class="form-group mb-2">
                    <label for="" class="form-label">Pilih Dokter</label>
                    <select id="nama" class="form-control form-control-sm">
                        <option value="">--Pilih Dokter--</option>
                        @foreach ($dokter as $item)
                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback nama"></div>
                </div>                                                                                                                                                                                                                                                                                                                                                                     
                <div class="form-group mb-2">
                    <label for="" class="form-label">Tanggal Checkup</label>
                    <input type="date" value="{{ date("Y-m-d H:i") }}" id="tanggal" class="form-control form-control-sm">
                    <div class="invalid-feedback tanggal"></div>
                </div>                                                                                                                                                                           
                <div class="form-group mb-2">
                    <label for="" class="form-label">Waktu Checkup</label>
                    <input type="time" value="{{ date("H:i") }}" id="waktu" class="form-control form-control-sm">
                    <div class="invalid-feedback waktu"></div>
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
                $("#pasien").removeClass('is-invalid')
                $("#nama").removeClass('is-invalid')
                $("#pasien").val("")
                $("#nama").val("")
                $("#tanggal").val("{{ date('Y-m-d H:i') }}")
                $('#modal-jadwal').modal('show')
                $("#btn-save").attr("onclick", "addJadwal()")
                $(".modal-title").text('Tambah Data Jadwal Checkup')
            })

            $("#table-user").dataTable({
                ordering:false,
                searching:"{{ auth()->user()->level == 'admin' ? false : true }}"
            })
        })
        

        function addJadwal() {
            $("#nama").removeClass('is-invalid')
            $("#pasien").removeClass('is-invalid')
            var data_jadwal = new FormData()
            data_jadwal.append("nama", document.getElementById("nama").value)
            data_jadwal.append("pasien", document.getElementById("pasien").value)
            data_jadwal.append("tanggal", document.getElementById("tanggal").value)
            data_jadwal.append("waktu", document.getElementById("waktu").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST","{{ route('jadwal.store') }}", true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {                   
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {
                        $("#nama").val("")
                        $("#pasien").val("")
                        $("#tanggal").val("{{ date('Y-m-d H:i') }}")
                        $("#btn-save").text("Save Changes")       
                        $("#modal-jadwal").modal("hide")  
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
            xhttp.send(data_jadwal);

        }
        function editJadwal(id) {
            $("#nama").removeClass('is-invalid')
            $("#pasien").removeClass('is-invalid')
            var data_jadwal = new FormData()
            data_jadwal.append("nama", document.getElementById("nama").value)
            data_jadwal.append("pasien", document.getElementById("pasien").value)
            data_jadwal.append("tanggal", document.getElementById("tanggal").value)
            data_jadwal.append("waktu", document.getElementById("waktu").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST",`/edit-jadwal/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {                        
                        $("#btn-save").text("Save Changes")       
                        $("#modal-jadwal").modal("hide") 
                        $(`#tr_${id}`).html((responses.data))  
                        alert_success(responses.message)   
                    } else {
                        printMsg(responses.error)
                    }
                }
            }
            xhttp.send(data_jadwal);

        }

        function show(id) {
            $("#nama").removeClass('is-invalid')
            $("#pasien").removeClass('is-invalid')
            
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST", `/show-jadwal/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {                            
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    $("#pasien").val(responses.data.id_user)
                    $("#nama").val(responses.data.nama_dokter)
                    $("#tanggal").val(responses.data.waktu_check)
                    $("#waktu").val(responses.data.waktu)
                    $(".modal-title").text(`Edit Data Jadwal`)
                    $("#btn-save").attr(`onclick`, `editJadwal("${responses.data.id_jadwal}")`)
                    $("#modal-jadwal").modal('show')
                }
            }
            xhttp.send();
        }
        function deleteData(id) { 
            var xhttp = new XMLHttpRequest()
            xhttp.open("DELETE", `/delete-jadwal/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {                
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    $("#btn-delete-modals").attr(`onclick`, "")
                    $("#modal-confirm").modal('hide')
                    if (responses.count == 0) {
                        $("#table-body").html(`
                            <tr class="odd">
                                <td valign="top" colspan="5" class="dataTables_empty">No data available in table</td>
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