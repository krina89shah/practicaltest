<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Fetch all comments on a specific post
    public function getCommentsByPost(Post $post)
    {
        $comments = $post->comments;
        return view('comments.post_comments', compact('comments', 'post'));
    }
}

