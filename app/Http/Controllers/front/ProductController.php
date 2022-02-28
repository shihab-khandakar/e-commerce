<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function listing($url, Request $request){

        if($request->ajax()){

            $data = $request->all();
            // echo "<pre>";print_r($data);die;
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url,'status'=> 1])->count();
            if ($categoryCount> 0){
                // echo 'Category exists';die;
                $categoryDetails = Category::catDetails($url);
                // echo '<pre>';print_r($categoryDetails);die;
                $categoryProduct = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                // echo '<pre>';print_r($categoryProduct);die;

                // If Sort options selected bt users
                if(isset($data['sort']) && !empty($data['sort'])){
                    if($data['sort']== 'product_latest'){
                        $categoryProduct->orderBy('id', 'Desc');
                    }else if($data['sort']== 'product_name_a_z'){
                        $categoryProduct->orderBy('product_name', 'Asc');
                    }else if($data['sort']== 'product_name_z_a'){
                        $categoryProduct->orderBy('product_name', 'Desc');
                    }else if($data['sort']== 'price_lowest'){
                        $categoryProduct->orderBy('product_price', 'Asc');
                    }else if($data['sort']== 'price_highest'){
                        $categoryProduct->orderBy('product_price', 'Desc');
                    }
                }else{
                    $categoryProduct->orderBy('id', 'Desc');
                }

                $categoryProduct = $categoryProduct->paginate(25);

                return view('front.products.ajax_products_listing',compact('categoryDetails','categoryProduct','url'));
            }else{
                abort(404);
            }



        }else{

            $categoryCount = Category::where(['url'=>$url,'status'=> 1])->count();
            if ($categoryCount> 0){
                // echo 'Category exists';die;
                $categoryDetails = Category::catDetails($url);
                // echo '<pre>';print_r($categoryDetails);die;
                $categoryProduct = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                // echo '<pre>';print_r($categoryProduct);die;
                $categoryProduct = $categoryProduct->paginate(25);

                return view('front.products.listing',compact('categoryDetails','categoryProduct','url'));
            }else{
                abort(404);
            }

        }

        

    }

}
