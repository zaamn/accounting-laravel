@extends('main.layouts.app')
@section('title', 'View Invoice')

@push('stylesheet')
    <link rel="stylesheet" href="{{asset('backend/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
@section('content')
  	<!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h2 class="box-title">All Invoice Items</h2>
                    </div>
                    <div class="box-body table-responsive">
                    	<table class="table table-hover table-bordered table-striped" id="datatable">
	                        <tr class="bg-light-blue">
	                            <th>Invoice#</th>
	                            <th>Customer</th>
	                            <th>Order Date</th>
	                            <th>Required By</th>
	                            <th>Delivery To</th>
	                            <th>Order Total</th>
	                            <th>Due</th>
	                            <th>Currency</th>
	                            <th>Action</th>
	                        </tr>
	                        @foreach($invoices as $invoice)
	                        	<tr>
	                        		<td>{{$loop->index+1}}</td>
	                        		<td>{{$invoice->customer->name}}</td>
	                        		<td>{{$invoice->order_date}}</td>
	                        		<td>{{$invoice->required_by}}</td>
	                        		<td>{{$invoice->delivery_to}}</td>
	                        		<td>${{$invoice->order_total}}</td>
	                        		<td>${{$invoice->order_due}}</td>
	                        		<td>{{$invoice->currency}}</td>
	                        		<td>
										<div>
											<a href="{{route('customer.invoice.view',['id' => $invoice->id])}}" class="btn btn-primary btn-xs"><i class="fa fa-search"></i></a>
											<a href="" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
											<a href="" class="btn btn-info btn-xs"><i class="fa fa-download"></i></a>
										</div>
									</td>
	                        	</tr>
	                        @endforeach
	                    </table>
                    </div>                    
                </div>
            </div>
        </div>
        <!-- /.row -->
@endsection

@push('javascript')
    <script src="{{asset('backend/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
		    //$('#example1').DataTable()
		    $('#datatable').DataTable({
		      'paging'      : true,
		      'lengthChange': false,
		      'searching'   : false,
		      'ordering'    : true,
		      'info'        : true,
		      'autoWidth'   : false
		    })
		  })
    </script>
@endpush