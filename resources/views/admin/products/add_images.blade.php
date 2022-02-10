@extends('layouts.admin_layout.admin_layout')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Catalogues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Product</li>
                        <li class="breadcrumb-item active"> Product Images</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- SELECT2 EXAMPLE -->
            @if ($errors->any())
            <div class="alert alert-danger" style="margin-top:10px;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                {{Session::get('success_message')}}
            </div>
            @endif

            @if (Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:10px;">
                {{Session::get('error_message')}}
            </div>
            @endif

            <form action="{{url('admin/add-images/'. $productdata['id'])}}" name="addImageForm" id="addImageForm"
                method="post" enctype="multipart/form-data">
                @csrf

                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{$title}}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product-name">Product Name:</label>&nbsp;&nbsp;
                                    {{$productdata['product_name']}}
                                </div>
                                <div class="form-group">
                                    <label for="product-code">product Code:</label>&nbsp;&nbsp;
                                    {{$productdata['product_code']}}
                                </div>
                                <div class="form-group">
                                    <label for="product-color">product Color:</label>&nbsp;&nbsp;
                                    {{$productdata['product_color']}}
                                </div>

                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <div>
                                            <input type="file" multiple="" id="images" name="images[]" value="" required />
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <div>
                                        <img src="{{asset('images/product_images/small/'.$productdata['main_image'])}}" style=" width:120px; ">
                                    </div>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Images</button>
                    </div>
                </div><!-- /.card -->
            </form>

            {{-- Show Product image --}}
            <form action="{{url('admin/edit-images/'. $productdata['id'])}}" method="post" name="editImageForm" id="editImageForm" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Show Product Images</h1>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="product" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Product Images </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productdata['images'] as $image)
                                <input style="display: none" type="text" name="attrId[]" value="{{$image['id']}}">
                                <tr>
                                    <td>{{$image['id']}}</td>
                                    <td>
                                        <img src="{{asset('images/product_images/small/'.$image['image'])}}" style=" width:120px; ">
                                    </td>
                                    <td >
                                        @if ($image['status'] == 1)
                                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                        @else
                                        <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Inactive"></i></a>
                                        @endif  &nbsp;
                                        <a title="Delete Images" href="javascript:void(0)" class="confirmDelete" record="image" recordid="{{$image['id']}}"><i class="fa fa-trash"></i></a>
                                    </td>
                                    {{-- <td>
                                        <a title="Add/Edit image" href="{{url('admin/add-images/'. $product->id)}}"><i class="fa fa-plus"></i></a>&nbsp;
                                        <a title="Edit Product" href="{{url('admin/add-edit-product/'. $product->id)}}"><i class="fa fa-edit"></i></a>&nbsp;
                                        <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product" recordid="{{$product->id}}"><i class="fa fa-trash"></i></a>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Images</button>
                    </div>
                </div>
            </form>


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
