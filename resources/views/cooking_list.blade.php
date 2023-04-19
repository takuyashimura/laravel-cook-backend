@extends('layouts.app')

@section('content')
<div>
    <p>不足分</p>
</div>
<form action="{{route('addBuyListByCoookingList')}}" id="hoge" method="POST">
    @csrf

    @foreach($stocks_food_id as $stock_food_id)
    <div>
        <!-- stockテーブルにfood_idがある＝在庫に登録がないし、在庫自体ない -->
        @if(isset($stocks[$stock_food_id]))
        <!--使用する食材の在庫数                     < リスト上のメニューで使用する食材数      =   在庫が足りなけれな -->
        @if($stocks[$stock_food_id]->total_amount < $food_menus_amount[$stock_food_id]->total_amount)
            <!-- 在庫不足の食材名 -->
            <div class='row bg-danger mt-1'>
                <p>{{ $food[$stock_food_id]["name"] }}</p>
                <!-- 不足数 -->
                <p>不足数{{ $new_array[$stock_food_id]-$stocks[$stock_food_id]->total_amount }}</p>
                <input type="hidden" form="hoge" name="{{$stock_food_id}}"
                    value="{{ $new_array[$stock_food_id]-$stocks[$stock_food_id]->total_amount }}">
            </div>
            @else
            @php $count ++ @endphp
            @continue
            @endif
            @else
            <!-- stockテーブルにデータなし -->
            <div class='row bg-danger mt-1'>
                <p>{{ $food[$stock_food_id]["name"] }}</p>
                <p>不足分{{$new_array[$stock_food_id]}}</p>
            </div>
            <input type="hidden" form="hoge" name="{{$stock_food_id}}" value="{{$new_array[$stock_food_id]}}">
            @endif
    </div>
    @endforeach
    @if($count != $counts)
    <input type="submit" form="hoge" value="不足分を購入リストへ追加する">
    @endif
</form>
@foreach($cooking_list as $value)
<div class='blue_elea mt-1'>
    <div>
        <a href="{{ route('cookingListFoodAmount', $menu_id = $value->menu_id) }}">
            メニュー名→{{$menus[$value->menu_id]->name}}
        </a>
    </div>
    <div>
        <a href="{{ route('cookingListdelete', $id = $value['id'] ) }}">
            削除
        </a>
    </div>

</div>
@endforeach
@if($count == $counts)
<div>
    <a href="{{ route('cooking') }}"> 調理する（使用食材分を食材から減らす）</a>
</div>
@endif

<p>不足分が０になった時に調理ボタンがでてるようにする</p>

@endsection