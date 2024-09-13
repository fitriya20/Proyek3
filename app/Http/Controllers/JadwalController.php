<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JadwalController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'pasien' => 'required',
            'nama' => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            Jadwal::create([
                'id_user' => $request->pasien,
                'nama_dokter' => $request->nama,
                'waktu_check' => $request->tanggal,
                'waktu' => $request->waktu,
                'waktu_pengingat' => $request->waktu,
            ]);
            $user = User::find($request->pasien);
            $jadwalCount = Jadwal::count();
            $maxID = Jadwal::max('id_jadwal');
            $badge = (date("d M Y H:i", strtotime($request->tanggal)) < date("d M Y H:i")) ? '<span class="badge text-white bg-danger">Passed</span>' : '<span class="badge text-white bg-success">OnGoing</span>';
            $tanggal = date("d M Y", strtotime($request->tanggal));
            $waktu = date("H:i", strtotime($request->waktu));
            $data = "
                <tr id='tr_$maxID'>
                    <td class='align-middle'>$tanggal</td>
                    <td class='align-middle'>$waktu</td>
                    <td class='align-middle'>$user->nama</td>
                    <td class='align-middle'>$request->nama</td>
                    <td class='align-middle'>$badge</td>
                    <td class='align-middle'>
                    <a href='javascript:void[0]' onclick='show($maxID)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                    <a href='javascript:void[0]' onclick='deleteConfirm($maxID)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                    </td>
                </tr>
            ";
            return response()->json(['success' => true, 'data' => $data, 'count' => $jadwalCount, 'message' => 'Berhasil menambah data jadwal checkup'], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    public function show(Jadwal $jadwal)
    {
        return response()->json(['success' => true, 'data' => $jadwal], 200);
    }

    public function edit(Request $request, Jadwal $jadwal)
    {
        $rules = [
            'nama' => 'required',
            'tanggal' => 'required',
            'pasien' => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            $user = User::find($request->pasien);
            $jadwal->update([
                'nama_dokter' => $request->nama,
                'id_user' => $request->pasien,
                'waktu_check' => $request->tanggal,
                'waktu' => $request->waktu,
                'waktu_pengingat' => $request->waktu,
            ]);
            $badge = (date("d M Y", strtotime($request->tanggal)) < date("d M Y") && date("H:i", strtotime($request->waktu)) < date("H:i")) ? '<span class="badge text-white bg-danger">Passed</span>' : '<span class="badge text-white bg-success">OnGoing</span>';
            $tanggal = date("d M Y", strtotime($request->tanggal));
            $waktu = date("H:i", strtotime($request->waktu));
            $data = "
                <td class='align-middle'>$tanggal</td>
                <td class='align-middle'>$waktu</td>
                <td class='align-middle'>$user->nama</td>
                <td class='align-middle'>$request->nama</td>
                <td class='align-middle'>$badge</td>
                <td class='align-middle'>
                <a href='javascript:void[0]' onclick='show($jadwal->id_jadwal)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                <a href='javascript:void[0]' onclick='deleteConfirm($jadwal->id_jadwal)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                </td>
            ";
            return response()->json(['success' => true, 'data' => $data, 'id' => $jadwal->id_jadwal, 'message' => 'Berhasil memperbaharui data jadwal'], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    public function destroy(Jadwal $jadwal)
    {
        $id = $jadwal->id_jadwal;
        $jadwal->delete();
        $count = Jadwal::count();
        return response()->json(['success' => true, 'id' => $id, 'count' => $count, 'message' => 'Berhasil menghapus data jadwal'], 200);
    }
}
