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
