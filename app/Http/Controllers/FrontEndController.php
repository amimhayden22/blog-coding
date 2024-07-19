<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('title', 'asc')->get();

        return view('index', compact('posts'));
    }
}
