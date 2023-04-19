<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\buyController;
use App\Http\Controllers\menu_cookController;
use App\Http\Controllers\menuController;
use App\Http\Controllers\add_menuController;
use App\Http\Controllers\cookingController;
use App\Http\Controllers\cookingListController;
use App\Http\Controllers\textController;
use App\Http\Controllers\menuEditController;
use App\Http\Controllers\deleteController;
use App\Http\Controllers\addMenuEditController;
use App\Http\Controllers\addMenuFoodController;
use App\Http\Controllers\foodToMenuController;
use App\Http\Controllers\stockController;
use App\Http\Controllers\boughtFoodController;
use App\Http\Controllers\cookingListFoodAmountController;
use App\Http\Controllers\cookingListdeleteController;
use App\Http\Controllers\addBuyListByCoookingListController;
use App\Http\Controllers\foodCheckController;

use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// コントローラー、URLには基本的に_を使用しないので編集して無くす
Route::get('/home', [HomeController::class, 'home'])->name('home'); //①
Route::get('/menu', [menuController::class, 'menu'])->name('menu'); //②
Route::get('/add_food', [stockController::class, 'add_food'])->name('add_food'); //③
Route::post('/add', [stockController::class, 'add'])->name('add'); //④
Route::post('/menu_cook', [menu_cookController::class, 'menu_cook'])->name('menu_cook'); //⑤
Route::get('/buy', [buyController::class, 'buy'])->name('buy'); //⑥
Route::get('/add_menu', [add_menuController::class, 'add_menu'])->name('add_menu'); //⑦
Route::post('/add_menu_register', [add_menuController::class, 'add_menu_register'])->name('add_menu_register'); //⑦
Route::post('/add_buy_list', [buyController::class, 'add_buy_list'])->name('add_buy_list');
Route::get('/buy_list', [buyController::class, 'buy_list'])->name('buy_list');
Route::get('/edit_buy_list', [buyController::class, 'edit_buy_list'])->name('edit_buy_list');
Route::post('/reply_buy_list', [buyController::class, 'reply_buy_list'])->name('reply_buy_list');
Route::post('/buy_list_by_edit', [buyController::class, 'buy_list_by_edit'])->name('buy_list_by_edit');
Route::get('/cooking_list', [cookingListController::class, 'cooking_list'])->name('cooking_list');
Route::post('/add_cooking_list', [cookingListController::class, 'add_cooking_list'])->name('add_cooking_list');
Route::post('/text', [textController::class, 'text'])->name('text');
Route::post('/menu_edit', [menuEditController::class, 'menu_edit'])->name('menu_edit');
Route::get('/food_menu_food_delet/{food_menu_id}/menu/{menu_id}', [deleteController::class, 'food_menu_food_delet'])->name('food_menu_food_delet');
Route::post('/menu_delete', [deleteController::class, 'menu_delete'])->name('menu_delete');
Route::post('/add_menu_edit', [addMenuEditController::class, 'add_menu_edit'])->name('add_menu_edit');
Route::post('/add_menu_food', [addMenuFoodController::class, 'add_menu_food'])->name('add_menu_food');
Route::get('/add_menu_edit_completion/{menu_id}', [addMenuEditController::class, 'add_menu_edit_completion'])->name('add_menu_edit_completion');
Route::post('/foodToMenu', [foodToMenuController::class, 'foodToMenu'])->name('foodToMenu');
Route::post('/boughtFood', [boughtFoodController::class, 'boughtFood'])->name('boughtFood');
Route::get('/cookingListFoodAmount/{menu_id}', [cookingListFoodAmountController::class, 'cookingListFoodAmount'])->name('cookingListFoodAmount');
Route::get('/cookingListdelete/{id}', [cookingListdeleteController::class, 'cookingListdelete'])->name('cookingListdelete');
Route::post('/addBuyListByCoookingList', [addBuyListByCoookingListController::class, 'addBuyListByCoookingList'])->name('addBuyListByCoookingList');
Route::post('/cooking', [cookingController::class, 'cooking'])->name('cooking');
Route::post('/food_delete', [deleteController::class, 'food_delete'])->name('food_delete');
Route::post('/foodCheck', [foodCheckController::class, 'foodCheck'])->name('foodCheck');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
});