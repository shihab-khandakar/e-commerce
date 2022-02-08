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
                        <li class="breadcrumb-item active"> Product Attributes</li>
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

            <form action="{{url('admin/add-attributes/'. $productdata['id'])}}" name="attributeForm" id="attributeForm"
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
                                            <input type="text" id="size" name="size[]" value="" placeholder="Size"
                                                style="width:110px" required />
                                            <input type="text" id="sku" name="sku[]" value="" placeholder="SKU"
                                                style="width:110px" required />
                                            <input type="number" id="price" name="price[]" value="" placeholder="Price"
                                                style="width:110px" required />
                                            <input type="number" id="stock" name="stock[]" value="" placeholder="Stock"
                                                style="width:110px" required />
                                            <a href="javascript:void(0);" class="add_button" title="Add field">
                                                &nbsp;Add
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <div>
                                        <img src="{{asset('images/product_images/small/'.$productdata['main_image'])}}"
                                            style=" width:120px; ">
                                    </div>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Attribute</button>
                    </div>
                </div><!-- /.card -->
            </form>

            {{-- Show Product Attribute --}}
            <form action="{{url('admin/edit-attributes/'. $productdata['id'])}}" method="post" name="editAttributeForm" id="editAttributeForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Show Product Attribute</h1>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <table id="product" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Size </th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productdata['attributes'] as $attribute)
                                <input style="display: none" type="text" name="attrId[]" value="{{$attribute['id']}}">
                                <tr>
                                    <td>{{$attribute['id']}}</td>
                                    <td>{{$attribute['size']}}</td>
                                    <td>{{$attribute['sku']}}</td>
                                    <td>
                                        <input type="number" name="price[]" value="{{$attribute['price']}}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="stock[]" value="{{$attribute['stock']}}" required>
                                    </td>
                                    <td>
                                        @if ($attribute['status'] == 1)
                                        <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)">Active</a>
                                        @else
                                        <a class="updateAttributeStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)">Inactive</a>
                                        @endif  &nbsp;
                                        <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record="attribute" recordid="{{$attribute['id']}}"><i class="fa fa-trash"></i></a>
                                    </td>
                                    {{-- <td>
                                        <a title="Add/Edit Attribute" href="{{url('admin/add-attributes/'. $product->id)}}"><i class="fa fa-plus"></i></a>&nbsp;
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
                        <button type="submit" class="btn btn-primary">Update Attribute</button>
                    </div>
                </div>
            </form>


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
