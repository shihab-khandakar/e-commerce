@extends('layouts.admin_layout.admin_layout')
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
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
                            <h1 class="card-title">Category</h1>
                            <a href="{{url('admin/add-edit-category')}}" class="btn btn-block btn-success" style="width:150px;float:right;display:inline-block">Add Category</a>
                        </div>
                        <!-- /.card-header -->

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                            {{Session::get('success_message')}}
                            </div>
                        @endif

                        <div class="card-body">
                            <table id="categories" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>category </th>
                                        <th>Parent Category</th>
                                        <th>Section</th>
                                        <th>URL</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Categories as $category)
                                        @if (!isset($category->parentcategory->category_name))
                                        <?php $parentCategory = "Root";?>
                                        
                                        @else
                                        <?php $parentCategory = $category->parentcategory->category_name; ?>
                                            
                                        @endif
                                    <tr>
                                        <td>{{$category->id}}</td>
                                        <td>{{$category->category_name}}</td>
                                        <td>{{$parentCategory}}</td>
                                        <td>{{$category->section->name}}</td>
                                        <td>{{$category->url}}</td>
                                        <td>
                                            @if ($category->status == 1)
                                              <a class="updateCategoryStatus" id="category-{{$category->id}}" category_id="{{$category->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                            @else
                                            <a class="updateCategoryStatus" id="category-{{$category->id}}" category_id="{{$category->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Inactive"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('admin/add-edit-category/'. $category->id)}}">Edit</a>&nbsp;&nbsp;
                                            <a href="javascript:void(0)" class="confirmDelete" record="category" recordid="{{$category->id}}">Delete</a>
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
