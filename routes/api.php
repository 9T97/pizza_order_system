<?php

use App\Http\Controllers\API\RouteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Get
Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']);
Route::get('order/list',[RouteController::class,'orderList']);




//Post
Route::post('create/category',[RouteController::class,'categoryCreate']);

Route::post('create/contact',[RouteController::class,'contactCreate']);
Route::get('contact/list',[RouteController::class,'contactList']);


// for delete
Route::post('category/delete',[RouteController::class,'deleteCategory']);

// for edit
Route::get('category/list/{id}',[RouteController::class,'categoryDetails']);

Route::post('category/update',[RouteController::class,'categoryUpadate']);

/**
 *
 * product lsit
 * localhost:8000/api/product/list (Get)
 *
 * category list
 * localhost:8000/api/category/list (Get)
 *
 * category list
 * localhost:8000/api/order/list (Get)
 *
 */
