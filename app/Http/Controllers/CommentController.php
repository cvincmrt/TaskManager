<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;


class CommentController extends Controller
{
    public function store(Request $request ,Task $task)
    {
        $request->validate([
            'body' => 'required|string|max:100',
        ]);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return back()->with('success', 'Komentar bol uspesne pridany!!!');

    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete',$comment);

        $comment->delete();

        return back()->with('success', 'komentar bol uspesne zmazany');
    }
}
