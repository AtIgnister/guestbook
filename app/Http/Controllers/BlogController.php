<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\Request;
use File;

class BlogController extends Controller
{
    public function index(Request $request) {
        $path = resource_path("posts/index.html");
        if(File::exists($path)) {
            $content = File::get($path);
            return view('blog.post', compact('content'));
        }
    }

    public function post(Request $request, $post_name) { 
        // Allow only safe filenames (letters, numbers, dashes)
        if (!preg_match('/^[a-z0-9\-]+$/i', $post_name)) {
            abort(404);
        }

        $path = resource_path('posts/' . $post_name . '.html');

        if (!File::exists($path)) {
            abort(404);
        }

        $content = File::get($path);

        return view('blog.post', compact('content'));
    }
}
