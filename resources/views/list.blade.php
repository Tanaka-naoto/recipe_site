@extends('layouts.app')

@section('content')

@if(session('message'))
    <div class="alert alert-success">{{session('message')}}</div>
@endif



<div class="container">


    <div class="ml-2 mb-3" style="text-align: center; font-size: 1.6em; font-weight: bold">
        レシピ一覧
    </div>

    <form class="form-inline" method="GET" action="{{ route('all.recipe') }}">
        <div class="input-group">
            <div class="input-group-prepend" style="display: flex">
                <select class="custom-select" name="category">
                    <option option value="">全て</option>
                    @foreach ($categorys as $category)                             <!-- 送信したカテゴリのIID（$category->id）と送られてきたカテゴリのID（$categoryID)が一致していればそのカテゴリの名前を表示する）-->
                       <option value="{{$category->id}}" class="font-weight-bold" {{ $defaults['category'] == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" name="keyword" value="{{ $defaults['keyword']}}" class="form-control" aria-label="Text input with dropdown button" placeholder="キーワード検索">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-dark">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>



    <div class="row g-3 mt-5 mb-5">
        @foreach ($recipes as $recipe)

            <div class="col-md-4">
                <a href="{{ route('recipe.show', $recipe) }}" style="text-decoration: none; color: black">

                    <div class="card">
                        @if($recipe->image)
                            <div class="card-img-top image-card" style="background: url({{asset('storage/images/'.$recipe->image)}})no-repeat center center; background-size:cover;"></div>
                        @else
                            <div class="card-img-top image-card image-card-1"></div>
                        @endif

                        <div class="card-body">

                            <span class="text-uppercase text-danger fw-bold fs-6">
                                {{$recipe->title}}
                            </span>

                            <p class="card-text">
                                {{Str::limit($recipe->body, 40, '..')}}
                            </p>

                            <div class="data_name d-flex">
                                <small class="text-dark">
                                    {{$recipe->created_at->diffForHumans()}}
                                </small>

                                <small class="text-dark" style="display: block; margin-left: auto;">
                                    {{$recipe->user->name}}
                                </small>
                            </div>

                             <!-- いいね処理-->
                        @include('../layouts/components/.like',[
                            'recipe' => $recipe
                        ])

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>

@endsection
