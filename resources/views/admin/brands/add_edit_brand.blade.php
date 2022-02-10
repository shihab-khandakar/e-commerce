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
                        <li class="breadcrumb-item active">Catalogues</li>
                        <li class="breadcrumb-item active">Brands</li>
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

            <form @if (empty($brand['id']))
                action="{{url('admin/add-edit-brand')}}"
                @else
                action="{{url('admin/add-edit-brand/'.$brand['id'])}}"
            @endif 
            name="brandForm" id="brandForm" method="post">
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
                                <label for="brand-name">Brand Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter Brand Name"
                                    @if (!empty($brand['name']))
                                        value="{{$brand['name']}}"
                                        @else
                                        value="{{old('name')}}"
                                    @endif
                                    >
                            </div>
                        </div>
                        <!-- /.col -->
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
