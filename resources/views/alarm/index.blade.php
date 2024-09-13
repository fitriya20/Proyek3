@extends('layouts.index')
@section('content')
    <div class="card shadow-sm  rounded-sm">
        <h4 class="card-header bg-white text-center">Data {{ Auth::user()->level == "admin" ? "Jadwal" : "Riwayat" }} Minum Obat</h4>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                {!! Auth::user()->level == "admin" ? '<a href="javascript:void[0]" id="btn-add" class="btn btn-success rounded-sm btn-sm px-4 font-weight-bold">Tambah Jadwal Minum Obat</a>' : '' !!}
            </div>
            <div class="alert alert-success my-3 {{ session('success') ? 'd-block' : 'd-none' }} text-center font-weight-bold">{{ session('success') ? session('success') : ''  }}</div>
            <div class="table-responsive my-3">
                <table class="table table-striped text-center" id="table-user">
                    <thead>
                        {!! Auth::user()->level == "admin" ? '<th class="align-middle">Nama Pasien</th>' : '' !!}
                        <th class="align-middle">Nama Obat</th>
                        <th class="align-middle">Dosis</th>
                        <th class="align-middle">Aturan Tambahan</th>
                        <th class="align-middle">Opsi</th>
                    </thead>
                    <tbody id="table-body">                        
                        {!! $data !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('modals')
    <div class="modal fade" id="modal-alarm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-capitalize"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body row">
                <div class="form-group mb-2 col-12">
                    <label for="" class="form-label">Pilih Pasien</label>
                    <select id="pasien" class="form-control form-control-sm">
                        <option value="">--Pilih Pasien--</option>
                        @foreach ($pasien as $item)
                            <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback pasien"></div>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
                <div class="form-group mb-2 col-12">
                    <label for="" class="form-label">Pilih Obat</label>
                    <select id="obat" class="form-control form-control-sm">
                        <option value="">--Pilih Obat--</option>
                        @foreach ($obat as $item)
                            <option value="{{ $item->id_obat }}">{{ $item->nama_obat }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback obat"></div>
                </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
                <div class="form-group mb-2 col-lg-7 col-12">
                    <label for="" class="form-label">Waktu Pengingat</label>
                    <input type="time" value="{{ date("H:i") }}" id="waktu" class="form-control form-control-sm">
                    <div class="invalid-feedback waktu"></div>
                </div>                                                                                                                                                                           
                <div class="form-group mb-2 col-lg-5 col-12">
                    <label for="" class="form-label">Dosis</label>
                    <div class="d-flex justify-content-between align-items-center">
                        <select class="form-control form-control-sm col-6" id="dosis">
                            <option value="2" selected>2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>                    
                        <h5 class="mb-0">X Sehari</h5>
                    </div>
                </div>                                                                                                                                                                           
                <div class="form-group mb-2 col-12">
                    <label for="" class="form-label">Aturan</label>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="aturan" id="sebelum" value="Sebelum Makan" checked>
                                Sebelum Makan
                              </label>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="aturan" id="sesudah" value="Sesudah Makan">
                                Sesudah Makan
                              </label>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="aturan" id="bersamaan" value="Bersamaan Makan">
                                Bersamaan Makan
                              </label>
                            </div>
                          </div>
                          <div class="col-12 col-lg-6">
                            <div class="form-check">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="aturan" id="tidak" value="Tidak Ada Ketentuan">
                                Tidak Ada Ketentuan
                              </label>
                            </div>
                          </div>
                    </div>
                </div>    
                
                <div class="form-group mb-2 col-12">
                    <label for="">Keterangan Tambahan</label>
                    <input type="text" id="aturan_tambahan" placeholder="Keterangan Tambahan" class="form-control form-control-sm">
                    <div class="invalid-feedback aturan_tambahan"></div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" onclick="" id="btn-save" class="btn btn-sm rounded-sm btn-primary">Save changes</button>
            <button type="button" class="btn btn-sm rounded-sm text-white btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="modal-time" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-capitalize"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped text-center">
                    <thead>
                        <th class="align-middle">No</th>
                        <th class="align-middle">Waktu</th>
                        {!! Auth::user()->level == "admin" ? '<th class="align-middle">Edit Waktu</th>' : '' !!}                       
                    </thead>
                    <tbody id="table_time"></tbody>                    
                </table>
            </div>
            <div class="modal-footer">
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
                $("#obat").removeClass('is-invalid')
                $("#pasien").val("")
                $("#obat").val("")
                $("input#sebelum").prop("checked", true)
                waktu.value = "{{ date('H:i') }}"
                dosis.value = ""
                aturan_tambahan.value = ""
                $('#modal-alarm').modal('show')
                $("#btn-save").attr("onclick", "addJadwal()")
                $(".modal-title").text('Tambah Data Jadwal Checkup')
            })

            $("#table-user").dataTable({
                ordering:false,
            })

            $(".btn_time").click(function() {
                var kd_alarm = $(this).data('kd')
                $("#table_time").html("")
                var xhttp = new XMLHttpRequest()
                xhttp.open("POST",`/show-time/${kd_alarm}`, true);
                xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                xhttp.onreadystatechange = function () {                
                    if (this.readyState == 4 && this.status == 200) {
                        var responses = JSON.parse(this.responseText)
                        if (responses.success == true) {     
                            $("#table_time").html(responses.data)
                            $('#modal-time').modal('show')                          
                        }
                    }
                }
                xhttp.send();
            })

            $(".btn_edit").click(function() {
                var id = $(this).data('kd')
                $("#pasien").removeClass('is-invalid')
                $("#obat").removeClass('is-invalid')
                $("#dosis").removeClass('is-invalid')
                $("#aturan_tambahan").removeClass('is-invalid')
                var xhttp = new XMLHttpRequest()
                xhttp.open("POST", `/show-alarm/${id}`, true);
                xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
                xhttp.onreadystatechange = function () {                            
                    if (this.readyState == 4 && this.status == 200) {
                        var responses = JSON.parse(this.responseText)
                        $("#pasien").val(`${responses.data.id_user}`)
                        $("#obat").val(`${responses.data.id_obat}`)
                        $("#dosis").val(`${responses.data.dosis}`)
                        $("#waktu").val(`${responses.data.waktu}`)
                        $("#aturan_tambahan").val(`${responses.data.aturan_tambahan}`)
                        $(`input[name="aturan"][value="${responses.data.aturan}"]`).attr("checked", true)
                        $(".modal-title").text(`Edit Data Alarm`)
                        $("#btn-save").attr(`onclick`, `editAlarm("${responses.data.kode_alarm}")`)
                        $("#modal-alarm").modal('show')
                    }
                }
                xhttp.send();
            })

            $(".btn_delete").click(function() {
                var id = $(this).data('kd')
                console.log(id);
                $("#btn-delete-modals").attr('onclick', `deleteData("${id}")`)
                $("#modal-confirm").modal('show')
            })

        })                        
                
        function addJadwal() {
            $("#pasien").removeClass('is-invalid')
            $("#obat").removeClass('is-invalid')
            $("#dosis").removeClass('is-invalid')
            $("#aturan_tambahan").removeClass('is-invalid')
            var data_alarm = new FormData()
            data_alarm.append("pasien", document.getElementById("pasien").value)
            data_alarm.append("obat", document.getElementById("obat").value)
            data_alarm.append("dosis", document.getElementById("dosis").value)
            data_alarm.append("waktu", document.getElementById("waktu").value)
            data_alarm.append("aturan", document.querySelector('input[name="aturan"]:checked').value)
            data_alarm.append("aturan_tambahan", document.getElementById("aturan_tambahan").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST","{{ route('alarm.store') }}", true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {                   
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {     
                        $('#modal-alarm').modal('hide')
                        alert_success(responses.message)
                        setTimeout(() => {
                            window.location.reload()
                        }, 1000);   
                    } else {
                        printMsg(responses.error)
                    }
                }
            }
            xhttp.send(data_alarm);

        }
        

        function editAlarm(id) {
            $("#pasien").removeClass('is-invalid')
            $("#obat").removeClass('is-invalid')
            $("#dosis").removeClass('is-invalid')
            $("#aturan_tambahan").removeClass('is-invalid')
            var data_alarm = new FormData()
            data_alarm.append("pasien", document.getElementById("pasien").value)
            data_alarm.append("obat", document.getElementById("obat").value)
            data_alarm.append("dosis", document.getElementById("dosis").value)
            data_alarm.append("waktu", document.getElementById("waktu").value)
            data_alarm.append("aturan", document.querySelector('input[name="aturan"]:checked').value)
            data_alarm.append("aturan_tambahan", document.getElementById("aturan_tambahan").value)
            var xhttp = new XMLHttpRequest()
            xhttp.open("POST",`/edit-alarm/${id}`, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {                    
                    $("#btn-save").text("Loading...")
                }
                if (this.readyState == 4 && this.status == 200) {
                    var responses = JSON.parse(this.responseText)
                    if (responses.success == true) {                        
                        $("#btn-save").text("Save Changes")   
                        $('#modal-alarm').modal('hide')
                        alert_success(responses.message)  
                        setTimeout(() => {
                            window.location.reload()
                        }, 1000); 
                    } else {
                        printMsg(responses.error)
                    }
                }
            }
            xhttp.send(data_alarm);

        }   

        function deleteData(id) { 
            console.log(id);
            var xhttp = new XMLHttpRequest()
            xhttp.open("DELETE", `/delete-alarm/${id}`, true);
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



    </script>
@endsection