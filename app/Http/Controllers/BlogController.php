<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function create()
    {
        return view('blogs.create');
    }

    public function store(BlogRequest $request)
{
    $attrs = $request->only(app(Blog::class)->getFillable());
    $attrs['creator_id'] = auth()->id();

    // Menyimpan blog tanpa gambar terlebih dahulu
    $blog = Blog::create($attrs);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filePath = $image->storeAs('public/blogs', Str::random(5) . '.' . $extension);

        $storagePath = Storage::url($filePath);

        // Menyimpan data gambar ke dalam tabel image
        $blog->image()->create([
            'path' => $storagePath
        ]);
    }

    return redirect(route('dashboard'))
                ->with('message', 'Blog Created Successfully!');
}


    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => [
                'sometimes',
                'mimes:png,jpg,jpeg',
                'nullable'
            ]
        ]);
    
        $attrs = $request->only(app(Blog::class)->getFillable());
    
        $blog->update($attrs);
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($blog->image && File::exists(public_path($blog->image->path))) {
                File::delete(public_path($blog->image->path));
            }
        
            // Menyimpan gambar baru
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filePath = $image->storeAs('public/blogs', Str::random(5) . '.' . $extension);
        
            $storagePath = Storage::url($filePath);
        
            // Update data gambar
            if ($blog->image) {
                $blog->image->update(['path' => $storagePath]);
            } else {
                $blog->image()->create(['path' => $storagePath]);
            }
        }
        
    
        return redirect(route('dashboard'))
                    ->with('message', 'Blog Updated Successfully!');
    }
    

    
    public function delete(Blog $blog)
{
    // Hapus gambar jika ada
    if ($blog->image && File::exists(public_path($blog->image->path))) {
        File::delete(public_path($blog->image->path));
    }

    // Hapus blog dari database
    $blog->delete();

    // Setelah aksi berhasil, arahkan kembali ke dashboard dengan pesan sukses
    return redirect()->route('dashboard')->with('success', 'Blog berhasil dihapus.');
}

}
