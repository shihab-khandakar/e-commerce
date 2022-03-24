<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table;

    protected $fillable = ['category_id','section_id','product_name','product_code','product_color','product_price','product_discount','product_weihgt','product_video','main_image','description','wash_care','fabric','pattern','sleeve','fit','occasion','meta_title','meta_description','meta_keywords','is_featured','status'];



    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductAttribute');
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }


    public static function productFilters(){

        $productFilters['fabricArray'] = array('Cotton','Polyester','Wool');
        $productFilters['sleeveArray'] = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $productFilters['patternArray'] = array('Checked','Plain','Printed','Self','Solid');
        $productFilters['fitArray'] = array('Regular','Slim');
        $productFilters['occasionArray'] = array('Casual','Formal');

        return $productFilters;

    }


    public static function getDiscountPrice($product_id){

        $productDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $categoryDetails = Category::select('category_discount')->where('id',$productDetails['category_id'])->first()->toArray();

        if($productDetails['product_discount']>0){
            // if product discount is added form admin panel
            $discounted_price = $productDetails['product_price'] - ( $productDetails['product_price'] * $productDetails['product_discount'] / 100);
        }else if($categoryDetails['category_discount']>0){
            // if product discount is not added and category discount added form admin panel
            $discounted_price = $productDetails['product_price'] - ( $productDetails['product_price'] * $categoryDetails['category_discount'] / 100);

        }else{
            $discounted_price = 0;
        }

        return $discounted_price;

    }


    public static function getDiscountAttrPrice($product_id,$size){

        $productAttrPrice = ProductAttribute::where(['product_id'=>$product_id, 'size'=>$size])->first()->toArray();
        $productDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $categoryDetails = Category::select('category_discount')->where('id',$productDetails['category_id'])->first()->toArray();

        if($productDetails['product_discount']>0){
            // if product discount is added form admin panel
            $final_price = $productAttrPrice['price'] - ( $productAttrPrice['price'] * $productDetails['product_discount'] / 100);
            $discount = $productAttrPrice['price'] - $final_price;
        }else if($categoryDetails['category_discount']>0){
            // if product discount is not added and category discount added form admin panel
            $final_price = $productAttrPrice['price'] - ( $productAttrPrice['price'] * $categoryDetails['category_discount'] / 100);
            $discount = $productAttrPrice['price'] - $final_price;

        }else{
            $final_price = $productAttrPrice['price'];
            $discount = 0;
        }

        return array('product_price'=>$productAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);

    }


}
