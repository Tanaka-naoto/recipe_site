@extends('layouts.app')
@section('content')

{{-- メッセージ表示 --}}
@if(session('message'))
<div class="col-8 mx-auto alert alert-success">{{session('message')}}</div>
@endif

{{-- エラー表示 --}}
@if ($errors->any())
<div class="col-8 mx-auto alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container ml-auto col-12 col-md-10 col-lg-8" style="margin-top: 5%;">
    <div class="row">
        <div class="col-md-10 mt-6 mx-auto">
            <div class="card-body" style="background-color:white;">
                <h1 class="mt4">{{$user->name}}さんのプロフィール編集</h1>

                <form method="post" action="{{ route('profile.update', $user) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="name">お名前</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{old('name', $user->name)}}">
                    </div>

                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="text" name="email" class="form-control" id="email" value="{{old('email', $user->email)}}">
                    </div>

                    <div class="form-group">
                        <label for="password">パスワード(8文字以上）</label>
                        <input id="password" type="password"
                        class="form-control" name="password" placeholder="パスワードを入力してください"
                        required autocomplete="new-password">

                    </div>

                    <div class="form-group">
                        <label for="password">パスワード再入力</label>
                        <input id="password-confirm" type="password" class="form-control"
                        name="password_confirmation" placeholder="パスワードを再入力してください"
                        required autocomplete="new-password">
                    </div>

                    <button type=”submit” class="btn btn-success" style="display: block; margin-left: auto;">送信する</button>
                </form>


            </div>
        </div>
    </div>
</div>

@endsection
