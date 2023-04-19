<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class addMenuEditController extends Controller
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
    public function add_menu_edit(Request $request)
    {
        $posts = $request->all();
        // return $posts;
        $food_data = $posts['postMenuData'];
        $menu_id =$posts["menuName"]["id"];
 
        //編集しているメニューに使用する食材のfood_idを配列として取得

        foreach($food_data as $i){
            if($i['food_amount']!==null){
                if($i['food_amount']===0){
                    FoodMenu::where("menu_id",'=', $menu_id)
                ->where("food_id",'=',$i['id'])
                ->update([
                    "deleted_at" => now()
                ]);
                }else{              
                if(FoodMenu::where("menu_id",'=', $menu_id)
                    ->where("food_id",'=', $i['id'])->exists()){
                    FoodMenu::where("menu_id",'=', $menu_id)
                    ->where("food_id",'=', $i['id'])
                    ->update([
                        "food_amount"=>$i['food_amount']
                    ]);
                }else{
                    FoodMenu::create([
                        "food_id"=>$i['id'],
                        "food_amount"=>$i['food_amount'],
                        "menu_id"=>$menu_id
                    ]);
                }
                    
            }
                
            }
        }

        return "編集完了";

        

        $menus = Menu::select("menus.*")
        ->orderby("id","DESC")
        ->get()
        ->keyby("id");

        //食材のidを配列として取得
        $food_array=Food::select("id")
        ->get()
        ->pluck("id")
        ->toArray();

        $food = Food::select("food.*")
        ->orderby("id","DESC")
        ->get()
        ->keyby("id");

        // 選択されたメニューに使用されていないfood_id
        $results = array_diff($food_array,$food_menus);
        // dd($results);


        return view("add_menu_edit",compact("results","food","menu_id","food_menus","menus"));
    }
    
}