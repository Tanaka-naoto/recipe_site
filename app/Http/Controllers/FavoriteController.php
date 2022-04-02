<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Recipe $recipe) {

        $recipe->users()->attach(Auth::id());
        return back()->with('message', 'いいねをしました。');
    }

    public function destroy(Recipe $recipe) {

        $recipe->users()->detach(Auth::id());
        return back();
    }
}
