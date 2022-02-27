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
                        <li class="breadcrumb-item active">Catalogs</li>
                        <li class="breadcrumb-item active">Banners</li>
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

                    @if (Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                        {{Session::get('success_message')}}
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Banners</h3>
                            <a href="/admin/add-edit-banner" class="btn btn-block btn-success" style="width:150px;float:right;display:inline-block">Add Banners</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="banners" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Title</th>
                                        <th>Alt</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $banner)
                                    <tr>
                                        <td>{{$banner['id']}}</td>
                                        <td>
                                            <img src="{{asset('images/banner_images/'.$banner['image'])}}" style="width:180px; ">
                                        </td>
                                        <td>{{$banner['link']}}</td>
                                        <td>{{$banner['title']}}</td>
                                        <td>{{$banner['alt']}}</td>
                                        <td>
                                            @if ($banner['status'] == 1)
                                              <a class="updateBannerStatus" id="banner-{{$banner['id']}}" banner_id="{{$banner['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                            @else
                                            <a class="updateBannerStatus" id="banner-{{$banner['id']}}" banner_id="{{$banner['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Inactive"></i></a>
                                            @endif &nbsp;&nbsp;

                                            <a title="Edit Banner" href="{{url('admin/add-edit-banner/'. $banner['id'])}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                            <a title="Delete Banner" href="javascript:void(0)" class="confirmDelete" record="banner" recordid="{{$banner['id']}}"><i class="fa fa-trash"></i></a>

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
