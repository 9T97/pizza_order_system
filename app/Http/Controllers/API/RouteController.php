<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get all product list
    public function productList(){
        $products = Product::get();

        return response()->json($products, 200);
    }

    // get all product list
    public function categoryList(){
        $category = Category::orderBy('id','desc')->get();
        // $products = Product::get();

        // $data = [
        //     'product'=> [
        //         'code lab' => [
        //             'test' => $products
        //         ]
        //     ],
        //     'category' => $category
        // ];
        // return $data['product']['code lab']['test'][0]->name;

        return response()->json($category, 200);
    }


    // get order list
    public function orderList(){
        $orderList = OrderList::select('order_lists.*','users.name as user_name','products.image as product_image','products.name as product_name')
                        ->leftJoin('users','users.id','order_lists.user_id')
                        ->leftJoin('products','products.id','order_lists.product_id')
                        ->get();
        return response()->json($orderList, 200);
    }

    //create category
    public function categoryCreate(Request $request){
        $data = [
            'name'=> $request->name,
            'created_at'=> Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $response = Category::create($data);
        return response()->json($response, 200);
    }


    // create contact
    public function contactCreate(Request $request){
        return $request->all();
    }


    //delete for post
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['ststus'=> true,'message'=>'delete success'], 200);
        }
        return response()->json(['ststus'=>false,'message'=>'There is no you give category_id '], 200);


    }


    // category detail
    public function categoryDetails($id){
        $data = Category::where('id',$id)->first();

        if(isset($data)){
            return response()->json(['ststus'=> true,'category'=>$data], 200);
        }
        return response()->json(['ststus'=>false,'message'=>'There is no you give category_id '], 404);
    }

    //category update
    public function categoryUpadate(Request $request){
        $categoryId = $request->category_id;
        $dbSource = Category::where('id',$categoryId)->first();

        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            $response = Category::where('id',$categoryId)->update($data);
            return response()->json(['ststus'=> true,'message' => 'Category update success','category'=>$response], 200);
        }
        return response()->json(['ststus'=>false,'message'=>'There is no category'], 500);
    }

    // get category data
    private function getCategoryData($request){
        return [
            'name' => $request->category_name,
            'updated_at'=>Carbon::now()
        ];
    }
}
