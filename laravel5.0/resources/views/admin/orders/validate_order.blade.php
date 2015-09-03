{{-- Admin - View Order --}}
@extends('admin_layout')

@section('page_title', 'Admin // Validate Order #'.sprintf('%03u', $order->id))

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/admin.css" type="text/css" media="all"/>

	<style>
		#currency-switch
		{
			width: 70px;
			height: 30px;
			position: relative;
			background-color: #DDDDDD;
			cursor: pointer;
		}
		.switch
		{
			width: 35px;
			height: 30px;
			display: block;
			position: relative;
			top: 0;
			left: 0;
			background-color: #7CFFB1;
		}

		.option-eur
		{
			left: 0;
		}
		.option-aud
		{
			left: 35px;
		}
		.option-eur,
		.option-aud
		{
			width: 35px;
			height: 30px;
			padding: 8px 0;
			position: absolute;
			top: 0;
			float: left;
			font-family: Arial, "Roboto Condensed";
			font-size: 13.3px;
			color: #AAAAAA;
			text-align: center;
			text-indent: 0;
			font-style: normal;
		}
		span.switch-selection
		{
			color: #FFFFFF;
		}

		span#loading
		{
			/*display: none;*/
		}

	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/mustache.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://localhost/display-only/fourchetteandcie/public_html/js/search_db.js"></script>
	{{-- <script src="http://www.fourchetteandcie.com/js/reach_validate_order_reload.js"></script> --}}
	<script src="http://localhost/display-only/fourchetteandcie/public_html/js/reach_validate_order_reload.js"></script>
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
			<img src="http://www.fourchetteandcie.com/pictures/back-arrow.png" width="30px">
		</a>
	</div>

	<h2>Order #{{ sprintf('%03u', $order->id) }}</h2>
	<p>Security token: <b>{{ $order->order_token }}</b></p>

	{{-- ORDER STATUS AT A GLANCE --}}
	<div class="width-50" style="float: left;">
		<h3>Order Status<h3>
		<table id="order-status" style="width: 300px;">
			<tr>
				<td colspan="3">Order placed on <b>{{ date('d/m/Y H:i:s', $order->placed_datetime) }}</b></td>
			</tr>

			<tr>
				<td>Wholesale?</td>
				<td><img id="wholesale-status" src="http://www.fourchetteandcie.com/pictures/{{ $order->is_wholesale }}.png"></td>
				<td><button id="toggle-wholesale">WHOLESALE</button></td>
			</tr>

			<tr>
				<td>Validated?</td>
				<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_validated }}.png"></td>

			</tr>

			<tr>
				<td>Payed?</td>
				<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_payed }}.png"></td>
			</tr>

			<tr>
				<td>Currency</td>
				<td>
					<div id="currency-switch">
						<span class="switch"></span>
						<span class="option-eur switch-selection">€</span>
						<span class="option-aud">AU$</span>
					</div>
				</td>
			</tr>
		</table>
	</div>

	{{--@if($order->is_validated)
		<p>This order
	@endif--}}


	{{-- CUSTOMER DETAILS --}}
	<div class="width-50" style="float: left;">
		<h3>Customer</h3>
		<p><b>{{ $order->customer_name }}</b><br>
		{!! str_replace('\n', "<br>", $order->customer_address) !!}<br>
		<span style="font-size: 20px">☎</span> {{ $order->customer_phone }} // <span style="font-size: 20px">&#64;</span> {{ $order->customer_email }}</p>
	</div>

	{{-- ORDER DETAILS --}}
	<br>
	<br>
	<br>
	<div style="margin: auto; width: 90%; float: left;">
		<h3>Order Details <span id="loading">WAIT</span></h3>
		<table id="validation-table">
		</table>
	</div>

	<br><br><br>
	<button id="submit-validation" style="float: right;">SUBMIT CHANGES</button>

@stop

@section('mustache-templates')
	@include('mustache_template')
@stop
