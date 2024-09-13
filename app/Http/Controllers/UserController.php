<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{      
    public function store(Request $request)
    {
        if ($request->level == "dokter") {
            $rules = [
                'nama' => 'required',
                'no_whatsapp' => 'required|unique:users,no_whatsapp|numeric|min_digits:10',
            ];
        }else{
            $rules = [
                'nama' => 'required',
                'no_whatsapp' => 'required|unique:users,no_whatsapp|numeric|min_digits:10',
                'username' => 'required|unique:users,username',
                'password' => 'required',
                'password_conf' => 'required|same:password',
            ];
        }
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            User::create([
                'nama' => $request->nama,
                'no_whatsapp' => $request->no_whatsapp,
                'username' => ($request->level == "dokter") ? null : $request->username,
                'level' => $request->level,
                'password' => ($request->level == "dokter") ? null : bcrypt($request->password_conf),
            ]);
            $userCount = User::where('level',$request->level)->count();
            $maxID = User::max('id_user'); 
            $badge = ($request->level == "dokter") ? '<span class="badge text-white bg-primary">Dokter</span>' : '<span class="badge text-white bg-secondary">Pasien</span>';                      
            if ($request->level == "dokter") {
                $data = "
                    <tr id='tr_$maxID'>
                        <td class='align-middle'>$request->nama</td>
                        <td class='align-middle'>$request->no_whatsapp</td>
                        <td class='align-middle'>
                        <a href='javascript:void[0]' onclick='show($maxID)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                        <a href='javascript:void[0]' onclick='deleteConfirm($maxID)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                        </td>
                    </tr>
                ";
            } else {
                $data = "
                    <tr id='tr_$maxID'>
                        <td class='align-middle'>$request->nama</td>
                        <td class='align-middle'>$request->username</td>
                        <td class='align-middle'>$request->no_whatsapp</td>
                        <td class='align-middle'>$badge</td>
                        <td class='align-middle'>
                        <a href='javascript:void[0]' onclick='show($maxID)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                        <a href='javascript:void[0]' onclick='deleteConfirm($maxID)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                        </td>
                    </tr>
                ";
            }
            
            return response()->json(['success' => true, 'data' => $data, 'count' => $userCount, 'message' => $request->level == "dokter" ? "Berhasil menambah data Dokter" : "Berhasil menambah data Pasien"], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    public function show(User $user)
    {
        return response()->json(['success' => true, 'data' => $user], 200);                
    }
    
    public function edit(Request $request, User $user)
    {
        $wa = "";
        $usrnm = "";
        if ($request->no_whatsapp != $user->no_whatsapp) {
            $wa = "|unique:users,no_whatsapp";
        }
        if ($request->level == "dokter") {
            $rules = [
                'nama' => 'required',
                'no_whatsapp' => 'required|numeric|min_digits:10'.$wa,
            ];
        }else{

            if ($request->username != $user->username) {
                $usrnm = "|unique:users,username";
            }
            $rules = [
                'nama' => 'required',
                'no_whatsapp' => 'required|numeric|min_digits:10'.$wa,
                'username' => 'required'.$usrnm,            
            ];
            if ($request->password != null) {
                $rules += [
                    'password_conf' => 'same:password',
                ];
                $pw = bcrypt($request->password_conf);
            }else{
                $pw = $user->password;
            }
        }
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            $user->update([
                'nama' => $request->nama,
                'password' => ($request->level == "dokter") ? null : $pw,
                'level' => $request->level,
                'username' => ($request->level == "dokter") ? (($usrnm == "") ? $user->username : $request->username) : null ,
                'no_whatsapp' => ($wa == "") ? $user->no_whatsapp : $request->no_whatsapp,
            ]);
            $badge = ($request->level == "dokter") ? '<span class="badge text-white bg-primary">Dokter</span>' : '<span class="badge text-white bg-secondary">Pasien</span>';                      
            if ($request->level == "dokter") {
                $data = "
                    <td class='align-middle'>$request->nama</td>
                    <td class='align-middle'>$request->no_whatsapp</td>
                    <td class='align-middle'>
                    <a href='javascript:void[0]' onclick='show($user->id_user)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                    <a href='javascript:void[0]' onclick='deleteConfirm($user->id_user)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                ";
            }else{
                $data = "
                    <td class='align-middle'>$request->nama</td>
                    <td class='align-middle'>$request->username</td>
                    <td class='align-middle'>$request->no_whatsapp</td>
                    <td class='align-middle'>$badge</td>
                    <td class='align-middle'>
                    <a href='javascript:void[0]' onclick='show($user->id_user)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                    <a href='javascript:void[0]' onclick='deleteConfirm($user->id_user)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                ";
            }
            return response()->json(['success' => true, 'data' => $data, 'id' => $user->id_user, 'message' => $request->level == "dokter" ? "Berhasil memperbaharui data Dokter" : "Berhasil memperbaharui data Pasien"], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    public function destroy(User $user)
    {
        $id = $user->id_user;
        $level = $user->level == "dokter" ? "dokter" : "pasien";
        $user->delete();
        $count = User::where('level', $level)->count();
        return response()->json(['success' => true, 'id' => $id, 'count' => $count, 'message' => "Berhasil menghapus data $level"], 200);
    }
}
