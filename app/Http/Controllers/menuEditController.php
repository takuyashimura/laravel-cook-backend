<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use DB;

class menuEditController extends Controller
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
    public function menu_edit(Request $request)
    {
        $posts=$request->all();
        
        $menu_id = $posts["menu"]["id"];

        $menu_data = [
            "id"=>$menu_id,
            "name"=>$posts["menu"]["name"]
        ];



        $food_menu = FoodMenu::whereNull("food_menus.deleted_at")
        ->where("food_menus.menu_id","=",$menu_id)
        ->leftjoin("food","food_menus.food_id","=","food.id")
        ->whereNull("food.deleted_at");
        

        $food_menu_data= $food_menu ->select("food.name","food_menus.food_amount","food.id")->get();

        $food_menus= $food_menu->select("food.name","food.id") -> get()->pluck("name")->toArray();
        // return $food_menus;
        $food = Food::select('food.name',"food.id")->whereNull("food.deleted_at")->get()->pluck("name")->toArray();
        // return $food;
        $unused_food = array_diff($food,$food_menus);
        // return $unused_food;

        $unused=[];
        foreach ($unused_food  as $key =>$value){
            $foods=Food::select("food.name","food.id")->whereNull("deleted_at")->get();
            foreach($foods as $f)
            if($f["name"]===$value)
                $unused[]= [
                    "id"=> $f["id"],
                    "name" => $value,
                    "food_amount"=>null
            ];
        }

        $food_array  = array_merge( $food_menu_data->toArray(),$unused);
        // return $food_array;

        // return [$menu_name,$food_menu_data];

        return response()->json([
            "menuData"=>$menu_data,
            "foodArray"=>$food_array
            
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );
        


        return view('menu_edit',compact("menus","menu_id","food","food_menus"));
    }

   


    

   
}