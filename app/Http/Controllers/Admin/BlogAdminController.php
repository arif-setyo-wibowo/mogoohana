<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class BlogAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = Blog::all();
        $data = [
            'title' => 'Blog',
            'blog' => $blog
        ];

        return view('admin.blog.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Add New Blog'
        ];
        return view('admin.blog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'judul' => 'required|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'deskripsi' => 'nullable|string'
            ]);

            $blog = new Blog();
            $blog->judul = $validatedData['judul'];
            $blog->slug = Str::slug($validatedData['judul']);
            $blog->deskripsi = $request->input('deskripsi');

            // Handle file upload
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');

                // Generate unique filename
                $filename = uniqid('blog_') . '.' . $file->getClientOriginalExtension();

                // Store file in the public disk
                $path = $file->storeAs('blog', $filename, 'public');

                // Remove 'public/' prefix if present
                $blog->foto = str_replace('public/', '', $path);
            }

            $blog->save();

            return redirect()->route('blog.index')->with('msg', 'Blog successfully added');
        } catch (\Exception $e) {
            // Log the full error
            Log::error('blog store error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan blog: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = blog::findOrFail($id);
        $data = [
            'title' => 'Detail Blog',
            'Blog' => $blog
        ];
        return view('admin.blog.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $data = [
            'title' => 'Edit blog',
            'blog' => $blog
        ];
        return view('admin.blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $blog = blog::findOrFail($id);

            $validatedData = $request->validate([
                'judul' => 'required|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'deskripsi' => 'nullable|string'
            ]);

            $blog->judul = $validatedData['judul'];
            $blog->slug = Str::slug($validatedData['judul']);
            $blog->deskripsi = $request->input('deskripsi');

            // Handle file upload
            if ($request->hasFile('foto')) {
                // Delete old file if exists
                if ($blog->foto) {
                    Storage::disk('public')->delete($blog->foto);
                }

                $file = $request->file('foto');

                // Generate unique filename
                $filename = uniqid('blog_') . '.' . $file->getClientOriginalExtension();

                // Store file in the public disk
                $path = $file->storeAs('blog', $filename, 'public');

                // Remove 'public/' prefix if present
                $blog->foto = str_replace('public/', '', $path);
            }

            $blog->save();

            return redirect()->route('blog.index')->with('msg', 'Blog successfully updated');
        } catch (\Exception $e) {
            // Log the full error
            Log::error('Blog update error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui blog: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        // Delete associated image if exists
        if ($blog->foto) {
            Storage::disk('public')->delete($blog->foto);
        }

        $blog->delete();

        return redirect()->route('blog.index')->with('msg', 'Blog successfully deleted');
    }
}
