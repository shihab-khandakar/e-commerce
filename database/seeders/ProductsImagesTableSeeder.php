<?php

namespace Database\Seeders;

use App\Models\ProductsImage;
use Illuminate\Database\Seeder;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $productImageRecord = [
            ['id' =>1,'product_id'=>1,'image' =>'download.png-40312.png','status'=>1],
        ];

        ProductsImage::insert($productImageRecord);


    }
}
