<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
                $categoryProduct = $categoryProduct->paginate(25);


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


    public function productDetail($id){

        $productDetails = Product::with(['category','brand','attributes'=>function($query){
            $query->where('status',1);
        },'images'])->find($id)->toArray();
        // dd($productDetails);
        $totla_stock = ProductAttribute::where('product_id',$id)->sum('stock');
        $relatedProduct = Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->Limit(3)->inRandomOrder()->get()->toArray();
        // echo "<pre>";print_r($relatedProduct);die;
        return view('front.products.details',compact('productDetails','totla_stock','relatedProduct'));

    }


    public function getProductPrice(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            $getDiscountAttrPrice = Product::getDiscountAttrPrice($data['product_id'],$data['size']);

            return $getDiscountAttrPrice;
        }

    }


    public function addToCart(Request $request){

        if($request->isMethod('POST')){
            $data = $request->all();
            // echo '<pre>';print_r($data);die;

            //Check Product Stock is available or not
            $getProductStocks = ProductAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            // echo $getProductStocks['stock'];die;
            if($getProductStocks['stock'] < $data['quantity']){
                $message = 'Required Quantity is not available!!';
                Session::flash('error_message',$message);
                return redirect()->back();
            }

            // Generaet Session id if not exists
            
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            // Save product in cart table

            // Check Product already exists in user cart

            if(Auth::check()){
                //user is logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();
            }else{
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
            }

            
            if($countProducts>0){
                $message = 'Product already exists in cart';
                Session::flash('error_message',$message);
                return redirect()->back();
            }

            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = 'Product has been added in Cart!';
            Session::flash('success_message',$message);
            return redirect('cart');
            
        }

    }

    public function cart(){

        $userCartItems = Cart::userCartItems();
        // echo '<pre>';print_r($userCartItems);die;
        return view('front.products.cart',compact('userCartItems'));

    }

    public function updateCartItemQty(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            //get cart details

            $cartDetails = Cart::find($data['cartid']);
            //get available products stock information
            $availableStock = ProductAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();
            //check stock available or not
            if($data['quantity']>$availableStock['stock']){
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' => false,
                    'message' =>'Product Stock is not available',
                    'view'=>(String)View::make('front.products.cart_item',compact('userCartItems'))
                ]);
            }

            // check size are available or not
            $availableSize = ProductAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize == 0){
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status' =>false,
                    'message' =>'Product size is not available',
                    'view'=>(String)View::make('front.products.cart_item',compact('userCartItems'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['quantity']]);
            $userCartItems = Cart::userCartItems();
            return response()->json([
                'status' => true,
                'view'=>(String)View::make('front.products.cart_item',compact('userCartItems'))
            ]);
        }

    }


    public function deleteCartItem(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>';print_r($data);die;
            Cart::where('id',$data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            return response()->json([
                'view'=>(String)View::make('front.products.cart_item',compact('userCartItems'))
            ]);
        }

    }



}
