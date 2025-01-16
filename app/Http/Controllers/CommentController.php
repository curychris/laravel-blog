<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Blog $blog)
{
    $request->validate([
        'content' => 'required|max:500',  // Validasi komentar
    ]);

    $blog->comments()->create([
        'content' => $request->content,
        'user_id' => auth()->id(),  // ID user yang mengirim komentar
    ]);

    return back()->with('message', 'Comment added successfully!');
}

}
