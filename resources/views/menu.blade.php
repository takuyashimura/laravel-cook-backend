@extends('layouts.app')

@section('content')
        <div class='blue_elea rounded-pill w-25' style='text-align:center'>
        <a href="http://localhost:8888/add_menu">
            メニュー追加
        </a>
        </div>
        @foreach ($menus as $menu)
        <div class='blue_elea mt-1'>
            <a href="{{ route('menu_cook', $menu_id = $menu['id']) }}">
                <p class='text-center'>{{ $menu['name']}}</p>
            </a>    
            
            <div class='d-flex justify-content-end'>
                <a href="{{ route('menu_delete', $menu_id = $menu['id']) }}" class='bg-secondary text-white' style='margin:0px 5px 0px'>
                    削除
                </a>
                <a href="{{ route('menu_edit', $menu_id = $menu['id']) }}" class='bg-secondary text-white' style='margin:0px 5px 0px'>
                    編集
                </a>
            </div>
        </div>
        @endforeach
@endsection
