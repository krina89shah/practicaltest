<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiCommentController extends Controller
{
    
    public function index(Post $post)
    {
        return response()->json($post->comments, 200);
    }

   
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
            'content' => 'required|string',
        ]);

        $comment = $post->comments()->create($validated);

        return response()->json($comment, 201);
    }

    
    public function show(Post $post, Comment $comment)
    {
        if ($post->id !== $comment->post_id) {
            return response()->json(['error' => 'Comment does not belong to this post'], 404);
        }

        return response()->json($comment, 200);
    }

     
    public function update(Request $request, Post $post, Comment $comment)
    {
        if ($post->id !== $comment->post_id) {
            return response()->json(['error' => 'Comment does not belong to this post'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
            'content' => 'required|string',
        ]);

        $comment->update($validated);

        return response()->json($comment, 200);
    }

    
    public function destroy(Post $post, Comment $comment)
    {
        if ($post->id !== $comment->post_id) {
            return response()->json(['error' => 'Comment does not belong to this post'], 404);
        }

        $comment->delete();

        return response()->json(null, 204);
    }
}
