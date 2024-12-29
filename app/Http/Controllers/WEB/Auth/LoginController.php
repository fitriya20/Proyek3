<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|min:8'
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id == Role::ADMIN) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == Role::CUSTOMER) {
                return redirect()->route('customer.dashboard');
            }
        }

        return redirect()->back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('customer');
    }
}
