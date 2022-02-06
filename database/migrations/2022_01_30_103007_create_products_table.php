<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->string('product_color')->nullable();
            $table->float('product_price')->nullable();
            $table->float('product_discount')->nullable();
            $table->float('product_weihgt')->nullable();
            $table->string('product_video')->nullable();
            $table->string('main_image')->nullable();
            $table->text('description')->nullable();
            $table->string('wash_care')->nullable();
            $table->string('fabric')->nullable();
            $table->string('pattern')->nullable();
            $table->string('sleeve')->nullable();
            $table->string('fit')->nullable();
            $table->string('occasion')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->enum('is_featured',['No','Yes'])->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
