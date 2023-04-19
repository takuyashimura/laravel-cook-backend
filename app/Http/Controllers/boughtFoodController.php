<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use App\Models\ShoppingItem;
use DB;

class boughtFoodController extends Controller
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
     public function boughtFood(Request $request)
     {
         $posts=$request->all();
        //  dd($posts);
        
        // dd($post);

         foreach($posts as $post){
            Stock::create([
                "food_id" => $post['food_id'],
                "user_id" => 1,
                "amount" => $post["total_amount"]
            ]);

            
         }
         ShoppingItem::whereNull("deleted_at")
         ->update(["deleted_at" => now()]);
         
         
 
        return redirect(route('home'));  
     }


}    