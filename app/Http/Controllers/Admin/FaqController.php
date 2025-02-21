<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faq = Faq::all();
        $data = [
            'title' => 'Faq',
            'faq' => $faq
        ];

        return view('admin.faq.index', $data);
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
        $validatedData = $request->validate([
            'pertanyaan' => 'required|max:255',
            'jawaban' => 'required|max:255',
        ]);

        $faq = new Faq();
        $faq->pertanyaan = $validatedData['pertanyaan'];
        $faq->jawaban = $validatedData['jawaban'];

        $faq->save();

        return redirect()->route('faq.index')->with('msg', 'FAQ berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);

        $data = [
            'title' => 'Edit Faq',
            'faq' => $faq,
        ];

        return view('admin.faq.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validatedData = $request->validate([
            'pertanyaan' => 'required|max:255',
            'jawaban' => 'required|max:255',
        ]);

        $faq->pertanyaan = $validatedData['pertanyaan'];
        $faq->jawaban = $validatedData['jawaban'];

        $faq->save();

        return redirect()->route('faq.index')->with('msg', 'FAQ berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('faq.index')->with('msg', 'FAQ berhasil dihapus');
    }
}
