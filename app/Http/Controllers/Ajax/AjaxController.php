<?php

namespace App\Http\Controllers\Ajax;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    // return pizza list
    public function pizzaList(Request $request){
        // logger($request->status);
        if($request->status == 'desc'){
            $data = Product::orderBy('created_at','desc')->get();
        } else {
            $data = Product::orderBy('created_at','asc')->get();
        }

        // return $data;
        return response()->json($data, 200);
    }

    // return cart list
    public function addToCart(Request $request){

        $data = $this->getOrderData($request);
        Cart::create($data);
        // return [
        //     'status' => 'success',
        //     'message' => 'Add To Cart Complete'
        // ];
        $response =[
            'message' => 'Add To Cart Complete',
            'status' => 'success'
        ];
        return response()->json($response, 200);
    }

    //order
    public function order(Request $request){
        $total = 0;
        foreach($request->all() as $item){
            $data = OrderList::create([
                    'user_id' =>$item['user_id'],
                    'product_id' =>$item['product_id'],
                    'qty' =>$item['qty'],
                    'total' =>$item['total'],
                    'orderCode' =>$item['order_code'],
            ]);
            $total += $data->total;
        }

        Cart::where('user_id',Auth::user()->id)->delete();

        Order::create([
            'user_id' =>Auth::user()->id,
            'order_code' => $data->orderCode,
            'total_price' =>$total+3000
        ]);
        return response()->json([ 'status' => 'true', 'message' => 'order completed' ], 200);
    }

    // get order data cart list
    private function getOrderData($request){
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->count,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    // clear cart all
    public function clearCart(){
        Cart::where('user_id',Auth::user()->id)->delete();
    }
    // clear current product
    public function clearProduct(Request $request){
        Cart::where('user_id',Auth::user()->id)
            ->where('product_id',$request->productId)
            ->where('id',$request->cartId)
            ->delete();
    }


    // increase view count
    public function increaseViewCount(Request $request){
        $pizza = Product::where('id',$request->productId)->first();


        $viewCount = [
            'view_count'=>$pizza->view_count + 1
        ];

        Product::where('id',$request->productId)->update($viewCount);
    }


    // clear contact list
    public function ajaxContactList(Request $request){
        Contact::where('user_id',Auth::user()->id)
                ->where('id',$request->contactId)
                ->delete();
    }
}
