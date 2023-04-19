@extends('layouts.finely')

@section('content')
<div>
    <form action="{{route('boughtFood')}}" method="POST" >
    @csrf
        <p>購入リスト</p>
        @if($shopping_items->isEmpty())
            <p>購入リストに食材がありません</p>
        @else
        @foreach($shopping_items as $shopping_item)
                <div class="blue_elea d-flex justify-content-between">
                    <p>{{$food[$shopping_item->food_id]->name}}</p>
                    <p>{{$shopping_item->total_amount}}</p>
                </div>
                <input type="hidden" name="{{$food[$shopping_item->food_id]->id}}" value="{{$shopping_item->total_amount}}" >
            @endforeach
            <div>
                <input type="submit" value="購入する" >
            </div>
        @endif
        <div>
            <a href="{{route('edit_buy_list')}}">購入する食材を編集する</a>
        </div>
    </form>
    <form action="{{route('text')}}" method="POST" id="text">
    @csrf
        <!-- メモ機能 -->
        @if(empty($texts))
            <textarea name="text" placeholder="その他買い物メモ"></textarea>
        @else
            <textarea name="text" >{{$texts[0]["text"]}}</textarea>
        @endif
            <input type="submit" form="text" value="保存">
    </form>
</div>

@endsection

