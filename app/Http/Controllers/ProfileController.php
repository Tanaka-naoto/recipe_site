<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\EditRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(User $user) {


        return view('Mypage.profile_edit', compact('user'));
    }

    public function update(User $user, Request $request) {


        $inputs = $request->validate([
            'name'=>'required|max:255',
            'email'=>['required','email','max:255', Rule::unique('users')->ignore($user->id)],
            'password'=>'required|confirmed|max:255|min:8',
            'password_confirmation'=>'required|same:password'
        ]);

        $inputs['password'] = Hash::make($inputs['password']);


        $user->update($inputs);

        return back()->with('message', '情報を更新しました');
    }

    public function delete(User $user) {

        foreach($user->recipes as $recipe) {

            Storage::delete('public/images/'.$recipe->image);
        }


        $user->recipes()->delete();
        $user->comments()->delete();

        $user->delete();

        return back()->with('message', 'ユーザーを削除しました。');
    }


}
