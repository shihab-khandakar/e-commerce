<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductsImage;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Image;

class ProductController extends Controller
{
    
    public function products(){
        Session::put('page','products');
        $products = Product::with(['category'=>function($query){
            $query->select('id','category_name');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        // $products = json_decode(json_encode($products));
        // echo '<pre>'; print_r($products);die;
        return view('admin.products.products',compact('products'));
    }

    public function updateProductStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            Product::where('id', $data['product_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);

        }

    }


    public function addEditProduct(Request $request,$id=null){

        if($id==""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product Added successfully";
            $productdata = array();
        }else{
            $title = "Edit Product";

            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata),true);
            // echo '<pre>'; print_r($productdata);die;
            $message = "Product Updated successfully";
            $product = Product::find($id);

        }

        if($request->isMethod('POST')){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            // Product Validation
            $rules = [
                'category_id'=>'required',
                'brand_id'=>'required',
                'product_name' => 'required | regex:/^[\pL\s-]+$/',
                'product_code' => 'required | regex:/^[\w-]*$/',
                'product_price' => 'required | numeric',
                'product_color' => 'required | regex:/^[\pL\s-]+$/',
            ];
            $customMessage = [
                'category_id.required' => 'Category is required',
                'brand_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.numeric' => 'Valid Product is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Vlid Product Color is required',
            ];

            $this->validate($request,$rules,$customMessage);


            // Save Product data in product table
            if(empty($data['is_featured'])){
                $is_featured = 'No';
            }else{
                $is_featured = 'Yes';
            }

            //Upload Image
            
            if($request->hasFile('main_image')){

                $image_tmp = $request->file('main_image');
                if($image_tmp->isValid()){
                    //get original image name
                    $image_name = $image_tmp->getClientOriginalName();
                    //get original image extentions
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Genarate new image name
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                    //image path
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    //image resize
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    $data['main_image'] = $imageName;
                    //Save main image in the product table
                    $product->main_image = $imageName;

                }

            }

            //upload product Video

            if($request->hasFile('product_video')){
                $video_tmp = $request->file('product_video');

                if($video_tmp->isValid()){
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'-'.rand().'.'.$extension;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    $data['product_video'] = $videoName;
                    //Save video in the product table
                    $product->product_video = $videoName;
                }

            }

            $categoryDetails = Category::find($data['category_id']);
            // echo '<pre>'; print_r($categoryDetails);die;

            $product->section_id = $categoryDetails['section_id'];
            $product->brand_id = $data['brand_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weihgt = $data['product_weihgt'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            $product->save();

            Session::flash('success_message',$message);
            return redirect('admin/products');



        }

        //Product Filters
        $productFilters = Product::productFilters();
        // echo "<pre>";print_r($productFilters);die;
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];

        // Section With Categories and Subcategories

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        // echo '<pre>'; print_r($categories);die;

        // Get All Brands

        $brands = Brand::where('status',1)->get();
        $brands = json_decode(json_encode($brands), true);


        return view('admin.products.add_edit_product',compact('title','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','categories','productdata','brands'));


    }


    public function deleteProductImage($id) {

        //get product image
        $productImage = Product::select('main_image')->where('id',$id)->first();
        //get product image path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        //delete product Small image if exits in small folders
        if(file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
        }
        //delete product medium image if exits in medium folders
        if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
        }
        //delete product large image if exits in large folders
        if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
        }

        //delete product image from product table

        Product::where('id',$id)->update(['main_image'=>""]);

        $message = 'Product image has been deleted';
        Session::flash('success_message',$message);

