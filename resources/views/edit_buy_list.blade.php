@extends('layouts.finely')

@section('content')
    <form action="{{route('reply_buy_list')}}" id="hoge" method="POST">
    @csrf
    
    @if(isset($shopping_items))
        <p>選択中の食材</p>
        @foreach($shopping_items as $shopping_item)
            <div>
                <p>{{$food[$shopping_item->food_id]["name"]}}</p>
                <input type="number" name="{{$shopping_item->food_id}}"value="{{$shopping_item->total_amount}}">
            </div>
        @endforeach
        
       
        @foreach($food_non as $value)
            <div>
                <p>{{$food[$value]["name"]}}</p>
                <input type="number" name="{{$value}}" value="0">
            </div>
        @endforeach
        <button type="submit" from="hoge">購入リストを修正する</button>
    @else
        <p>食材を追加してください</p>
    @endif
    </form>
@endsection

