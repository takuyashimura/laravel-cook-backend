<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\User;
use App\Models\CookingList;
use App\Models\FoodMenu;
use DB;

class cookingListController extends Controller
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
    public function cooking_list()
    {
        $cooking_list = CookingList::whereNull("cooking_lists.deleted_at")
        ->leftjoin("menus","cooking_lists.menu_id" ,"=", "menus.id")
        ->select("menus.id","menus.name","cooking_lists.id")
        // ->where("user_id","=",\Auth::id())
        ->orderby("cooking_lists.id","DESC")
        ->get();

        $stocks = Stock::select("food_id")
        // ->where("user_id","=",\Auth::id())
        ->whereNull("deleted_at")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->orderby("food_id","DESC")
        ->get()
        ->keyby("food_id");
        // dd($stocks[0]["total_amount"]);
        
        $cooking_list_food_array =CookingList::whereNull("cooking_lists.deleted_at")
        ->leftjoin("food_menus","cooking_lists.menu_id" ,"=", "food_menus.menu_id")
        ->leftjoin("food","food_menus.food_id","=","food.id")
        ->select("food_menus.menu_id","food_menus.food_id","cooking_lists.id","food_menus.deleted_at","food_menus.food_amount","food.name","food.id",)
        ->whereNull("food_menus.deleted_at")
        // ->where("user_id","=",\Auth::id())
        ->select("food_menus.food_id")
        ->selectRaw('SUM(food_menus.food_amount) AS total_amount')
        ->groupBy('food_menus.food_id')
        ->orderby("food_menus.food_id","DESC");

        $cooking_list_food_data = $cooking_list_food_array
        ->get()
        ->keyby("food_id");
        // dd($cooking_list_food_data);
        $cooking_list_food_name=$cooking_list_food_array
        ->select("food_menus.food_id","food.name")
        ->get()
        ->keyby("food_id");
        // dd($cooking_list_food_name);

        // cooking_listで使う食材の名前、数量を取得し、表示する  →  DBを作成した方がいいか↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $cooking_list_food_name_amount=[];
        foreach($cooking_list_food_data as $i){
            $cooking_list_food_name_amount[]=[
                "id"=>$i["food_id"],
                "food_name"=>$cooking_list_food_name[$i["food_id"]]["name"],
                "amount"=>$i["total_amount"]
            ];
        }
        // dd($cooking_list_food_name_amount);
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
     
        // cooking_listにあるメニューで使用する食材がstocksテーブルにあるか判断する↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $stocks_id = $stocks->pluck("food_id")->toArray();
        // dd($stocks_id);
        $cooking_list_food_data_id = $cooking_list_food_data->pluck("food_id")->toArray();
        // dd($cooking_list_food_data_id);
            // stockテーブルにある食材
        $on_stocks_id_data=array_intersect($stocks_id,$cooking_list_food_data_id);
            // stocksテーブルにない食材
        $non_stocks_id_data = array_diff($cooking_list_food_data_id,$stocks_id);
      
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //stocksテーブルにデータのない食材の不足分を描画する配列を作成↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $non_stocks_data =[];
        foreach($non_stocks_id_data as $id){
            $non_stocks_data []= [
                "id"=>$id,
                "food_name"=>$cooking_list_food_name[$id]->name,
                "amount"=>$cooking_list_food_data[$id]->total_amount
            ];
        }
        // dd($non_stocks_data);
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //stocksテーブルにデータがある食材のうち、在庫不足の食材で配列を作成↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $on_stocks_data=[];
        foreach($on_stocks_id_data as $id){
            if($stocks[$id]["total_amount"] < $cooking_list_food_data[$id]["total_amount"])
            $on_stocks_data []=[
                "id"=>$id,
                "food_name"=>$cooking_list_food_name[$id]->name,
                "amount"=>$cooking_list_food_data[$id]->total_amount - $stocks[$id]["total_amount"]
            ];
        }
        // dd($on_stocks_data);
        
        //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //cooking_listに何人前登録したか調査する ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $cooking_list_name_array = $cooking_list->pluck('name')->toArray();
        // return $cooking_list_name_array;
        $how_many_food=array_count_values($cooking_list_name_array);
        

        $cooking_list_name_counts=[];
        foreach($how_many_food as $key => $value){
            $cooking_list_name_counts []=[
                "name"=> $key,
                "count"=>$value
            ];
        }
        $cooking_list_name_count = array_unique($cooking_list_name_counts,SORT_REGULAR);
        
        
        // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        
        
        
        return response()->json([
            "cooking_list_name_count"=>$cooking_list_name_count,
            "cooking_list"=>$cooking_list,            
            "non_stocks_data"=>$non_stocks_data,            
            "on_stocks_data"=>$on_stocks_data,            
            "cooking_list_food_name_amount"=>$cooking_list_food_name_amount,            
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );

        $menus = Menu::select("menus.*")
        ->orderby("created_at")
        ->get()
        ->keyby("id");

        $food_menus = FoodMenu::select("food_menus.*")     
        ->whereNull("deleted_at") 
        ->get()
        ->pluck('menu_id')
        ->toArray();
        // dd($food_menus);

        $food_menus_amount = FoodMenu::select("food_id")     
        ->whereNull("deleted_at") 
        ->selectRaw('SUM(food_amount) AS total_amount')
        ->groupBy('food_id')
        ->orderby("food_id","DESC")
        ->get()
        ->keyby("food_id");
        
        $food_menus_normal = FoodMenu::select("food_menus.*")     
        ->whereNull("deleted_at") 
        ->get()
        ->toArray();

        $stocks = Stock::select("food_id")
        ->where("user_id","=",\Auth::id())
        ->whereNull("deleted_at")
        ->selectRaw('SUM(amount) AS total_amount')
        ->groupBy('food_id')
        ->orderby("food_id","DESC")
        ->get()
        ->keyby("food_id");
        
        //cooking_listにあるメニューのmenu_idを抽出する
        

        //keyby('menu_id')でfood_menuのデータを取得すると、同一のkey（今回はmenu_id)を保有しているデータがfood_menusテーブル上に複数あったとしても一つのデータしたしか取得できない
        //すると、メニューで使用してる食材全てのfood_idを取得できないので、一旦、cooking_listにあるメニューのidを抽出し、そのidをidカラムに保有するレコードのfood_idを取得するという順番でfood_idを求めた
        $food_menus_food_id = [];
        foreach($cooking_list as $item){
            $items=array_keys($food_menus,$item->menu_id);//cooking_listにあるメニューのidをforeachで回して、food_menuテーブルにその値があった場合、配列$food_menus_food_idにその値を追加する
            $food_menus_food_id[] = $items;
        }
        // dd($food_menus_food_id);
        $food_id_index = array_reduce($food_menus_food_id, 'array_merge', []);//$food_id_indexが二次元配列なので配列として再構成するコーディング
        // dd( $food_id_index );
        //cooking_listにあるメニューで称する食材を全て抽出する→food_idを抽出
        $food_menus_food_ids = [];
        foreach($food_id_index as $food_id){//取得したインデックスでそのインデックスが示すデータが所有するfood_idを抽出する
            $food_menus_food_ids [] = $food_menus_normal[$food_id]['food_id'];
        }
        // dd($food_menus_food_ids);
        // 重複しているvalueは統合する→
        $stocks_food_id = array_values(array_unique($food_menus_food_ids));
        // dd($stocks_food_id);
        //$stockに何種類の食材の在庫数があるかカウントする
        $counts = count($stocks_food_id);
        // dd($stocks_food_id);
        

        $food = Food::select("food.*")
        ->where("user_id","=", \Auth::id())
        ->whereNull("deleted_at")
        ->orderby("id","DESC")
        ->get()
        ->keyby("id");

        $count = 0;
        //不足分の計算に必要な情報
        $food_menu_on_cooking_lists = [];
        foreach($cooking_list as $value){
            $food_menu_on_cooking_lists [] = FoodMenu::select("food_id","food_amount")
            ->where("menu_id", "=", $value->menu_id)
            ->whereNull("deleted_at")
            ->get()
            ->toArray();
        }
        //連想配列から配列に修正
        $food_menu_on_cooking_list = array_reduce($food_menu_on_cooking_lists, 'array_merge', []);
        // dd($food_menu_on_cooking_list);
        //同じfood_idを持っているレコードのtotal_amountを合計し、そのレコードを統合する
        $new_array = array();
        foreach ($food_menu_on_cooking_list as $item) {
            $food_id = $item["food_id"];
            $total_amount = $item["food_amount"];
            if (array_key_exists($food_id, $new_array)) {
                // 同じfood_idが既に存在する場合は、total_amountに加算する
                $new_array[$food_id] += $total_amount;
            } else {
                $new_array[$food_id] = $total_amount;
            }
        }
        return response()->json([
            "cooking_list"=>$cooking_list,            
        ],
        200,
        [],
        JSON_UNESCAPED_UNICODE //文字化け対策
        );






        return view('cooking_list',compact("menus","food_menus","stocks","food_menus_food_id","food","cooking_list","stocks_food_id","food_menus_amount","count","counts","new_array"));
    }


    public function add_cooking_list(Request $request)
    {
        $posts=$request->all();
        // return $posts;
        $menu_id =  $posts["id"];

        Cookinglist::create([
            "menu_id" => $menu_id,
            "user_id" => 1,
        ]);

        return "調理リストへ登録完了";


        return redirect( route('cooking_list') );  
    }

   


}    