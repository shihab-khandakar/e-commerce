<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function listing($url){

        $categoryCount = Category::where(['url'=>$url,'status'=> 1])->count();
        if ($categoryCount> 0){
            // echo 'Category exists';die;
            $categoryDetails = Category::catDetails($url);
            // echo '<pre>';print_r($categoryDetails);die;
            $categoryProduct = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1)->get()->toArray();
            // echo '<pre>';print_r($categoryProduct);die;
            return view('front.products.listing',compact('categoryDetails','categoryProduct'));
        }else{
            abort(404);
        }

    }

}
