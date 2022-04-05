@extends('layouts.app')

@section('content')

@if(session('message'))
    <div class="alert alert-success">{{session('message')}}</div>
@endif



<div class="container">


    <div class="ml-2 mb-3" style="text-align: center; font-size: 1.6em; font-weight: bold">
        ユーザー一覧
    </div>
    <?php
    // dd($users);
    ?>
    <div class="row g-3 mt-3 mb-5">
        @foreach ($users as $user)


            <div class="col-md-4">
                <a href="{{ route('user_recipes', $user) }}" style="text-decoration: none; color: black">

                    <div class="card">

                            <div class="card-img-top image-card" style="background: url({{asset('storage/images/default.jpg')}})no-repeat center center; background-size:cover;"></div>


                        <div class="card-body">

                            <span class="text-uppercase text-danger fw-bold fs-6">
                                {{$user->name}}
                            </span>

                            @if(auth()->user()->id == 8)
                            <div class="wrp d-flex justify-content-end">
                                <a href="{{route('profile.edit', $user->id)}}">
                                    <button class="btn btn-primary">
                                        編集
                                    </button>
                                </a>

                                <form method="post" action="{{route('profile.delete', $user->id)}}" style="margin-left:7px">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger" onClick="return confirm('本当に削除しますか？');">
                                        削除
                                    </button>
                                </form>
                            </div>
                            @endif

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>

@endsection
