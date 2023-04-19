@extends('layouts.finely')

@section('content')

    <form action="http://localhost:8888/add_menu_register" method='POST'>
    @csrf
        <div>
            <input type="text" name="menu_name" placeholder="登録するメニュー名">
        </div>
        <div>
            <p>
                使用する食材
            </p>
            @foreach($food as $food)
                    <div class="d-flex justify-content-between">        
                        <p>
                            {{$food->name}}
                        </p>
                        <input type="number" name="food_ids[{{$food->id}}]" min='0' max='100'>
                    </div> 
            @endforeach
            <div>
                <button style="display: block; margin: auto;" type='submit'>メニューを追加</button>
            </div>
        </div>
    </form>   
        

@endsection
    