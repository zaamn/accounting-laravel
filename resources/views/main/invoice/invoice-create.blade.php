@extends('main.layouts.app')
@section('title', 'Create Invoice')

@push('stylesheet')
    <link rel="stylesheet" href="{{asset('backend/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap-datepicker.min.css')}}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>New Invoice</h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Create Invoice</li>
        </ol>
    </section>

    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h2 class="box-title">Sales Invoice Items</h2>
                    </div>
                    <form action="{{route('invoice.cart')}}" method="POST">
                        @csrf
                        <div class="box-body">
                            @include('includes.error')
                            @include('includes.message')
                            <div class="sales-invoice">
                                <div class="row">
                                    <div class="col-sm-4">
                                        Customer Name:
                                        <select name="customer" id="customer" class="form-control">
                                            <option value="">Select one</option>
                                            @foreach($customers as $customer)
                                                <option {{$customer->id == session()->get('customer_id')?'selected':''}} value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        Currency:
                                        <select name="currency" id="currency" class="form-control">
                                            <option value="USD">USD</option>
                                            <option value="BDT">BDT</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        Date:
                                        <input type="text" name="date_time" id="datepicker" value="{{Carbon\Carbon::now()->format('d/m/y')}}" class="form-control" placeholder="Date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-items">
                            <table class="table table-hover table-striped">
                                <tr class="bg-light-blue">
                                    <th width="15%">Item Code</th>
                                    <th width="40%">Item Description</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Unit Price</th>
                                    <th width="10%">Discount</th>
                                    <th width="10%">Total</th>
                                    <th width="5%">Action</th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="item_code" id="item_code" class="form-control" placeholder="Item Code" value="{{old('item_code')?old('item_code'):''}}"></td>
                                    <td>
                                        <select name="product_id" id="product_id" class="form-control">
                                            <option value="">Select one</option>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="quantity" id="quantity" class="form-control" placeholder="Quantity" value="{{old('quantity')?old('quantity'):''}}"></td>
                                    <td><input type="text" name="unit_price" id="unit_price" class="form-control" placeholder="Unit Price" value="{{old('unit_price')?old('unit_price'):''}}"></td>
                                    <td><input type="text" name="discount" id="discount" class="form-control" placeholder="Discount%" value="{{old('discount')?old('discount'):''}}"></td>
                                    <td><input type="text" name="total_price" id="total_price" class="form-control" placeholder="Total" style="cursor: not-allowed;"></td>
                                    <td><button type="submit" class="btn btn-success"><i class="fa fa-check"></i></button></td>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <div>
                        @if(count($invoices) > 0)
                            <table class="table table-striped table-bordered table-hover">
                                <tr class="bg-light-blue">
                                    <th width="15%">Item Code</th>
                                    <th width="40%">Item Description</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Unit Price</th>
                                    <th width="10%">Discount</th>
                                    <th width="10%">Total</th>
                                    <th width="5%">Action</th>
                                </tr>
                                @php
                                    $price = 0;
                                    $totalQty = 0;
                                    $totalPrice = 0;
                                @endphp
                                <form action="{{route('invoice.store')}}" method="POST">
                                    @csrf
                                    @foreach($invoices as $invoice)
                                        
                                        <tr>
                                            <td width="15%">
                                                {{$invoice->item_code}}
                                            </td>
                                            <td width="40%">
                                                {{$invoice->product->product_name}}
                                            </td>
                                            <td width="10%">
                                                {{$invoice->quantity}}
                                            </td>
                                            <td width="10%">
                                                {{$invoice->currency == 'USD' ? '$':'৳'}} {{number_format($invoice->unit_price,2,'.',',')}}
                                            </td>
                                            <td width="10%">
                                                {{$invoice->discount}} %
                                            </td>
                                            <td width="10%">
                                                {{$invoice->currency == 'USD'? '$':'৳'}} {{number_format($invoice->total_price,2,'.',',')}}
                                            </td>
                                            <td width="5%"><a href="{{route('invoiceCart.delete',['id' => $invoice->id])}}">Remove</a></td>
                                        </tr>
                                        @php
                                            if ($invoice->currency == 'BDT') {
                                                $price = $price + $invoice->total_price/80;
                                            }
                                            else{
                                                $price = $price + $invoice->total_price;
                                            }
                                        @endphp
                                    @endforeach
                                    
                                    <tr>
                                        <input type="hidden" name="total_amount" value="{{$price}}">
                                        <td colspan="4" class="text-right"><p class="text-center"><a class="btn-link" href="{{route('invoice.clear')}}">If Add New Customer, Then Clear Table. Click</a></p></td>
                                        <td colspan="2" class="text-right"><strong>Total Amount: $ {{number_format($price,2,'.',',')}}</strong> </td>
                                        <td class="text-right"><button type="submit" class="btn btn-primary">Submit</button></td>
                                    </tr>
                                </form>
                            </table>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection

@push('javascript')
    <script src="{{asset('backend/js/select2.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap-datepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //Initialize Select2 Elements
            $('#customer, #currency, #product_id').select2();
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            });

            $('#discount, #unit_price, #quantity').keyup(function(){
                var quantity = $('#quantity').val();
                var unit_price = $('#unit_price').val();
                var discount = $('#discount').val();
                if (quantity == '' || unit_price == '' || discount == '') {
                    $('#quantity, #unit_price, #discount').addClass('text-danger');
                }
                else{
                    $('#quantity, #unit_price, #discount').removeClass('errorblur');
                    if (isNaN(quantity) == true || isNaN(unit_price) == true || isNaN(discount) == true){
                        alert("Please Give Us Number, 0-9");
                    }
                    else{
                        if (quantity%1 === 0){
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type:'POST',
                                url:'/total-count',
                                data:{quantity:quantity,unit_price:unit_price,discount:discount},
                                success:function(response) {
                                    $('#total_price').val($.trim(parseFloat(response).toFixed(2)));
                                }
                            });
                        }
                        else{
                            alert('Please Give Integer Number');
                        }
                    }
                }                    
            });
        });
    </script>
@endpush

