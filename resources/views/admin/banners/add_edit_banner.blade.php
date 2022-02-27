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
                        <li class="breadcrumb-item active">Banners</li>
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

            <form @if (empty($banner['id']))
                action="{{url('admin/add-edit-banner')}}"
                @else
                action="{{url('admin/add-edit-banner/'.$banner['id'])}}"
            @endif 
            name="bannerForm" id="bannerForm" method="post" enctype="multipart/form-data">
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
                                <label for="exampleInputFile">Banner Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                                <div>Recommended Image Size: Width:1170px, Height:480px)</div>

                                @if (!empty($banner['image']))

                                    <div>
                                        <img src="{{asset('images/banner_images/'.$banner['image'])}}" style="margin-top:5px; margin-bottom:5px; width:150px; ">
                                        {{-- <a href="{{url('admin/delete-banner-image/'.$banner['id'])}}">Delete Image</a> --}}
                                    </div>
                                    
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="banner-link">Banner Link</label>
                                <input type="text" class="form-control" name="link" id="link"
                                    placeholder="Enter Link Name"
                                    @if (!empty($banner['link']))
                                        value="{{$banner['link']}}"
                                        @else
                                        value="{{old('link')}}"
                                    @endif
                                    >
                            </div>
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="banner-title">Banner Title</label>
                                <input type="text" class="form-control" name="title" id="title"
                                    placeholder="Enter Title Name"
                                    @if (!empty($banner['title']))
                                        value="{{$banner['title']}}"
                                        @else
                                        value="{{old('title')}}"
                                    @endif
                                    >
                            </div>
                            <div class="form-group">
                                <label for="banner-alt">Banner Alternat Text</label>
                                <input type="text" class="form-control" name="alt" id="alt"
                                    placeholder="Enter Alternat Name"
                                    @if (!empty($banner['alt']))
                                        value="{{$banner['alt']}}"
                                        @else
                                        value="{{old('alt')}}"
                                    @endif
                                    >
                            </div>        
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div><!-- /.card -->
        </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
