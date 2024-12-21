<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class ApiPostController extends Controller
{
    
    public function index()
    {
       
        return response()->json(Post::all(), 200);
    }

     
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $validated['user_id'] = $user->id;
        $post = Post::cr;eate($validated);

        return response()->json($post, 201);
    }

     
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    
    public function update(Request $request, Post $post)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        $validated['user_id'] = $user->id;
        $post->update($validated);

        return response()->json($post, 200);
    }

     
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(null, 204);
    }
}

