<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::latest()->get();
    return view('posts.index', compact('posts'));
}

public function create()
{
    return view('posts.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
    ]);

    Post::create($request->all());

    return redirect()->route('posts.index')->with('success', 'Post created successfully.');
}
// public function index()
// {
//     return view('posts.index');
// }

}
