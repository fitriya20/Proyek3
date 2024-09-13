<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\Obat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlarmController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'pasien' => 'required',
            'obat' => 'required',
            'aturan_tambahan' => 'required',
            'dosis' => 'required|numeric',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            $waktu = $request->waktu;
            if ($request->dosis == 2) {
                $hours = 12;
            }else if ($request->dosis == 3) {
                $hours = 8;
            }else if ($request->dosis == 4) {
                $hours = 6;
            }
            for ($i=1; $i <= $request->dosis ; $i++) {                                 
                if ($i != 1) {
                    $waktu_next = date('H:i', strtotime($waktu." + $hours hours"));
                    $waktu = $waktu_next;
                }
                Alarm::create([
                    'id_user' => $request->pasien,
                    'id_obat' => $request->obat,
                    'waktu' => $waktu,
                    'kode_alarm' => date('dmYHis').$request->pasien,
                    'aturan' => $request->aturan,
                    'dosis' => $request->dosis,
                    'aturan_tambahan' => $request->aturan_tambahan,
                ]);                            
            }
            return response()->json(['success' => true, 'message' => 'Berhasil menambah data jadwal minum obat'], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    public function showTime($kd_alarm)
    {
        $data = "";
        if (auth()->user()->level == "admin") {
            $alarm = Alarm::where("kode_alarm", $kd_alarm)->get();
            foreach ($alarm as $key => $value) {
                $data .= '
                <tr>
                    <td class="align-middle">'.++$key.'</td>
                    <td class="align-middle" id="waktu_'.$value->id_alarm.'">'.$value->waktu.'</td>
                    <td class="align-middle">
                        <form action="'.route("alarm.edittime", $value->id_alarm).'" method="post" class="d-flex justify-content-center">                        
                            <input type="time" value="'.$value->waktu.'" name="waktu" id="waktu_'.$value->id_alarm.'" class="form-control form-control-sm">                    
                            <input type="hidden" value="'.csrf_token().'" name="_token">                    
                            <button type="submit" id="btn_edit_time" class="btn btn_edit_time ml-2 py-2 px-3  btn-sm text-white rounded-sm btn-secondary mr-1"><i class="ti-arrow-right"></i></button>
                        </form>
                    </td>                
                </tr>
                ';
            }
        } else {
            $alarm = Alarm::where("kode_alarm", $kd_alarm)->where("id_user", Auth::user()->id_user)->get();
            foreach ($alarm as $key => $value) {
                $data .= '
                <tr>
                    <td class="align-middle">'.++$key.'</td>
                    <td class="align-middle" id="waktu_'.$value->id_alarm.'">'.$value->waktu.'</td>                                    
                </tr>
                ';
            }
        }
        
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function editTime(Request $request,Alarm $alarm)
    {
        $alarm->update([
            'waktu' => $request->waktu
        ]);
        return redirect(route("alarm"))->with("success", "Berhasil memperbaharui waktu alarm");
    }
   
    public function show($kode)
    {   
        $alarm = Alarm::where("kode_alarm", $kode)->first();
        return response()->json(['success' => true, 'data' => $alarm], 200);        
    }

    public function edit(Request $request, $kd)
    {
        $rules = [
            'pasien' => 'required',
            'obat' => 'required',
            'aturan_tambahan' => 'required',
            'dosis' => 'required|numeric',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            $alarm = Alarm::where("kode_alarm", $kd)->first();
            if ($request->dosis == $alarm->dosis) {
                Alarm::where('kode_alarm', $kd)->update([
                    'id_user' => $request->pasien,
                    'id_obat' => $request->obat,
                    'aturan' => $request->aturan,
                    'aturan_tambahan' => $request->aturan_tambahan,
                ]); 
            }else{
                $waktu = $request->waktu;
                if ($request->dosis == 2) {
                    $hours = 12;
                }else if ($request->dosis == 3) {
                    $hours = 8;
                }else if ($request->dosis == 4) {
                    $hours = 6;
                }
                Alarm::where("kode_alarm", $kd)->delete();
                for ($i=1; $i <= $request->dosis ; $i++) {                                 
                    if ($i != 1) {
                        $waktu_next = date('H:i', strtotime($waktu." + $hours hours"));
                        $waktu = $waktu_next;
                    }
                    Alarm::create([
                        'id_user' => $request->pasien,
                        'id_obat' => $request->obat,
                        'waktu' => $waktu,
                        'kode_alarm' => $kd,
                        'aturan' => $request->aturan,
                        'dosis' => $request->dosis,
                        'aturan_tambahan' => $request->aturan_tambahan,
                    ]);                            
                }
            }
            return response()->json(['success' => true, 'message' => 'Berhasil memperbaharui jadwal minum obat'], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }   

    public function destroy($kd)
    {        
        Alarm::where("kode_alarm", $kd)->delete();
        $count = Alarm::groupBy('kode_alarm')->count();
        return response()->json(['success' => true, 'id' => $kd, 'count' => $count, 'message' => 'Berhasil menghapus data jadwal minum obat'], 200);
    }
}
