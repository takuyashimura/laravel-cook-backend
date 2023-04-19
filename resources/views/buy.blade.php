@extends('layouts.finely')

@section('content')
    <div>

        @foreach($stocks as $stock) 
            <div class='blue_elea d-flex justify-content-between '>
                <p>{{ $food[$stock->food_id]->name }}</p>
                <p>{{ $stock['total_amount'] }}</p>
                <input type="number" name='amount' min='0' max='100'>
            </div>
        @endforeach 

        
        @foreach($array as $array)
            <div class="bg-danger mt-1">
                <p>{{ $food[$array]->name }}</p>
                <p>在庫なし</p>
            </div>
        @endforeach
        <!-- stocksテーブルにデータはあるが、在庫がない時のコードを書く -->
      
    </div>
        <div class='text-center'>
                <button  type='submit'>新しい食材を<br>追加</button>
        </div>
@endsection
