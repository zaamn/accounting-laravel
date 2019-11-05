@extends('main.layouts.app')
@section('title', 'Create Product')
@push('stylesheet')
<link rel="stylesheet" type="text/css" href="{{ asset('backend/css/trumbowyg/trumbowyg.css') }}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Product Create</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Product</li>
        </ol>
    </section>

    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">New Product</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                @include('includes.error')
                                @include('includes.message')
                                <form action="{{route('product.store')}}" method="POST">
                                    @csrf
                                    <h4>Product Name</h4>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                        <input type="text" name="product_name" class="form-control" value="{{old('product_name')? old('product_name'):''}}" placeholder="Product Name">
                                    </div>
                                    <br>

                                    <h4>Category</h4>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-table"></i></span>
                                        <input type="text" name="category" class="form-control" value="{{old('category')? old('category'):''}}" placeholder="Category">
                                    </div>
                                    <br>
                                    <h4>Description:</h4>
                                    <div class="form-group">
                                        <textarea name="description" id="description" placeholder="Description">{{old('description')}}</textarea>
                                    </div>
                                    <input type="submit" class="btn btn-primary">
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
@push('javascript')
    <script src="{{asset('backend/js/trumbowyg/trumbowyg.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#description').trumbowyg();
        })
    </script>
@endpush
