@extends('layouts.app')

@section('content')
    <div>
        <a href="{{route('add_food')}}">
            <div class='blue_elea' style='text-align:center rounded-pill'>新しい食材を<br>追加</div>
        </a>
        @foreach($stocks as $stock) 
            <a href="{{route('foodToMenu' ,$food_id = $stock->food_id)}}">
                <div class='blue_elea d-flex justify-content-between '>
                    <p>{{ $food[$stock->food_id]->name }}</p>
                    <p>{{ $stock['total_amount'] }}</p>
                </div>
            </a>
        @endforeach 

        <!-- stocksテーブルにfood_idがない→在庫がないと判断する -->
        @foreach($array as $array)
            <a href="{{route('foodToMenu' ,$food_id = $array)}}">
                <div class='blue_elea d-flex justify-content-between '>
                    <p>{{ $food[$array]->name }}</p>
                    <p>0</p>
                </div>
            </a>
        @endforeach
        
        <!-- stocksターブルにidはあるが在庫数が0の時のコーディングをする -->

    </div>
@endsection
