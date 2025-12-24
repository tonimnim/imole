<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentStoreRequest $request): Response
    {
        $comment = Comment::create($request->validated());

        CommentPosted::dispatch($comment);

        return redirect()->route('lesson.show', ['lesson' => $lesson]);
    }
}
