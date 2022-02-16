<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';

    protected $fillable = [
        'name','status'
    ];

    public static function sections(){
        $getSection = Section::with('categories')->where('status',1)->get();
        $getSection = json_decode(json_encode($getSection), true);
        // echo '<pre>'; print_r($getSection);die;
        return $getSection;
    }

    public function categories(){
        return $this->hasMany('App\Models\Category','section_id')->where(['parent_id'=>'ROOT','status'=>1])->with('subcategories');
    }

}
