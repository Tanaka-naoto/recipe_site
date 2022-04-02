@extends('layouts.app')

@section('content')

@if(session('message'))

    <div class="alert alert-success">{{session('message')}}</div>

@endif


<div class="container">

    <div class="ml-2" style="text-align: center; font-size: 1.6em; font-weight: bold">
        カテゴリー一覧
    </div>

    <div class="row g-3 mt-3 mb-5">
        @foreach ($categorys as $category)
            <div class="col-md-4">
                <a href="{{ route('recipe.index', $category) }}" style="text-decoration: none; color: black">
                    <div class="card">
                        <div class="card-img-top image-card image-card-1" >
                            <div class="text-uppercase text-danger fw-bold fs-2" id="category_name">{{$category->name}}</div>
                            <i class="icon" style="font-size: 3rem; "></i>
                        </div>

                        <div class="card-body"> <span class="text-uppercase text-danger fw-bold fs-6" id="bottom_category_name">{{$category->name}}</span>
                             <small class="text-dark"></small>

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>

@endsection
