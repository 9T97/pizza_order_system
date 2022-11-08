<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // user home page
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    // user change password page
    public function changePassword(){
        return view('user.password.change');
    }

    // change password success
    public function changeNewPassword(Request $request){
        $this->passwordValidationCheck($request);

        $currentUserId = Auth::user()->id;

        $user = User::select('password')->where('id',$currentUserId)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword, $dbHashValue)){
            $data = [
                        'password' => Hash::make($request->newPassword)
                    ];
            User::where('id',Auth::user()->id)->update($data);

            // Auth::logout();
            // return redirect()->route('auth#loginPage');

            return back()->with(['changeSuccess'=>'Password Changed...']);
        }

        return back()->with(['notMatch'=>'the old password not match. Try Again...']);
    }

    //account change page
    public function accountPage(){
        return view('user.profile.account');
    }

    // user account edit update
    public function accountChangeProfile(Request $request,$id){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        //image
        if($request->hasFile('image')){
            // 1. old image name | check => delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('user#accountPage')->with(['updateSuccess'=>'Admin Accound Updated...']);
    }

    //request user data update
    private function getUserData($request){
        return [
            'name'=> $request->name,
            'email'=> $request->email,
            'gender'=> $request->gender,
            'phone'=> $request->phone,
            'address'=> $request->address,
            'updated_at'=>Carbon::now()
        ];
    }

    // account validation check
    private function accountValidationCheck(Request $request){
        Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required',
            'gender'=> 'required',
            'phone'=> 'required',
            'image'=> 'mimes:png,jpg,jpeg|file',
            'address'=> 'required'
        ])->validate();
    }

    // password validation check
    private function passwordValidationCheck(Request $request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ])->validate();
    }



    // filter pizza
    public function filter($id){
        $pizza = Product::where('category_id',$id)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    // pizza details !
    public function pizzaDetails($id){
        $pizza = Product::where('id',$id)->first();
        $pizzaList = Product::get();
        return view('user.main.details',compact('pizza','pizzaList'));
    }

    // cart list
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                        ->leftJoin('products','products.id','carts.product_id')
                        ->where('carts.user_id',Auth::user()->id)->get();

        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price*$c->qty;
        }
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    // user history
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate(5);
        return view('user.main.history',compact('order'));
    }

    // direct user list page
    public function userList(){
        $users = User::where('role','user')->paginate(3);
        return view('admin.user.list',compact('users'));
    }

    // direct user list delete
    public function userDelete($id){
        $user = User::where('id',$id)->delete();
        return redirect()->route('admin#userList')->with(['deleteSuccess'=>'Admin Accound Deleted...']);
    }
     // direct user list detail
     public function userDetail($id){
        $user = User::where('id',$id)->first();
        return view('admin.user.detail',compact('user'));
    }

}
