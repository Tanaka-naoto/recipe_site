<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CookRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
class RecipeController extends Controller
{

    //カテゴリ分けしない全てのレシピ一覧
    public function recipe_list(Request $request) {

        $defaults = [
            'category' => $request->input('category'),
            'keyword'  => $request->input('keyword', ''),
        ];

        $categorys = Category::all();

        $recipes = Recipe::orderBy('created_at', 'desc')->get();

        //カテゴリがありつつキーワードもある場合
        if($request->filled('category') && $request->filled('keyword')) {
            $categoryID = $request->input('category');
            $keyword = '%' . $this->escape($request->input('keyword')) . '%';

            $recipes = Recipe::where('category_id', $categoryID)->where('title', 'LIKE', $keyword)->orWhere('body', 'LIKE', $keyword)->latest()->get();


            //カテゴリのみある場合
        } else if($request->filled('category')) {

            $categoryID = $request->input('category');
            $recipes = Recipe::where('category_id', $categoryID)->latest()->get();


            //キーワードのみある場合
        } else if($request->filled('keyword')) {

            $keyword = '%' . $this->escape($request->input('keyword')) . '%';
            $recipes = Recipe::where('title', 'LIKE', $keyword)->orWhere('body', 'LIKE', $keyword)->latest()->get();

        }


    return view('list',compact('recipes','categorys', 'defaults'));


    }

    private function escape(string $value)
     {
         return str_replace(
             ['\\', '%', '_'],
             ['\\\\', '\\%', '\\_'],
             $value
         );
     }






    //カテゴリ別のレシピ一覧
    public function index(Category $category) {

        $category_id = $category->id;

        $want_recipes = Recipe::where('category_id', $category_id);
        $recipes = $want_recipes->latest()->get();

        return view('Recipe/recipes', compact('recipes', 'category'));
    }


    public function show(Recipe $recipe) {

        $user = Auth::user();

        return view('Recipe.show', compact('recipe', 'user'));
    }

    public function create() {

        $categorys = Category::all();

    return view('Recipe/create', compact('categorys'));
    }


    public function store(Request $request) {

        $user = Auth::user();

        $inputs = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:255',
            'category'  => 'required', 'integer',
            'image' => 'image|max:1024'
        ],[
            'title.required' => '件名は必須です',
            'title.max' => '件名は:max 文字までです',
            'body.required' => '本文は必須です。'
        ]);

        $recipe = new Recipe();

        $recipe->title = $inputs['title'];
        $recipe->body = $inputs['body'];
        $recipe->category_id = $inputs['category'];
        $recipe->user_id = $user->id;

        //保存したレシピのカテゴリーへ移転させるため
        // $category = $input('category');
        $category = $inputs['category'];
        //画像自体をstorageフォルダへ保存
        if (request('image')) {

            $original= request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $file = request()->file('image')->move('storage/images',$name);
            //画像の名前をデータベースへ保存
            $recipe->image = $name;
        }


        $recipe->save();

        return redirect()
            ->route('recipe.index', compact('recipe', 'category'))
            ->with('message', 'レシピを公開しました');

    }

    public function edit(Recipe $recipe) {

        $this->authorize('update', $recipe);

        $categorys = Category::all();

        return view('Recipe.edit', compact('recipe', 'categorys'));

    }

    public function update(Request $request, Recipe $recipe) {

        $this->authorize('update', $recipe);


        $inputs = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required|max:255',
            'category'  => 'required', 'integer',
            'image' => 'image|max:1024'
        ],[
            'title.required' => '件名は必須です',
            'title.max' => '件名は:max 文字までです',
            'body.required' => '本文は必須です。'
        ]);

        $recipe->title = $inputs['title'];
        $recipe->body = $inputs['body'];
        $recipe->category_id = $inputs['category'];

         //画像自体をstorageフォルダへ保存
         if (request('image')) {
            $original= request()->file('image')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $file = request()->file('image')->move('storage/images',$name);
            //画像の名前をデータベースへ保存
            $recipe->image = $name;
        }



        $recipe->update();


        return redirect()

            ->route('recipe.show',compact('recipe'))
            ->with('message', 'レシピを公開しました');

    }

    public function destroy(Recipe $recipe) {

        $this->authorize('delete', $recipe);

        $category = $recipe->category_id;
        $recipe->comments()->delete();
        Storage::delete('public/images/'.$recipe->image);
        $recipe->delete();
        return redirect()
            ->route('recipe.index',compact('category'))
            ->with('message', 'レシピを削除しました');

    }

    public function UserRecipes(User $user) {


        $user_id = $user->id;

        $recipes = Recipe::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();


        return view('Recipe/user_recipes', compact('recipes', 'user'));
    }



}
