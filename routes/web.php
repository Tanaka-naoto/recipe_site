<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

            Route::get('/', function () {
                return view('auth.login');
            })->middleware('guest');

            Route::get('/home', 'HomeController@index')->name('index');

            Route::middleware('auth')
             ->group(function() {

                //カテゴリ分けしない全てのレシピ一覧
                Route::get('recipe/index', 'RecipeController@recipe_list')->name('all.recipe');
                Route::post('recipe/{recipe}/favorites', 'FavoriteController@store')->name('favorites');
                Route::post('recipe/{recipe}/unfavorites', 'FavoriteController@destroy')->name('unfavorites');
                //カテゴリ別レシピ一覧
                Route::get('recipe/{category}/index', 'RecipeController@index')->name('recipe.index');
                Route::get('recipe/cook', 'RecipeController@create')->name('recipe.create');
                Route::post('recipe/cook', 'RecipeController@store')->name('recipe.store');
                Route::get('recipe/{recipe}', 'RecipeController@show')->name('recipe.show');
                Route::get('recipe/{recipe}/edit', 'RecipeController@edit')->name('recipe.edit');
                Route::put('recipe/{recipe}/update', 'RecipeController@update')->name('recipe.update');
                Route::delete('recipe/{recipe}/destroy', 'RecipeController@destroy')->name('recipe.destroy');
                 //コメント
                Route::post('/recipe/{recipe}/comment', 'CommentController@store')
                ->name('comment.store')
                ->where('recipe', '[0-9]+');
                //ユーザー一覧
                Route::get('user/index', 'HomeController@user_index')->name('user_index');
                //ユーザーのレシピ一覧
                Route::get('recipe/{user}/view', 'RecipeController@UserRecipes')->name('user_recipes');
        });

            Route::prefix('mypage') //URLをuse
                ->middleware('auth')
                ->group(function () {

                    //自分のレシピ一覧
                    Route::get('recipes', 'HomeController@myreciep')->name('mypage.recipe');
                    //プロフィール編集
                    Route::get('profile/{user}/edit', 'ProfileController@edit')->name('profile.edit');
                    Route::put('profile/{user}/update', 'ProfileController@update')->name('profile.update');


                });

                    Route::delete('/profile/delete/{user}', 'ProfileController@delete')->name('profile.delete');
