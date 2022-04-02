@extends('layouts.app')

@section('content')





    <div class="ml-2" style="text-align: center; font-size: 1.6em; font-weight: bold">
        {{$user->name}}さんのレシピ一覧
    </div>

    @if (count($recipes) == 0)
    <p>
        {{$user->name}}さんはまだレシピを投稿していません。
    </p>
    @else

    <div class="container">
    <div class="row g-3 mt-3 mb-5">
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
    @endif
</div>

@endsection
