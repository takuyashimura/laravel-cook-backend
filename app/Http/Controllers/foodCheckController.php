<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\FoodMenu;
use App\Models\Stock;
use App\Models\User;
use App\Models\Text;
use DB;

class foodCheckController extends Controller
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
    public function foodCheck(Request $request)
    {
        $posts = $request->all();

     
        if(FoodMenu::select("food_menus.*")->whereNull("deleted_at")->where("food_id",'=',$posts["id"])->exists()){
            return "メニューの材料として登録されているため削除できません";
        }else{
            return "削除できます";
        }




        // $text = Text::select("texts.*")
        // ->get();
        // if($posts["text"]!=null){
        //     if(isset($text)){
        //         Text::create([
        //             "user_id" => \Auth::id(),
        //             "text" => $posts["text"]
        //         ]);
        //     }else{
        //         Text::where("user_id", "=", \Auth::id())
        //         ->save([
        //             "text" => $posts["text"]
        //         ]);
        //     }
        // }

        // //データベースのデータ量がずっと増え続けるので、コードを変えた方がいいか相談

        // return redirect( route('buy_list') );
    }
}