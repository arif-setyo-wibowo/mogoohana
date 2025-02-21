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
            'username.required' => 'Admin username is required.',
            'username.username' => 'Admin username is not valid.',
            'password.required' => 'Admin password is required.',
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
                return redirect()->route('login')->withErrors(['error' => 'Wrong Password'])->withInput();
            }
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Email not found'])->withInput();
        }

    }
    public function logout_admin (){

        session()->forget('admin');
        session()->forget('user.id');
        session()->forget('user.nama');
        return redirect()->route('login');
    }
}
