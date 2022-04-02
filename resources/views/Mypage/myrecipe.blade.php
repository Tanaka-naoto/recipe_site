@extends('layouts.app')

@section('content')


@if(session('message'))

    <div class="alert alert-success">{{session('message')}}</div>

@endif

<div class="ml-2" style="text-align: center; font-size: 1.6em; font-weight: bold">
    マイレシピ
</div>

@if (count($recipes) == 0)
    <p>
        あなたはまだレシピを投稿していません。
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

                            <!-- いいね機能-->
                            <div class="mt-4 about" style="display: flex">

                                @if($recipe->users()->where('user_id', Auth::id())->exists())
                                <!--いいねを外す処理-->
                                <div>
                                    <form method="post" action="{{ route('unfavorites', $recipe) }}">
                                        @csrf

                                        <input type="submit" value="&#xf004;" class="fas fa-heart pr-2" style="background: none; border: none; color: rgb(243, 61, 91)">
                                    </form>
                                </div>

                                @else<!--いいねをする処理-->
                                <div>
                                    <form method="post" action="{{ route('favorites', $recipe) }}">
                                        @csrf

                                        <input type="submit" value="&#xf004;" class="fas fa-heart pr-2" style="background: none; border: none; color: gray">
                                    </form>
                                </div>
                                @endif
                                    <div>{{$recipe->users()->count()}}</div>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>

@endif
@endsection
