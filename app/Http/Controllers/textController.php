<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\Text;
use DB;

class textController extends Controller
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
    public function text(Request $request)
    {
        $posts=$request->all();
        $text = key($posts);

        $textTable = Text::exists();
        if($textTable){
            Text::where("user_id" ,"=", 1)
            ->update([
                "text" =>$text
            ]);
            return "textを更新しました";
        }else{
            Text::create([
                "user_id" => 1,
                "text" => $text
            ]);
            return "textを保存しました。";
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