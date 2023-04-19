@extends('layouts.app')

@section('content')
   <p>{{$menus[$menu_id]->name}}</p>
   @foreach($food_menus as $food_menu)
      <div>
         <p>{{$food[$food_menu->food_id]->name}}</p>
         <input type="number" value="{{$food_menu['food_amount']}}">
         <a href="{{ route('food_menu_food_delet', [$food_menu_id = $food_menu['id'],$menu_id ])}}">削除</a>
      </div>
   @endforeach
   <a href="{{route('add_menu_edit',$menu_id)}}">使用する食材の追加</a>
   <a href="{{route('menu')}}">メニュー一覧に戻る</a>
   <input type="submit" value="変更する">
@endsection
