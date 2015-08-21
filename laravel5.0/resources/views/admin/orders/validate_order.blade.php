{{-- Admin - View Order --}}
@extends('admin_layout')

@section('page_title', 'Admin // Validate Order #'.sprintf('%03u', $order->id))

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/layout.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/search_db.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/reach_validate_order_reload.js"></script>
	<script>
		var id={{ $order->id }};
	</script>
@stop

@section('basket')

	<table id="basket-contents">
	</table>

@stop

@section('content')

	<div id="back-arrow">
		<a href="../{{ $order->id }}">
			<img src="http://localhost/fourchetteandcie/public/pictures/back-arrow.png" width="30px">
		</a>
	</div>

	<h2>Order #{{ sprintf('%03u', $order->id) }}</h2>
	<p>Security token: <b>{{ $order->order_token }}</b></p>

	{{-- ORDER STATUS AT A GLANCE --}}
	<div class="width-50">
		<h3>Order Status<h3>
		<table id="order-status" style="width: 300px;">
			<tr>
				<td colspan="3">Order placed on <b>{{ date('d/m/Y H:i:s', $order->placed_datetime) }}</b></td>
			</tr>

			<tr>
				<td>Wholesale?</td>
				<td><img id="wholesale-status" src="http://localhost/fourchetteandcie/public/pictures/{{ $order->is_wholesale }}.png"></td>
				<td><button id="toggle-wholesale">WHOLESALE</button></td>
			</tr>

			<tr>
				<td>Validated?</td>
				<td><img src="http://localhost/fourchetteandcie/public/pictures/{{ $order->is_validated }}.png"></td>

			</tr>

			<tr>
				<td>Payed?</td>
				<td><img src="http://localhost/fourchetteandcie/public/pictures/{{ $order->is_payed }}.png"></td>
			</tr>
		</table>
	</div>

	{{--@if($order->is_validated)
		<p>This order
	@endif--}}


	{{-- CUSTOMER DETAILS --}}
	<div class="width-50">
		<h3>Customer</h3>
		<p><b>{{ $order->customer_name }}</b><br>
		{!! str_replace('\n', "<br>", $order->customer_address) !!}<br>
		<span style="font-size: 20px">☎</span> {{ $order->customer_phone }} // <span style="font-size: 20px">&#64;</span> {{ $order->customer_email }}</p>
	</div>

	{{-- ORDER DETAILS --}}
	<br>
	<br>
	<br>
	<h3>Order Details</h3>

	<table id="validation-table">


	</table>

	<br><br><br>
	<a href="validate/submit" class="a-button-style" style="float: right;">SUBMIT CHANGES</a>

@stop
