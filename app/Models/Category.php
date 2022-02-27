<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id','section_id','category_name','category_image','category_discount','description','url','meta_title','meta_description','meta_keywords','status'
    ];



    public function subcategories(){
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id')->select('id','name');
    }

    public function parentCategory(){
        return $this->belongsTo('App\Models\Category','parent_id')->select('id','category_name');
    }

    public static function catDetails($url){

        $catDetails = Category::select('id','parent_id','category_name','url','description')->with(['subcategories'=> function($query){
            $query->select('id','parent_id','category_name','url','description')->where('status',1);
        }])->where('url',$url)->first()->toArray();
        // dd($catDetails);die;
        if($catDetails['parent_id']==0){
            // Only show main category in Bradcame
            $bradcrumbs = '<a href="'.url($catDetails['url']).'">'.$catDetails['category_name'].'</a>';
        }else{
            $parentCategory = Category::select('category_name','url')->where('id',$catDetails['parent_id'])->first()->toArray();
            $bradcrumbs = '<a href="'.url($parentCategory['url']).'">'.$parentCategory['category_name'].'</a>&nbsp; <span class="divider">/</span> &nbsp;<a href="'.url($catDetails['url']).'">'.$catDetails['category_name'].'</a>';
        }

        $catIds = array();
        $catIds[] = $catDetails['id'];
        foreach($catDetails['subcategories'] as $key => $subCategory){
            $catIds[] = $subCategory['id'];
        }
        // dd($catIds);die;
        return array('catIds'=>$catIds,'catDetails'=>$catDetails,'bradcrumbs'=>$bradcrumbs);

    }


}
