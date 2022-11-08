<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\UserController;

Route::middleware(['admin_auth'])->group(function(){
    // login , register
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});


// middleware
Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function(){
        //category
        Route::group(['prefix'=>'category'], function(){
            Route::get('list',[CategoryController::class,'list'])->name('category#list');
            Route::get('createPage',[CategoryController::class,'createPage'])->name('category#createPage');
            Route::post('create',[CategoryController::class,'create'])->name('category#create');
            Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
            Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
            Route::post('update',[CategoryController::class,'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function(){
            // password
            Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password',[AdminController::class,'changePassword'])->name('admin#changePassword');

            //account profile
            Route::get('details',[AdminController::class,'details'])->name('admin#details');
            Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');
            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');

            // admin list
            Route::get('list',[AdminController::class,'list'])->name('admin#list');
            Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');
            Route::get('changeRole/{id}',[AdminController::class,'changeRole'])->name('admin#changeRole');
            Route::post('change/role/{id}',[AdminController::class,'change'])->name('admin#change');

            // ajax admin list
            Route::get('ajax/adminlist',[AdminController::class,'ajaxAdminList'])->name('admin#ajaxAdminList');
            Route::get('ajax/contactlist',[AdminController::class,'ajaxContactList'])->name('admin#ajaxContactList');



        });

        // products
        Route::prefix('products')->group(function(){
            Route::get('list',[ProductController::class,'list'])->name('product#list');
            Route::get('create',[ProductController::class,'createPage'])->name('product#createPage');
            Route::post('create',[ProductController::class,'create'])->name('product#create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
            Route::get('view/{id}',[ProductController::class,'view'])->name('product#view');
            Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');
            Route::post('update',[ProductController::class,'update'])->name('product#update');
        });

        // order
        Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'orderList'])->name('admin#orderList');
            Route::get('Change/status',[OrderController::class,'changeStatus'])->name('admin#changeStatus');
            Route::get('ajax/change/status',[OrderController::class,'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}',[OrderController::class,'listInfo'])->name('admin#listInfo');

        });
        // user lsit detail!
        Route::prefix('user')->group(function(){
            Route::get('list',[UserController::class,'userList'])->name('admin#userList');
            Route::get('ajax/userlist',[AdminController::class,'ajaxUserList'])->name('admin#ajaxUserList');
            Route::get('Delete/{id}',[UserController::class,'userDelete'])->name('admin#userDelete');
            Route::get('Detail/{id}',[UserController::class,'userDetail'])->name('admn#userDetail');
        });

        // contact lsit
        Route::prefix('contact')->group(function(){
            Route::get('list',[ContactController::class,'contactList'])->name('admin#contactList');
        });
    });


    //user home
    Route::group(['prefix'=>'user', 'middleware'=>'user_auth'], function(){
        //  Route::get('home',function(){
        //     return view('user.home');
        //  })->name('user#home');

        Route::get('/homePage',[UserController::class,'home'])->name('user#home');
        Route::get('filter/{id}',[UserController::class,'filter'])->name('user#filter');
        Route::get('/history',[UserController::class,'history'])->name('user#history');

        // user password
        Route::prefix('password')->group(function(){
            Route::get('changePassword',[UserController::class,'changePassword'])->name('user#changePassword');
            Route::post('changeNewPassword',[UserController::class,'changeNewPassword'])->name('user#changeNewPassword');
        });

        // profile account
        Route::prefix('profile')->group(function(){
            Route::get('account',[UserController::class,'accountPage'])->name('user#accountPage');
            Route::post('account/change/{id}',[UserController::class,'accountChangeProfile'])->name('user#changeProfile');
        });

        // javascript ajax
        Route::prefix('ajax')->group(function(){
            Route::get('pizza/list',[AjaxController::class,'pizzaList'])->name('ajax#pizzaList');
            Route::get('addToCart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
            Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
            Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
            Route::get('clear/current/product',[AjaxController::class,'clearProduct'])->name('ajax#clearProduct');
            Route::get('increase/viewCount',[AjaxController::class,'increaseViewCount'])->name('ajax#increaseViewCount');
            Route::get('contactlist',[AjaxController::class,'ajaxContactList'])->name('ajax#ajaxContactList');
        });


        // pizza detail!
        Route::prefix('pizza')->group(function(){
            Route::get('details/{id}',[UserController::class,'pizzaDetails'])->name('user#pizzaDetails');

        });

        // cart detail!
        Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cartList');

        });

        // contact us
        Route::prefix('contact')->group(function(){
            Route::get('list',[ContactController::class,'userContact'])->name('user#userContact');
            Route::get('contactlist',[ContactController::class,'userContactList'])->name('user#userContactList');
            Route::post('contact/send',[ContactController::class,'sendContact'])->name('user#sendContact');
        });

    });
});

Route::get('webTesting',function(){
    $data = [
        'message' => 'this is web testing message'
    ];
    return response()->json($data, 200);
});

