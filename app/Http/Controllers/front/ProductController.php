<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{
    
    public function listing(Request $request){
        Paginator::useBootstrap();

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

                // If fabric filters are selected
                if(isset($data['fabric']) && !empty($data['fabric'])){
                    $categoryProduct->whereIn('products.fabric', $data['fabric']);
                }

                // If pattern filters are selected
                if(isset($data['pattern']) && !empty($data['pattern'])){
                    $categoryProduct->whereIn('products.pattern', $data['pattern']);
                }

                // If sleeve filters are selected
                if(isset($data['sleeve']) && !empty($data['sleeve'])){
                    $categoryProduct->whereIn('products.sleeve', $data['sleeve']);
                }

                // If fit filters are selected
                if(isset($data['fit']) && !empty($data['fit'])){
                    $categoryProduct->whereIn('products.fit', $data['fit']);
                }

                // If occasion filters are selected
                if(isset($data['occasion']) && !empty($data['occasion'])){
                    $categoryProduct->whereIn('products.occasion', $data['occasion']);
                }

                // If Sort filters are selected
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
            $url = Route::getFacadeRoot()->current()->uri();
            // echo '<pre>';print_r($url);die;
            $categoryCount = Category::where(['url'=>$url,'status'=> 1])->count();
            if ($categoryCount> 0){
                // echo 'Category exists';die;
                $categoryDetails = Category::catDetails($url);
                // echo '<pre>';print_r($categoryDetails);die;
                $categoryProduct = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);
                // echo '<pre>';print_r($categoryProduct);die;
                $categoryProduct = $categoryProduct->paginate(5);


                //Product Filters
                $productFilters = Product::productFilters();
                // echo "<pre>";print_r($productFilters);die;
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];


                $page_name = 'listing';

                return view('front.products.listing',compact('categoryDetails','categoryProduct','url','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','page_name'));
            }else{
                abort(404);
            }

        }

        

    }

}
