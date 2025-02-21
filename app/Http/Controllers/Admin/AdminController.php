<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Admin',
            'admin' => Admin::all()
        ];

        return view('admin.admin.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'unique:admins',
        ]);
        $admin = new Admin;
        $admin->nama = $request->nama;
        $admin->username = $request->username;
        $admin->password = Hash::make($request->password);
        $admin->save();
        Session::flash('msg', 'Berhasil Menambah Data');
        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Admin',
            'admin' => Admin::find($id)
        ];

        return view('admin.admin.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $admin = Admin::find($request->id);

            $request->validate([
                'username'=> Rule::unique('admins')->ignore($admin->id)
            ]);

            if($request->password == null){
                $password = $request->password_lama;
            }else{
                $password = Hash::make($request->password);
            }

            if ($request->nama_user == null) {
                session(['nama.admin' => $admin->nama_user]);
            }else{
                session()->forget('nama.admin');
                session(['nama.admin' => $request->nama_user]);
            }

            $admin->nama = $request->nama;
            $admin->username = $request->username;
            $admin->password = $password;
            $admin->save();


            Session::flash('msg', 'Berhasil Mengubah Data');
            return redirect()->route('admin.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect()->route('admin.index')->with('msg', 'Admin berhasil dihapus');
    }
}
