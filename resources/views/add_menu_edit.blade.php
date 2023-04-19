@extends('layouts.app')

@section('content')
    <form action="{{route('add_menu_food')}}" id="add" method="POST">
        @foreach($results as $result)
        @csrf
            <div>
                <p>{{$food[$result]->name}}</p>
                <input type="number" name="{{$food[$result]->id}}" value="0">
            </div>
        @endforeach
    <input type="hidden" name="menu_id" value="{{$menu_id}}">
    <input type="submit" form="add" value="使用する食材に追加する">
    </form>    
@endsection
