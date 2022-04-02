<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\Category;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categorys = Category::all();

        return view('categorys', compact('categorys'));
    }



    public function myreciep()
    {
        $user = Auth::user();

        $want_recipes = Recipe::where('user_id', $user->id);
        $recipes =  $want_recipes->orderBy('created_at', 'desc')->get();

        return view('Mypage/myrecipe', compact('recipes'));
    }

    public function user_index() {

        $users = User::latest()->get();
        // dd($users);

        return view('user_index', compact('users'));
    }


}
