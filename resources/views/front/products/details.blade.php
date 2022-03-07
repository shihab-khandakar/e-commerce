@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
        <li><a
                href="{{url('/'.$productDetails['category']['url'])}}">{{$productDetails['category']['category_name']}}</a>
            <span class="divider">/</span></li>
        <li class="active">{{$productDetails['product_name']}}</li>
    </ul>
    <div class="row">
        <div id="gallery" class="span3">
            <a href="{{asset('images/product_images/large/'.$productDetails['main_image'])}}"
                title="Blue Casual T-Shirt">
                <img src="{{asset('images/product_images/large/'.$productDetails['main_image'])}}" style="width:100%"
                    alt="Blue Casual T-Shirt" />
            </a>
            <br><br>
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                    <div class="item active">
                        @foreach ($productDetails['images'] as $image)
                        <a href="{{asset('images/product_images/medium/'.$image['image'])}}">
                            <img style="width:29%" src="{{asset('images/product_images/medium/'.$image['image'])}}"
                                alt="" />
                        </a>
                        @endforeach
                    </div>
                </div>
                <!--
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
        -->
            </div>

            <div class="btn-toolbar">
                <div class="btn-group">
                    <span class="btn"><i class="icon-envelope"></i></span>
                    <span class="btn"><i class="icon-print"></i></span>
                    <span class="btn"><i class="icon-zoom-in"></i></span>
                    <span class="btn"><i class="icon-star"></i></span>
                    <span class="btn"><i class=" icon-thumbs-up"></i></span>
                    <span class="btn"><i class="icon-thumbs-down"></i></span>
                </div>
            </div>
        </div>
        <div class="span6">
            <h3>{{$productDetails['product_name']}}</h3>
            <small>{{$productDetails['brand']['name']}}</small>
            <hr class="soft" />
            <small>{{$totla_stock}} items in stock</small>
            <form class="form-horizontal qtyFrm">
                <div class="control-group">
                    <h4 class="getAttrPrice">BDT. {{$productDetails['product_price']}}</h4>
                    <select name="size" id="getPrice" product-id="{{$productDetails['id']}}" class="span2 pull-left">
                        <option value="">Select Size</option>
                        @foreach ($productDetails['attributes'] as $attribute)
                        <option value="{{$attribute['size']}}">{{$attribute['size']}}</option>
                        @endforeach
                    </select>
                    <input type="number" class="span1" placeholder="Qty." />
                    <button type="submit" class="btn btn-large btn-primary pull-right"> Add to cart <i
                            class=" icon-shopping-cart"></i></button>
                </div>
        </div>
        </form>

        <hr class="soft clr" />
        <p class="span6">
            {{$productDetails['description']}}
        </p>
        <a class="btn btn-small pull-right" href="#detail">More Details</a>
        <br class="clr" />
        <a href="#" name="detail"></a>
        <hr class="soft" />
    </div>

    <div class="span9">
        <ul id="productDetail" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Product Details</a></li>
            <li><a href="#profile" data-toggle="tab">Related Products</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="home">
                <h4>Product Information</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr class="techSpecRow">
                            <th colspan="2">Product Details</th>
                        </tr>
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Brand: </td>
                            <td class="techSpecTD2">{{$productDetails['brand']['name']}}</td>
                        </tr>
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Code:</td>
                            <td class="techSpecTD2">{{$productDetails['product_code']}}</td>
                        </tr>
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Color:</td>
                            <td class="techSpecTD2">{{$productDetails['product_color']}}</td>
                        </tr>
                        @if(!empty($productDetails['fabric']))
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Fabric:</td>
                            <td class="techSpecTD2">{{$productDetails['fabric']}}</td>
                        </tr>
                        @endif
                        @if(!empty($productDetails['pattern']))
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Pattern:</td>
                            <td class="techSpecTD2">{{$productDetails['pattern']}}</td>
                        </tr>
                        @endif
                        @if(!empty($productDetails['sleeve']))
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Sleeve:</td>
                            <td class="techSpecTD2">{{$productDetails['sleeve']}}</td>
                        </tr>
                        @endif
                        @if(!empty($productDetails['fit']))
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Fit:</td>
                            <td class="techSpecTD2">{{$productDetails['fit']}}</td>
                        </tr>
                        @endif
                        @if(!empty($productDetails['occasion']))
                        <tr class="techSpecRow">
                            <td class="techSpecTD1">Occasion:</td>
                            <td class="techSpecTD2">{{$productDetails['occasion']}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <h5>Washcare</h5>
                <p>{{$productDetails['wash_care']}}</p>
                <h5>Disclaimer</h5>
                <p>
                    <p>{{$productDetails['meta_description']}}</p>
                </p>
            </div>
            <div class="tab-pane fade" id="profile">
                <div id="myTab" class="pull-right">
                    <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary">
                            <i class="icon-th-large"></i></span>
                    </a>
                </div>
                <br class="clr" />
                <hr class="soft" />
                <div class="tab-content">
                    <div class="tab-pane active" id="blockView">
                        <ul class="thumbnails">
                            @foreach ($relatedProduct as $product)
                            <li class="span3">
                                <div class="thumbnail">
                                    <a href="{{url('product/'.$product['id'])}}">
                                        @if (isset($product['main_image']))
                                        <?php $product_image_path = 'images/product_images/small/'.$product['main_image']; ?>
                                        @else
                                        <?php $product_image_path = ""; ?>
                                        @endif

                                        @if (!empty($product['main_image']) && file_exists($product_image_path))
                                        <img src="{{asset('images/product_images/small/'.$product['main_image'])}}"
                                            alt="">
                                        @else
                                        <img src="{{asset('images/product_images/small/No-Image.png')}}" alt="">
                                        @endif
                                    </a>
                                    <div class="caption">
                                        <h5>{{$product['product_name']}}</h5>
                                        <p>
                                            {{$product['brand']['name']}}
                                        </p>
                                        <h4 style="text-align:center">
                                            <a class="btn" href="{{url('product/'.$product['id'])}}"> <i class="icon-zoom-in"></i></a> 
                                            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a>
                                            <a class="btn btn-primary" href="#">BDT. {{$product['product_price']}}</a>
                                        </h4>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                        <hr class="soft" />
                    </div>
                </div>
                <br class="clr">
            </div>
        </div>
    </div>
</div>

@endsection