        return redirect()->back();


    }


    public function deleteProductVideo($id) {
        
        //get product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();
        //get product Video path
        $product_video_path = 'videos/product_videos/';

        //delete product Video from product_videos folders

        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        //delete product Video from category table

        Product::where('id',$id)->update(['product_video'=>""]);

        $message = 'Product Video has been deleted';
        Session::flash('success_message',$message);

        return redirect()->back();


    }



    public function deleteProduct($id){
        Product::where('id',$id)->delete();
        $message = 'Product has been deleted successfully';
        Session::flash('success_message',$message);

        return redirect()->back();
    }



    public function addAttributes(Request $request, $id){

        if ($request->isMethod('POST')){

            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            foreach ($data['sku'] as $key => $value) {

                if(!empty($value)){

                    // Sku alredy exits
                    $attrCountSku = ProductAttribute::where('sku',$value)->count();
                    if($attrCountSku > 0){
                        $message = 'SKU alredy exits. Please add another SKU!';
                        Session::flash('error_message',$message);
                        return redirect()->back();
                    }

                    // Size alredy exits
                    $attrCountSize = ProductAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrCountSize > 0){
                        $message = 'Size alredy exits. Please add another Size!';
                        Session::flash('error_message',$message);
                        return redirect()->back();
                    }

                    $attribute = new ProductAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
                
            $message = 'Product Attribute Added Successfully';
            Session::flash('success_message',$message);
            return redirect()->back();
            

        }

        $productdata = Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo '<pre>'; print_r($productdata);die;
        $title = "Add Product Attributes";

        return view('admin.products.add_attributes',compact('productdata','title'));

    }

    
    public function updateAttributeStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            ProductAttribute::where('id', $data['attribute_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);

        }

    }


    public function editAttributes(Request $request , $id){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;

            foreach($data['attrId'] as $key => $attr){

                if(!empty($attr)){
                    ProductAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);

                }

            }

            $message = 'Product Attribute Updated Successfully';
            Session::flash('success_message',$message);
            return redirect()->back();

        }

    }


    public function deleteAttribute($id){

        ProductAttribute::where('id',$id)->delete();
        $message = 'Attribute has been deleted successfully';
        Session::flash('success_message',$message);

        return redirect()->back();

    }


    public function addImages(Request $request, $id){

        if($request->isMethod('post')){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($request->hasFile('images')){
                // echo "test";die;
                $images = $request->file('images');
                // echo '<pre>'; print_r($images);die;
                foreach($images as $key => $image){
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,99999). time().'.' . $extension;
                    //image path
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    //image resize
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    $data['images'] = $imageName;
                    //Save main image in the product table
                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();

                }

                $message = 'Product images Added Successfully';
                Session::flash('success_message',$message);
                return redirect()->back();
            }
        }

        $productdata = Product::select('id','product_name','product_code','product_color','main_image')->with('images')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo '<pre>'; print_r($productdata);die;


        $title = "Add Product Images";

        return view('admin.products.add_images',compact('productdata','title'));


    }


    public function updateImageStatus(Request $request){

        if($request->ajax()){
            $data = $request->all();
            // echo '<pre>'; print_r($data);die;
            if($data['status']== 'Active'){
                $status= 0;
            }else{
                $status = 1;
            }

            ProductsImage::where('id', $data['image_id'])->update(['status'=> $status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);

        }

    }


    public function deleteImage($id) {

          //get product image
          $productImage = ProductsImage::select('image')->where('id',$id)->first();
          //get product image path
          $small_image_path = 'images/product_images/small/';
          $medium_image_path = 'images/product_images/medium/';
          $large_image_path = 'images/product_images/large/';
  
          //delete product Small image if exits in small folders
          if(file_exists($small_image_path.$productImage->image)){
              unlink($small_image_path.$productImage->image);
          }
          //delete product medium image if exits in medium folders
          if(file_exists($medium_image_path.$productImage->image)){
              unlink($medium_image_path.$productImage->image);
          }
          //delete product large image if exits in large folders
          if(file_exists($large_image_path.$productImage->image)){
              unlink($large_image_path.$productImage->image);
          }
  
          //delete product image from product table
  
          ProductsImage::where('id',$id)->delete();
  
          $message = 'Product image has been deleted';
          Session::flash('success_message',$message);
  
          return redirect()->back();
  

    }





}
