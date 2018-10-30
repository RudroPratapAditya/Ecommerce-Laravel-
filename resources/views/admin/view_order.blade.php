@extends('admin_layout')
@section('admin_content')

	<div class="row-fluid sortable">
		<div class="box-span6">
			<div class="box-header">
				<h2><i class="halflings-icon align-justify"></i><span class="break"></span>Customer Details</h2>
			</div>
			<div class="box-content">
				<table class="table">
					<thead>
						<tr>
							<th>Customer First Name</th>
							<th>Customer Last Name</th>
							<th>Mobile</th>
						</tr>
					</thead>
					<tbody>
				<tr>
						<td>{{$order_by_id->customer_first_name}}</td>
							<td>{{$order_by_id->customer_last_name}}</td>
							<td>{{$order_by_id->phone_number}}</td>
				</tr>
				</tbody>
				</table>
			</div>
		</div>

		<div class="box-span6">
			<div class="box-header">
				<h2><i class="halflings-icon align-justify"></i><span class="break"></span>Shipping Details</h2>
			</div>
			<div class="box-content">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Shipping First Name</th>
							<th>Shipping Last Name</th>
							<th>Address</th>
							<th>Mobile</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						  <td>{{$order_by_id->shipping_first_name}}</td>
						  <td>{{$order_by_id->shipping_last_name}}</td>
						  <td>{{$order_by_id->shipping_address}}</td>
						  <td>{{$order_by_id->shipping_phone_number}}</td>
							
						</tr>
					</tbody>
				</table>
				
			</div>
		</div>
		<div class="row-fluid sortable">
			<div class="box-span12">
				<div class="box-header" data-original-title>
					<h2><i class="halflings-icon user"></i><span class="break"></span>Order Details</h2>
				</div>
				<div class="box-content">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Product Id</th>
								<th>Product Name</th>
								<th>Product Price</th>
								<th>Product Sales Quantity</th>
								<th>Product Sub Total</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<td>{{$order_by_id->product_id}}</td>
							<td>{{$order_by_id->product_name}}</td>
							<td>{{$order_by_id->product_price}}</td>
							<td>{{$order_by_id->product_sales_quantity}}</td>
							<td>{{$order_by_id->order_total}}</td>
							
							
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4">Total With Vat: </td>
							<td><strong>={{$order_by_id->order_total}} Tk</strong> </td>
						</tr>
					</tfoot>
					</table>
				</div>
					
				</div>
			</div>
		</div>

@endsection