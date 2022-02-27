<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $bannersTableReacord = [
            ["id"=>1,"image"=>"banner1.png","link"=>"","title"=>"Black jacket","alt"=>"black jacket","status"=>1],
            ["id"=>2,"image"=>"banner2.png","link"=>"","title"=>"Half Sleeve T-Shirt","alt"=>"half sleeve t-shirt","status"=>1],
            ["id"=>3,"image"=>"banner3.png","link"=>"","title"=>"Full Sleeve T-Shirt","alt"=>"full sleeve t-shirt","status"=>1],
        ];

        Banner::insert($bannersTableReacord);


    }
}
