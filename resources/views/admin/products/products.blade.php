@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Product</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Product</h1>
                            <a href="/admin/add-edit-product" class="btn btn-block btn-success" style="width:150px;float:right;display:inline-block">Add Product</a>
                        </div>
                        <!-- /.card-header -->

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                            {{Session::get('success_message')}}
                            </div>
                        @endif

                        <div class="card-body">
                            <table id="product" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name </th>
                                        <th>Product Image </th>
                                        <th>Product Code</th>
                                        <th>Product Color</th>
                                        <th>Category</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                      
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>
                                            <?php $product_image_path = "images/product_images/small/".$product->main_image; ?>
                                            @if(!empty($product->main_image) && file_exists($product_image_path))
                                            <img src="{{asset('images/product_images/small/'.$product->main_image)}}" style="width:100px" >
                                            @else
                                            <img src="{{asset('images/product_images/small/No-Image.png')}}" style="width:100px" >
                                            @endif
                                        </td>
                                        <td>{{$product->product_code}}</td>
                                        <td>{{$product->product_color}}</td>
                                        <td>{{$product->category->category_name}}</td>
                                        <td>{{$product->section->name}}</td>
                                        <td>
                                            @if ($product->status == 1)
                                              <a class="updateProductStatus" id="product-{{$product->id}}" product_id="{{$product->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                            @else
                                            <a class="updateProductStatus" id="product-{{$product->id}}" product_id="{{$product->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Inactive"></i></a>
                                            @endif
                                        </td>
                                        <td style=" width:100px;">
                                            <a title="Add/Edit Attribute" href="{{url('admin/add-attributes/'. $product->id)}}"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;
                                            <a title="Add Images" href="{{url('admin/add-images/'. $product->id)}}"><i class="fa fa-plus-circle"></i></a>&nbsp;&nbsp;
                                            <a title="Edit Product" href="{{url('admin/add-edit-product/'. $product->id)}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                            <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{$product->id}}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@endsection
