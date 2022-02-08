<?php

namespace Database\Seeders;

use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductsAttributesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $productAttributesRecord = [
            ['id'=>1,'product_id'=>1,'size'=>'Small','price'=>1200,'stock'=>10,'sku'=>'BTC001-S','status'=>1],
            ['id'=>2,'product_id'=>1,'size'=>'Medium','price'=>1300,'stock'=>20,'sku'=>'BTC001-M','status'=>1],
            ['id'=>3,'product_id'=>1,'size'=>'Large','price'=>1400,'stock'=>10,'sku'=>'BTC001-L','status'=>1],
        ];

        ProductAttribute::insert($productAttributesRecord);


    }
}
