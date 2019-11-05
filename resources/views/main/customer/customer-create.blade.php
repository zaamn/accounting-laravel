@extends('main.layouts.app')
@section('title', 'Create Customer')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Customer Create</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Customer</li>
        </ol>
    </section>

    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Customer</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                @include('includes.error')
                                @include('includes.message')
                                <form action="{{route('customer.store')}}" method="POST">
                                    @csrf
                                    <h4>Customer Name</h4>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user-circle"></i></span>
                                        <input type="text" name="name" class="form-control" value="{{old('name')? old('name'):''}}" placeholder="Customer Name">
                                    </div>
                                    <br>

                                    <h4>Email Address</h4>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" value="{{old('email')? old('email'):''}}" placeholder="Email Address">
                                    </div>
                                    <br>
                                    <h4>Address</h4>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-address-card-o"></i></span>
                                        <input type="text" name="address" class="form-control" value="{{old('address')? old('address'):''}}" placeholder="Address">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-info btn-flat">Submit!</button>
                                        </span>
                                    </div>
                                    <br><br><br>
                                    <!-- /input-group -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection
