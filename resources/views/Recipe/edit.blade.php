@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-md-10 mt-6">
        <div class="card-body">
            <h1 class="mt4">レシピ編集</h1>

            <!-- エラーメッセージ-->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors ->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                        @if(empty($errors->first('image')))
                            <li>画像ファイルがあれば再度選択してください</li>
                        @endif
                    </ul>
                </div>
            @endif

            @if(session('message'))

                <div class="alert alert-success">{{session('message')}}</div>

            @endif

            <form method="post" action="{{ route('recipe.update',$recipe) }}" enctype="multipart/form-data">
                @method('put');
                @csrf


                <div class="form-group">
                    <label for="title">レシピ名</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Enter Title" value="{{old('title', $recipe->title)}}" autofocus>
                </div>

                <div class="form-group">
                    <label for="body">作り方</label>
                    <textarea name="body" class="form-control" id="body" cols="30" rows="10" required autocomplete="description" autofocus>{{old('body', $recipe->body)}}</textarea>
                </div>
                <div class="form-group">
                    <label for="category">カテゴリー</label>
                        <select name="category" class="form-control">


                            @foreach ($categorys as $category)

                                <option value="{{$category->id}}">{{$category->name}}</option>



                            @endforeach
                        </select>
                </div>

                <div class="form-group">
                    <label for="body">画像</label>
                    <div class="col-md-6">
                        <input id="image" type="file" name="image">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">変更を保存する</button>

            </form>
        </div>
    </div>
</div>
@endsection




