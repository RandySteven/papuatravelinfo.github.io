<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Forum;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->user()->associate($request->user());
        $forum = Forum::find($request->get('forum_id'));
        $forum->comments()->save($comment);
        return back();
    }

    public function replies(Request $request){
        $reply = new Comment();
        $reply->comment = $request->comment;
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $forum = Forum::find($request->get('forum_id'));
        $forum->comments()->save($reply);
        return back();
    }

    public function delete(Comment $comment){
	$comment->where('id', $comment->id)->delete();
	return back();
    }
}
