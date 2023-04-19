<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\FoodMenu;
use App\Models\CookingList;
use DB;

class cookingListdeleteController extends Controller
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

     

    // 食材購入画面
    public function cookingListdelete($id)
    {        
        CookingList::where('user_id','=', \Auth::id())
        ->where("id",'=',$id)
        ->update([
            "deleted_at" => now()
        ]);

        
        return redirect( route('cooking_list') );  
    }

    
}


