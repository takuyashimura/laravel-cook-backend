<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class addMenuFoodController extends Controller
{
    /**
     * Create a new controller instance.
     *a
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


    public function add_menu_food(Request $request)
    {
        $posts=$request->all();
        // dd($posts);
        $menu_id = $posts["menu_id"];
        // dd($menu_id);

        //$posts内でfood_idがキーのデータのみで配列を作り直す
        $results = array_filter($posts, function ($key) {
            return is_int($key);
        }, ARRAY_FILTER_USE_KEY);
        // dd($results);

        foreach($results as $key => $amount){
            if($amount != 0){
                FoodMenu::create([
                    "food_id" => $key,
                    "food_amount" => $amount,
                    "menu_id" => $menu_id
                ]);
            }else{
                continue;
            }
        }
        
       return redirect()->route("menu_edit",["menu_id"=>$menu_id]);  
    }
}


