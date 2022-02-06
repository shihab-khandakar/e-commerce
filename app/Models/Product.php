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


}
