@extends('layouts.app')

@section('content')
<div class='row'>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center'
        style='background-color:powderblue;'>
        <p>{{$menu_name['name']}}</p>
    </div>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center'
        style='background-color:powderblue;'>
        今回使用する<br>食材の編集
    </div>
    <div class='col-4 border d-flex d-flex align-items-center justify-content-center'
        style='background-color:powderblue;'>
        不足している<br>食材を買い物<br>リストに追加する
    </div>
</div>

@csrf
<div>
    <div class='row'>
        <div class='col d-flex d-flex align-items-center justify-content-center'>食材名</div>
        <div class='col d-flex d-flex align-items-center justify-content-center'>不足数</div>
    </div>

    <p>不足している食材</p>
    <form action="http://localhost:8888/add_buy_list" id="hoge" method='POST'>
        @csrf
        <!--  -->
        @foreach($food_menus as $food_menu)
        @if(isset($stocks[$food_menu->food_id]["total_amount"]))
        <!--もしstocksテーブルにデータがあったら  -->
        @if($stocks[$food_menu->food_id]["total_amount"] < $food_menus_amount[$food_menu->food_id]->total_amount)
            <!-- もし在庫が不足していたら-->
            <div class='row bg-danger mt-1'>
                <div class='col '>
                    <p>{{$food[$food_menu->food_id]["name"]}}</p> <!-- 食材名 -->
                    <p>不足数{{$food_menu->food_amount - $stocks[$food_menu->food_id]["total_amount"]}}</p>
                    <!-- 使用食材数-在庫数=不足数 -->
                    @if(isset($shopping_items[$food_menu->food_id]->amount))
                    <!-- もしshopping_listに購入予定のデータが入っていれば -->
                    <p>購入リスト登録数{{$shopping_items[$food_menu->food_id]->amount}}</p> <!-- その購入予定の個数を表示 -->
                    @else
                    <p>購入リスト登録数 0</p> <!-- なければ０と表示 -->
                    @endif
                </div>
            </div>
            <input type="hidden" name="{{$food[$food_menu->food_id]['name']}}"
                value="id_{{$food[$food_menu->food_id]['id']}}">
            <input type="hidden" name="{{$food_menu->food_amount - $stocks[$food_menu->food_id]['total_amount']}}"
                value="amount_{{$food_menu->food_amount - $stocks[$food_menu->food_id]['total_amount']}}">

            @else
            <!-- もし在庫があったら -->
            @continue
            <!-- foreachを抜ける -->
            @endif
            @else
            <!-- もしstocksテーブルに在庫データなければ -->

            <div class='row bg-danger mt-1'>
                <div class='col '>
                    <p>{{$food[$food_menu->food_id]->name}}</p> <!--  -->
                    <p>{{$food_menus_amount[$food_menu->food_id]->total_amount}}</p> <!--  -->
                </div>
            </div>
            @endif

            @endforeach
            <input type="hidden" name="menu_id" value="{{$menu_id}}">
            <div>
                <button type="submit" form="hoge">不足分を購入リストに追加する</button>
            </div>
    </form>

</div>
</div>
---------
<div>
    <p>在庫のある食材</p>
    @foreach($food_menus as $food_menu)
    @if(isset($stocks[$food_menu->food_id]["total_amount"]))
    @if($stocks[$food_menu->food_id]["total_amount"] >= $food_menus_amount[$food_menu->food_id]->total_amount )
    <div class='row blue_elea mt-1'>
        <div class='col '>
            <p>{{$food[$food_menu->food_id]["name"]}}</p>
            <p>在庫数{{$stocks[$food_menu->food_id]["total_amount"]}}</p>
            <p>使用数{{$food_menu->food_amount}}</p>
        </div>
    </div>
    @else
    @continue
    @endif
    @else
    @continue
    @endif
    @endforeach
    <form action="{{route('add_cooking_list')}}" method="POST">
        @csrf
        <input type="hidden" name="menu" value="{{$menu_id}}">
        <button type="submit">調理リストへ</button>
    </form>


</div>
@endsection