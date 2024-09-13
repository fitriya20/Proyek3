<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{            
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'tanggal' => 'required',
            'bentuk' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            Obat::create([
                'nama_obat' => $request->nama,
                'bentuk_obat' => $request->bentuk,
                'kedaluwarsa' => $request->tanggal,
            ]);
            $obatCount = Obat::count();
            $maxID = Obat::max('id_obat');                       
            $data = "
                <tr id='tr_$maxID'>
                    <td class='align-middle'>$request->nama</td>
                    <td class='align-middle'>$request->bentuk</td>
                    <td class='align-middle'>".date('d M Y', strtotime($request->tanggal))."</td>
                    <td class='align-middle'>
                    <a href='javascript:void[0]' onclick='show($maxID)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                    <a href='javascript:void[0]' onclick='deleteConfirm($maxID)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                    </td>
                </tr>
            ";
            return response()->json(['success' => true, 'data' => $data, 'count' => $obatCount, 'message' => 'Berhasil menambah data obat'], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Obat $obat)
    {
        return response()->json(['success' => true, 'data' => $obat], 200);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Obat $obat)
    {
        $rules = [
            'nama' => 'required',
            'tanggal' => 'required',
            'bentuk' => 'required'
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            $obat->update([
                'nama_obat' => $request->nama,
                'bentuk_obat' => $request->bentuk,
                'kedaluwarsa' => $request->tanggal,
            ]);
            $data = "
                    <td class='align-middle'>$request->nama</td>
                    <td class='align-middle'>$request->bentuk</td>
                    <td class='align-middle'>".date('d M Y', strtotime($request->tanggal))."</td>
                    <td class='align-middle'>
                    <a href='javascript:void[0]' onclick='show($obat->id_obat)' id='btn_edit' class='btn p-2 btn-sm text-white rounded-sm btn-secondary mr-1'><i class='ti-pencil-alt'></i></a>
                    <a href='javascript:void[0]' onclick='deleteConfirm($obat->id_obat)' id='btn_delete' class='btn p-2 btn-sm rounded-sm btn-danger'><i class='ti-trash'></i></a>
                    </td>
            ";
            return response()->json(['success' => true, 'data' => $data, 'id' => $obat->id_obat, 'message' => 'Berhasil memperbaharui data obat'], 200);
        }
        return response()->json(['success' => false, 'error' => $v->errors()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Obat $obat)
    {
        $id = $obat->id_obat;
        $obat->delete();
        $count = Obat::count();
        return response()->json(['success' => true, 'id' => $id, 'count' => $count, 'message' => 'Berhasil menghapus data obat'], 200);
    }
}
