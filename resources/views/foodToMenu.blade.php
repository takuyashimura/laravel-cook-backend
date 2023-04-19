@extends('layouts.finely')

@section('content')
    @foreach($food_menus as $food_menu)
        @if(isset($menus["$food_menu->menu_id"]))
            <div class='blue_elea mt-1'>
                <a href="{{ route('menu_cook', $menu_id = $food_menu['menu_id']) }}">
                    <p>{{$menus["$food_menu->menu_id"]->name}}</p>
                </a>
                <div class='d-flex justify-content-end'>
                    <a href="{{ route('menu_edit', $menu_id = $food_menu['menu_id']) }}" class='bg-secondary text-white' style='margin:0px 5px 0px'>
                        編集
                    </a>
                </div>
            </div>
        @else
            @continue
        @endif
    @endforeach
    <div>
        <a href="{{route('home')}}">戻る</a>
    </div>
@endsection

