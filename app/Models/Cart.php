<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';


    public static function userCartItems(){

        if(Auth::check()){
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id','product_name','product_color','main_image');
            }])->where('user_id',Auth::user()->id)->orderBy('id','desc')->get()->toArray();
        }else{
            $userCartItems = Cart::with(['product'=>function($query){
                $query->select('id','product_name','product_color','main_image');
            }])->where('session_id',Session::get('session_id'))->orderBy('id','desc')->get()->toArray();
        }

        return $userCartItems;

    }


    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }

    public static function getProductAttrPrice($product_id,$size){

        $AttrPrice = ProductAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        return $AttrPrice['price'];


    }


}
