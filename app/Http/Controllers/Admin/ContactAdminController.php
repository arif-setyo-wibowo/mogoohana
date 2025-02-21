<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    /**
     * Menampilkan daftar kontak
     */
    public function index()
    {
        $contacts = Contact::all();
        $title = 'Contact Admin';
        return view('admin.contact.index', compact('contacts','title'));
    }

    /**
     * Menampilkan halaman edit kontak
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $title = 'Edit Contact Admin';
        return view('admin.contact.edit', compact('contact','title'));
    }

    /**
     * Memperbarui data kontak
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'link_discord' => 'required|url',
            'link_wa' => 'required|url',
            'link_instagram' => 'required|url',
            'link_facebook' => 'required|url',
        ]);

        // Cari data kontak berdasarkan ID
        $contact = Contact::findOrFail($id);
        $contact->update([
            'link_discord' => $request->link_discord,
            'link_wa' => $request->link_wa,
            'link_instagram' => $request->link_instagram,
            'link_facebook' => $request->link_facebook,
        ]);

        // Redirect kembali ke daftar kontak dengan pesan sukses
        return redirect()->route('contact-admin.index')->with('msg', 'Kontak berhasil diperbarui!');
    }
}
