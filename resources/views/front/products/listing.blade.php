@extends('layouts.front_layout.front_layout')
@section('content')

<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
        <li class="active"><?php echo $categoryDetails['bradcrumbs']; ?></li>
    </ul>
    <h3> {{$categoryDetails['catDetails']['category_name']}} <small class="pull-right"> {{count($categoryProduct)}} products are available </small></h3>
    <hr class="soft"/>
    <p>
        {{$categoryDetails['catDetails']['description']}}
    </p>
    <hr class="soft"/>
    <form name="sortProducts" id="sortProducts" class="form-horizontal span6">
        <input type="hidden" name="url" id="url" value="{{$url}}">
        <div class="control-group">
            <label class="control-label alignL">Sort By </label>
            <select name="sort" id="sort">
                <option value="">Select</option>
                <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']=='product_latest') selected="" @endif>Latest product</option>
                <option value="product_name_a_z" @if(isset($_GET['sort']) && $_GET['sort']=='product_name_a_z') selected="" @endif>Product name A - Z</option>
                <option value="product_name_z_a" @if(isset($_GET['sort']) && $_GET['sort']=='product_name_z_a') selected="" @endif>Product name Z - A</option>
                <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']=='price_lowest') selected="" @endif>Lowest Price first</option>
                <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort']=='price_highest') selected="" @endif>Highest Price first</option>
            </select>
        </div>
    </form>
    
    <br class="clr"/>
    <div class="tab-content filter_products">
        @include('front.products.ajax_products_listing')
    </div>
    <a href="compair.html" class="btn btn-large pull-right">Compair Product</a>
    <div class="pagination">
        @if(isset($_GET['sort']) && !empty($_GET['sort']))
            {{$categoryProduct->appends(['sort' => $_GET['sort']])->links()}}
        @else
            {{$categoryProduct->Links()}}
        @endif
    </div>
    <br class="clr"/>
</div>

@endsection