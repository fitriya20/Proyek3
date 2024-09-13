<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\Jadwal;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Beranda - Obatin";
        $active = "beranda";
        return view('dashboard.index', compact('title', 'active'));
    }

    public function user($level)
    {
        $title = ($level == 'dokter') ? "Manage Dokter - Obatin" : "Manage Pasien - Obatin";
        $active = $level;
        $users = User::where('level', $level)->get();        
        return view('user.index', compact('title', 'active', 'users' ,'level'));
    }
    public function dokter()
    {
        $title = "Data Dokter - Obatin";
        $active = "dokter";
        $users = User::where('level', $active)->get();        
        return view('dokter.index', compact('title', 'active', 'users'));
    }

    public function jadwal()
    {

        $title = "Manage Jadwal Checkup - Obatin";
        $active = "jadwal";
        if (auth()->user()->level == "admin") {
            $jadwal = Jadwal::join('users', 'jadwal.id_user', '=','users.id_user')->get();
        } else {
            $jadwal = Jadwal::join('users', 'jadwal.id_user', '=','users.id_user')->where("jadwal.id_user",auth()->user()->id_user)->get();            
        }
        
        $pasien = User::where('level', 'pasien')->orderBy('nama', 'ASC')->get();
        $dokter = User::where('level', 'dokter')->orderBy('nama', 'ASC')->get();
        return view('jadwal.index', compact('title', 'pasien' ,'jadwal' ,'dokter','active'));
    }
    public function alarm()
    {
        $title = "Manage Jadwal Minum Obat - Obatin";
        $active = "alarm";
        $pasien = User::where('level', 'pasien')->orderBy('nama', 'ASC')->get();
        $obat = Obat::all();
        $data = "";       
        if (auth()->user()->level == "admin") {
            $alarm = Alarm::join('users', 'alarm.id_user', '=','users.id_user')->join('obat', 'alarm.id_obat', '=','obat.id_obat')->groupBy('kode_alarm')->get();
            foreach ($alarm as $value) {
                $kd = $value->kode_alarm;            
            $data .= "
                <tr id='tr_".$kd."'>
                    <td class='align-middle'>$value->nama</td>                                
                    <td class='align-middle'>$value->nama_obat</td>                                
                    <td class='align-middle'>$value->dosis x sehari ($value->aturan)</td>                                
                    <td class='align-middle'>$value->aturan_tambahan</td>                                
                    <td class='align-middle'>
                        <a href='javascript:void[0]' data-kd='$kd' id='btn_time' class='btn p-2 btn_time  btn-sm text-white rounded-sm btn-success mr-1'><i class='ti-time'></i></a>
                        <a href='javascript:void[0]' data-kd='$kd' id='btn_edit' class='btn p-2 btn_edit  btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                        <a href='javascript:void[0]' data-kd='$kd' id='btn_delete' class='btn btn_delete btn-sm p-2 rounded-sm btn-danger'><i class='ti-trash'></i></a>
                    </td>
                </tr>
                ";
            }
        } else {
            $alarm = Alarm::join('users', 'alarm.id_user', '=','users.id_user')->join('obat', 'alarm.id_obat', '=','obat.id_obat')->where('alarm.id_user', auth()->user()->id_user)->groupBy('kode_alarm')->get();
            foreach ($alarm as $value) {
                $kd = $value->kode_alarm;            
            $data .= "
                <tr id='tr_".$kd."'>
                    <td class='align-middle'>$value->nama_obat</td>                                
                    <td class='align-middle'>$value->dosis x sehari ($value->aturan)</td>                                
                    <td class='align-middle'>$value->aturan_tambahan</td>                                
                    <td class='align-middle'>
                        <a href='javascript:void[0]' data-kd='$kd' id='btn_time' class='btn p-2 btn_time  btn-sm text-white rounded-sm btn-success mr-1'><i class='ti-time'></i></a>
                    </td>
                </tr>
                ";
            }
        }
         
       
        return view('alarm.index', compact('title', 'pasien', 'obat' ,'active', 'data'));
    }
    public function obat()
    {
        $title = "Manage Obat - Obatin";
        $active = "obat";
        $obat = Obat::all();
        return view('obat.index', compact('title', 'obat' ,'active'));
    }
}
