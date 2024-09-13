<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->passes()) {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return response()->json(['success' => 'Berhasil']);
            }else{
                $responses = [
                    'error' => [
                        'password' => 'Password salah'
                    ]
                ];
                return response()->json($responses);
            }        
        }
        return response()->json(['error' => $v->errors()]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
