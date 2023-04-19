<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use App\Models\Foodmenu;
use DB;

class cookingController extends Controller
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

     //食材画面
    public function cooking(Request $request)
    {
        $posts = $request->all();
        // return $posts["cookingList"];
        
        CookingList::whereNull("deleted_at")->update([
            "deleted_at"=> now()
        ]);

        foreach($posts["useList"] as $i){
            // return $i;
            // dd($use_food["total_amount"]);
            $remaining_amount = $i["amount"];
            // return $remaining_amount;
            while($remaining_amount != 0){
               $stock = Stock::whereNull("deleted_at")->where("food_id",'=', $i['id'])->where("user_id","=",1)->orderby("created_at","ASC")->first();
               // 在庫数を充足して消せた場合の処理
                if(isset($stock)){
                    if($stock["amount"] - $remaining_amount >= 0){
                        $stock->decrement('amount', $remaining_amount);
                        $remaining_amount = 0;
                        // 残り必要な数からストックの数を引いて0より大きい場合処理の継続処理
                    } elseif($remaining_amount - $stock["amount"] > 0) {
                        $remaining_amount = $remaining_amount - $stock["amount"];
                        $stock->delete();
                    }
                }else{
                    break;
                }
            }
        }

        return $posts;

        $cooking_lists = CookingList::select("cooking_lists.*")
        ->where("user_id","=",\Auth::id())
        ->whereNull("deleted_at")
        ->orderby("id","DESC")
        ->get();

        // cooking_listにあるメニューで使用する食材の総量を取得する
        $food_menus_food_amount = FoodMenu::select("food_id")
        ->whereNull("deleted_at")
        ->selectRaw("sum(food_amount) as total_amount")
        ->groupby('food_id')
        ->orderby("food_id" ,"ASC")
        ->get()
        ->toArray();

        //food_menusのfood_idを全て取得
        $food_menus = FoodMenu::select("food_menus.*")
        ->whereNull("deleted_at")
        ->orderby("id","ASC")
        ->get()
        ->keyby("id")
        ->toArray();
        $food_menus_menu_id= [];
        foreach($food_menus as $key => $value){
            $food_menus_menu_id[$key]=$value["menu_id"];
        }
        $menu_ids = array_keys($food_menus_menu_id);
        // dd($menu_ids);

        $food_menus_food_ids = [];
        foreach($menu_ids as $value){
            $food_menus_food_ids [] = $food_menus[$value]["food_id"];
        }
        //cooking_listにあるメニューで使用する食材のidを取得
        $food_id = array_unique($food_menus_food_ids);

        //cooking_listで使用する食材の在庫総量を取得する
        $stocks = Stock::select("stocks.*")
        ->where("user_id","=",\Auth::id())
        ->WhereNull("deleted_at")
        ->orderby("created_at","ASC")
        ->get()
        ->keyby("id")
        ->toArray();
        // dd($stocks);
        return $food_menus_food_amount;

        
        foreach($food_menus_food_amount as $use_food){
            // dd($use_food["total_amount"]);
            $remaining_amount = $use_food["total_amount"];
            while($remaining_amount != 0){
               $stock = Stock::where("food_id",'=', $use_food['food_id'])->orderby("created_at","ASC")->first();
               // 在庫数を充足して消せた場合の処理
                if(isset($stock)){
                    if($stock["amount"] - $remaining_amount >= 0){
                        $stock->decrement('amount', $remaining_amount);
                        $remaining_amount = 0;
                        // 残り必要な数からストックの数を引いて0より大きい場合処理の継続処理
                    } elseif($remaining_amount - $stock["amount"] > 0) {
                        $remaining_amount = $remaining_amount - $stock["amount"];
                        $stock->delete();
                    }
                }else{
                    break;
                }
            }
        }
            // const remainingAmount = $use_food["total_amount"] - $stock["food_id"]
            
            // foreach($stocks as $stock){
            //     //$food_menusのfood_idとstockテーブルのfood_idが一致したら
            //     if($use_food["food_id"] == $stock["food_id"]){
            //         if($stock["amount"] - $count < 0){                        
            //             $count = abs($stock["amount"]-$count); 
            //             Stock::where("id",'=', $stock['id'])
            //             ->update(["deleted_at" => now()]);
            //         }

            //         // dd($stock["amount"]);
            //         //もし使用数より在庫数の方が多かったら
            //         // if($count<$stock['amount']){
            //         //     Stock::where("id",'=', $stock['id'])
            //         //     ->decrement("amount",$count);
            //         //     continue;
            //         // }elseif($stock["amount"] == 0){
            //         //     Stock::where("id",'=', $stock['id'])
            //         //     ->update(["deleted_at" => now()]);
            //         //     continue;
            //         // }else
                    
            //     }
                
            // }
        

       



        return redirect( route('home') );
    }
}