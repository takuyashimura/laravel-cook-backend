<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class foodToMenuController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */

     

     //メニュー画面 メニューコントローラを作成し追加する
     public function foodToMenu(Request $request)
     {
        $posts =$request->all();

        $menu = FoodMenu::whereNull("food_menus.deleted_at")
        ->where("food_id","=",$posts["food_stock"]['id'])
        ->leftjoin("menus","food_menus.menu_id" ,"=","menus.id")
        ->select("menus.*")
        ->get();
        
        return [$posts["food_stock"]["name"],$menu];
        // dd($food_id);
         //ここでメニュー名を取得
         $menus= Menu::where("user_id" ,"=", \Auth::id())
         ->whereNull("deleted_at")
         ->orderby('created_at','DESC')
         ->get()
         ->keyby("id");

         $food_menus=FoodMenu::select("food_menus.*")
         ->where("food_id","=",$food_id)
         ->whereNull("deleted_at")
         ->orderby("menu_id")
         ->get()
         ->keyby("menu_id");
        //  dd($food_menus);
 
         //食材を取得
 
         return view('foodToMenu',compact('menus','food_menus'));
     }
    
}