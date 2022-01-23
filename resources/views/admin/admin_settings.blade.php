@extends('layouts.admin_layout.admin_layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active"> Admin Settings </li>
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
                            <h3 class="card-title">Update Password</h3>
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

                        <!-- form start -->
                        <form method="post" action="{{route('admin.updateChkPwd')}}" id="updatePasswordForm" name = "updatePasswordForm" role="form">
                            @csrf
                            <div class="card-body">
                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Admin Name</label>
                                    <input type="text" name="admin_name" id="admin_name" class="form-control" value="{{ $adminDetail->name }}" >
                                </div> --}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Admin Email</label>
                                    <input class="form-control" value="{{ $adminDetail->email }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Admin Type</label>
                                    <input class="form-control" value="{{ $adminDetail->type }}" readonly="">
                                </div>
                                <div class="form-group">
                                    <label for="CurentPassword"> Curent Password</label>
                                    <input type="password" name="current_pwd" class="form-control" id="current_pwd"
                                        placeholder="Enter Curent Password" required >
                                    <span id="chkCurrentPwd"></span>
                                </div>
                                <div class="form-group">
                                    <label for="CurentPassword"> New Password</label>
                                    <input type="password" name="new_pwd" class="form-control" id="new_pwd"
                                        placeholder="Enter New Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="CurentPassword"> Confirm Password</label>
                                    <input type="password" name="confirm_pwd" class="form-control" id="confirm_pwd"
                                        placeholder="Enter Confirm Password" required>
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
