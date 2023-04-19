<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use DB;

class menuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Supposrt\Renderable
     */

     

     //メニュー画面 メニューコントローラを作成し追加する
     public function menu()
     {
         //ここでメニュー名を取得
         $menus= Menu::
        //  where("user_id" ,"=", \Auth::id())
         whereNull("deleted_at")
         ->select("menus.id","menus.user_id","menus.name")
         ->orderby('created_at','DESC')
         ->get();
 
         return response()->json([
            "menus" => $menus,
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );

     }
}