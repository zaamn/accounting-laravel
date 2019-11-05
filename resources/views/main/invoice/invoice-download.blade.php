<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	  	<!-- Tell the browser to be responsive to screen width -->
	  	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<title>BFIN Invoice</title>
		<style type="text/css">
			body{
				font-size: 14px;
			}
			.clear{
				clear: both;
			}
			.container{
				padding: 50px;
			}
			.container .title{
				float: right;
				margin-top: 0;
			}
			.container .title h1{
				margin-top: 0;
			}
			.table.table-one{
				float: left;
			}
			.table.table-two{
				float: right;
			}

			.table.table-three{
				border: 3px solid #ddd;
			}
			tr.table-border th {
			    border-bottom: 3px solid #ddd;
			}

			th.border-1 {
			    border-left: 3px solid #ddd;
			}

			td.border-1 {
			    border-left: 3px solid #ddd;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="title">
				<h1>Invoice</h1>
			</div>
			<div class="clear"></div>
			<h2>8 Rue Dublin 34200 State France</h2>
			<table class="table table-one" cellpadding="5">
				<tr>
					<th>Name:</th>
					<td>{{$invoice->customer->name}}</td>
				</tr>
				<tr>
					<th>Email:</th>
					<td>{{$invoice->customer->email}}</td>
				</tr>			
			</table>
			<table class="table table-two" cellpadding="5">
				<tr>
					<th>Date:</th>
					<td>{{$invoice->order_date}}</td>
				</tr>
				<tr>
					<th>Transaction ID:</th>
					<td>{{$invoice->transaction_id}}</td>
				</tr>
			</table>
			<div class="clear"></div>
			<br>

			<table width="100%" cellpadding="5" cellspacing="0" class="table table-three">
				<tr class="table-border">
					<th width="15%">Item Code</th>
					<th width="40%">Item Description</th>
					<th width="10%">Quantity</th>
					<th width="10%">Unit Price</th>
					<th width="5%">Discount %</th>
					<th width="20%" class="border-1">Total</th>
				</tr>
				@php
                    $sub_total = 0;
                @endphp
				@foreach($sales as $sale)
					<tr>
						<td>{{$sale->item_code}}</td>
						<td>{{$sale->product->product_name}}</td>
						<td>{{$sale->quantity}}</td>
						<td>{{$invoice->currency == 'USD' ? '$':'৳'}} {{$sale->unit_price}}</td>
						<td>{{$sale->discount}}</td>
						<td class="border-1">{{$invoice->currency == 'USD' ? '$':'৳'}} {{$sale->sub_total}}</td>
					</tr>
					@php
						$sub_total = $sub_total + $sale->sub_total;
	                @endphp
				@endforeach
				<br>
				<tr>
					<td colspan="3"></td>
					<td colspan="2"><strong>Sub Total:</strong></td>
					<td class="border-1">{{$invoice->currency == 'USD' ? '$':'৳'}} <strong>{{number_format($sub_total,2,'.',',')}}</strong></td>
				</tr>
			</table>
		</div>
	</body>
</html>