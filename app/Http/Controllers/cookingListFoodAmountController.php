<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use DB;

class cookingListFoodAmountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     

     //メニュー画面 メニューコントローラを作成し追加する
     public function cookingListFoodAmount($menu_id)
     {
        // 以下cooking_list画面に不足分を表示させるために必要と判断したのでcooking_list controllerに添付する。必要ないと判断できた場合は
        // controller自体を削除するか、 controllerの名前を変更して活用する
        
        //  food_menusをキーバイmenu_idで取得
        $food = Food::select("food.*")
        ->where("user_id","=", \Auth::id())
        ->whereNull("deleted_at")
        ->orderby("id","DESC")
        ->get()
        ->keyby("menu_id");
        //  クッキングリストをキーバイmenu_idで取得
        $cooking_lists = CookingList::select("cooking_lists.*")
        ->where("user_id","=",\Auth::id())
        ->whereNull("deleted_at")
        ->orderby("id","DESC")
        ->get()
        ->keyby("menu_id");
        //  stocksをキーバイfood_idで取得
        $stocks = Stock::select("stocks.*")
        ->where("user_id")
        ->whereNull("deleted_at")
        ->orderby("food_id","DESC")
        ->get()
        ->keyby("menu_id");



         return view('cookingListFoodAmount');
     }
}


