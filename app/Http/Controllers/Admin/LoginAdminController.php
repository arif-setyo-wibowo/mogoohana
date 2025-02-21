<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class LoginAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('admin.login.index',$data);
    }

    public function postlogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],[
            'username.required' => 'Username admin harus diisi.',
            'username.username' => 'Username admin tidak valid.',
            'password.required' => 'Kata sandi admin harus diisi.',
        ]);

        $user = Admin::where('username', $request->username)->first();

        if ($user) {
            if (password_verify($request->password, $user->password)) {
                // Flush the session to clear any previous data
                session()->flush();

                // Set common session variables
                session([
                    'user.id' => $user->id,
                    'user.username' => $user->username,
                    'user.nama' => $user->nama,
                    'admin' => true
                ]);
                return redirect()->route('dashboard.index');

            } else {
                return redirect()->route('login')->withErrors(['error' => 'Password salah'])->withInput();
            }
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Email tidak ditemukan'])->withInput();
        }

    }
    public function logout_admin (){

        session()->forget('admin');
        session()->forget('user.id');
        session()->forget('user.nama');
        return redirect()->route('login');
    }
}
