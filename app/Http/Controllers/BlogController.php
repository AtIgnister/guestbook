<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class BlogController extends Controller
{
    public function index(Request $request) {
        $htmlPath = resource_path("posts/index.html");
        $bladePath = resource_path("posts/index.blade.php");
        if(File::exists($bladePath)) {
            $content = view()->file($bladePath)->render();
            return view('blog.post', compact('content'));
        }

        if(File::exists($htmlPath)) {
            $content = File::get($htmlPath);
            return view('blog.post', compact('content'));
        }

        abort(404);
    }

    public function post(Request $request, $post_name) {
        // Allow only safe filenames (letters, numbers, dashes)
        if (!preg_match('/^[a-z0-9\-]+$/i', $post_name)) {
            abort(404);
        }

        $htmlPath  = resource_path("posts/{$post_name}.html");
        $bladePath = resource_path("posts/{$post_name}.blade.php");

        if (File::exists($bladePath)) {
            $content = view()->file($bladePath)->render();
        } else if (File::exists($htmlPath)) {
            $content = File::get($htmlPath);
        }

        return view('blog.post', compact('content'));
    }
}
