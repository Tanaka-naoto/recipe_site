<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(Recipe $recipe, CommentRequest $request) {

        $user = Auth::user();

        $comment = new Comment;

        $comment->body =$request->input('body');
        $comment->user_id = $user->id;
        $comment->recipe_id = $recipe->id;

        $comment->save();

        return redirect()
            ->route('recipe.show', $recipe)
            ->with('message', 'コメントを保存しました');

    }
}
