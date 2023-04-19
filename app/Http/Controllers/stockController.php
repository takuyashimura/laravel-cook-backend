<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;


class stockController extends Controller
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
    public function index()
    {
        //ここで食材名を取得する
        $food = Food::select('food.*')
        ->where('user_id', '=', \Auth::id())
        ->orderby('created_at', 'DESC')
        ->get();
        $menus = User::find(1)->get();

        return view('create', compact('food'));
    }

    //メニュー画面 フードコントローラーを作成し追加する
    public function add_food()
    {
        return view('add_food');
    }
    //食材を追加した時の処理
    public function add(Request $request)
    {
        $post =$request->all();
        $foodName = key($post);
        // return $foodName;

        $food =Food::whereNUll("deleted_at")->where("name", "=", $foodName)->exists();
        if ($food === false) {
            Food::create([
                "user_id"=>1,
                "name"=>$foodName
                ])
            ->save();
            return "登録完了";
        } else {
            return "この食材はすでに登録されています。";
        }
    }
}



       