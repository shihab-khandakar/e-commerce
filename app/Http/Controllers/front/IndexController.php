<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    
    public function index(){

        //get Featured items
        $featuredItemsCount = Product::where('is_featured','Yes')->where('status',1)->count();
        $featuredItems = Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
        // dd($featuredItems);die;
        $featuredItemsChunk = array_chunk($featuredItems,4);
        // echo '<pre>';print_r($featuredItemsChunk);die;

        $newProducts = Product::orderBy('id','desc')->where('status',1)->Limit(6)->get()->toArray();
        // echo '<pre>';print_r($newProducts);die;

        $page_name = 'index';
        return view('front.index',compact('page_name','featuredItemsChunk','featuredItemsCount','featuredItems','newProducts'));
    }


}
