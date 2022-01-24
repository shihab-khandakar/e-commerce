@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Update Admin Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active"> Admin Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Update Admin Details</h3>
                        </div>
                        <!-- /.card-header -->

                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:10px;">
                            {{Session::get('error_message')}}
                            </div>
                        @endif

                        @if (Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
                            {{Session::get('success_message')}}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" style="margin-top:10px;">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- form start -->
                        <form method="post" action="{{route('admin.updateAdminDetails')}}" id="updateAdminDetails" name = "updateAdminDetails" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Admin Email</label>
                                    <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Admin Type</label>
                                    <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label for="admin_name"> Name</label>
                                    <input type="text" name="admin_name" class="form-control" id="admin_name" value="{{ Auth::guard('admin')->user()->name }}"
                                        placeholder="Enter Admin Name" >
                                </div>
                                <div class="form-group">
                                    <label for="admin_mobile"> Mobile </label>
                                    <input type="text" name="admin_mobile" class="form-control" id="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}"
                                        placeholder="Enter Mobile Number" >
                                </div>
                                <div class="form-group">
                                    <label for="admin_image"> Admin Image</label>
                                    <input type="file" name="admin_image" class="form-control" id="admin_image" accept="image/*">
                                    @if (!empty(Auth::guard('admin')->user()->image))

                                        {{-- <a href="{{asset('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}">View Image</a> --}}
                                        <input type="hidden" name="current_admin_image" value="{{Auth::guard('admin')->user()->image}}">
                                        
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div><!-- Content wrapper -->

@endsection
