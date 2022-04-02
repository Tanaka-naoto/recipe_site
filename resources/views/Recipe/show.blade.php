@extends('layouts.app')

@section('content')

@if(session('message'))

    <div class="alert alert-success">{{session('message')}}</div>

    @endif


<div class="container">
<div class="card mb-4">

    <div class="card-header" style="display:flex; padding-top:20px; padding-bottom:20px; box-sizing: content-box;">

        {{-- <img src="{{asset('storage/avator/'.($post->user->avator??'user_default.jpg'))}}"
        class="rounded-circle" style="width:40px;height:40px;"> --}}

        <div class="wrp">
            <a href="{{ route('user_recipes', $recipe->user) }}" style="display:block; text-decoration: none">

                {{$recipe->user->name??'削除されたユーザ'}}
            </a>
            <span>
                {{ $recipe->category->name }}
            </span>
            <h4 style="margin-bottom: 0px" class="content_title">{{$recipe->title}}</h4>
        </div>

        @can('update', $recipe)
            <a href="{{ route('recipe.edit', $recipe) }}" style="margin-left:auto">
                <button class="btn btn-success" style="margin-left: 10px">編集</button>
            </a>
        @endcan


        @can('delete', $recipe)
            <form method="post" action="{{ route('recipe.destroy', $recipe) }}">
                @csrf
                @method('delete')
                <button class="btn btn-danger" onclick="return confirm('本当に削除しますか？')" style="margin-left: 10px">削除</button>
            </form>
        @endcan
    {{-- @can('update', $post)
        <span style="margin-left: auto">
            <a href="{{ route('post.edit', $post) }}">
                <button class="btn btn-primary">編集</button>
            </a>
        </span>
    @endcan --}}

    {{-- @can('delete', $post)
        <span class="ml2">
            <form  method="post" action="{{ route('post.destroy', $post) }}">
                @csrf
                @method('delete')
                <button class="btn btn-danger" onclick="return confirm('本当に削除しますか？')" style="margin-left: 4px">削除</button>
            </form>
        </span>
    @endcan --}}
    </div>
    <div class="card-body">
        @if($recipe->image)
        <div class="card-img-top image-card"style="background: url({{asset('storage/images/'.$recipe->image)}})no-repeat center center; background-size:cover; margin-bottom: 20px" >
            @if($recipe->image)
            {{-- <img src="{{asset('storage/images/'.$recipe->image)}}" alt="レシピ画像" style="height : auto; width: 100%; border-radius: 5px"> --}}
            @endif
        </div>
        @endif
        <p class="card-text">

            {!! nl2br(e($recipe->body)) !!}
        </p>




    </div>
    <div class="card-footer">
        <span class="mr-2 float-right">
            投稿日 {{$recipe->created_at->diffForHumans()}}
        </span>
    </div>
</div>



    <!-- コメント表示部分-->
            <hr>
                @if ($recipe->comments)
                @foreach ($recipe->comments as $comment)
                <div class="card mb-4">

                    <div class="card-header">



                        <a href="{{ route('user_recipes', $comment->user) }}" style="text-decoration: none">
                            {{$comment->user->name??'削除されたユーザ'}}
                        </a>

                    </div>
                    <div class="card-body">
                        {!! nl2br(e($comment->body)) !!}
                    </div>
                    <div class="card-footer">
                        <span class="mr-2 float-right" style="float: right;">
                            投稿日時 {{$comment->created_at->diffForHumans()}}
                        </span>
                    </div>
                </div>
                @endforeach
                @endif

                {{-- バリデーションエラー表示 --}}
                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif --}}







<div class="card mb-4">
    <form  method="post" action="{{ route('comment.store', $recipe) }}" style="text-align: right">
    @csrf
    <div class="card-body" style="padding: 0px; height: 98px">
            <textarea name="body"placeholder="コメントを入力" class="form-control" style="width: 100%; height:100%">{{old('body')}}</textarea>
    </div>
    <div class="card-footer">
        <span class="mr-2 float-right">

                    <button class="btn btn-success" style="margin-left: 4px">コメントする</button>
    </form>
        </span>
    </div>
</div>
</div>
@endsection
