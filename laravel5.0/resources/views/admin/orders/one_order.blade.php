{{-- Admin - View Order --}}
@extends('admin_layout')

@section('page_title', 'Admin // View Order #'.sprintf('%03u', $order->id))

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/admin.css" type="text/css" media="all"/>


	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/reach_basket.js"></script>
@stop

@section('content')

	<div id="back-arrow">
		<a href="../orders">
			<img src="http://www.fourchetteandcie.com/pictures/back-arrow.png" width="30px">
		</a>
	</div>


	<h2>Order #{{ sprintf('%03u', $order->id) }}</h2>
	<p>Security token: <b>{{ $order->order_token }}</b></p>

	{{-- ORDER STATUS AT A GLANCE --}}
	<div class="module width-50">
		<h3>Order Status <a class="a-button-style" href="{{ $order->id }}/validate">VALIDATE</a><h3>
		<table id="order-status" style="width: 300px;">
			<tr>
				<td colspan="3">Order placed at <b>{{ date('d/m/Y H:i:s', $order->placed_datetime) }}</b></td>
			</tr>

			<tr>
				<td>Wholesale?</td>
				<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_wholesale }}.png"></td>
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
				<td>{{ $currency }}</td>
			</tr>
		</table>
	</div>

	{{--@if($order->is_validated)
		<p>This order
	@endif--}}


	{{-- CUSTOMER DETAILS --}}
	<div class="module width-50">
		<h3>Customer</h3>
		<p><b>{{ $order->customer_name }}</b><br>
		{!! str_replace('\n', "<br>", $order->customer_address) !!}<br>
		<span style="font-size: 20px">☎</span> {{ $order->customer_phone }} // <span style="font-size: 20px">&#64;</span> {{ $order->customer_email }}</p>
	</div>

	{{-- ORDER DETAILS --}}
	<div class="module width-100">
		<h3>Order Details</h3>

		<table id="order">
			<tr class="table-header">
				<td></td>
				<td style='width:60%;'>Item Description</td>

				<td class="center-col">Qty</td>
				<td class="center-col">Unit. Price</td>
				<td class="center-col">Total</td>
			</tr>

		@foreach($order_details as $item)

			<tr item-ref='{{ $item['ref'] }}'>
				<td>
				@if(substr($item['ref'], 0, 6) != "custom")
					<img class='item-img' src="http://www.fourchetteandcie.com/pictures/{{ $item['ref'][0] }}/100px/{{ $item['ref'] }}_thumb.jpg" height='50'>
				@endif
				</td>

				<td style='width: 60%;'><span class='ref-box'>{{ $item['ref'] }}</span> {{ $item['name'] }}{{ $item['stamped'] }}<br><span>{{ $item['descr'] }}</span></td>

				<td class="center-col">{{ $item['qty'] }}</td>
				<td class="center-col">{{ $currency }} {{ number_format($item['price'], 2) }}</td>
				<td class="center-col">{{ $currency }} {{ number_format($item['qty'] * $item['price'], 2) }}</td>
			</tr>

		@endforeach

		@if($order->is_validated == 0)

			<tr id='subtotal-row'>
				<td colspan='4'>SUBTOTAL ({{ $order->order_nb_items }} @if($order->order_nb_items > 1) items) @else item) @endif</td>
				<td class="center-col">{{ $currency }} {{ number_format ( $order->order_subtotal, 2 ) }}</td>
			</tr>

			@if($order->is_wholesale == 1)
			<tr id='subtotal-row'>\n
				<td colspan='4'>WHOLESALE (-30%)</td>\n
				<td class="center-col">{{ $currency }} {{ number_format( 0.7 * $order->val_order_subtotal, 2 ) }}</td>\n
			</tr>
			@endif

			<tr id='shipping-row'>
				<td colspan='4'>SHIPPING</td>
				<td class="center-col">{{ $currency }} {{ number_format ( $order->val_order_shipping, 2 ) }}</td>
			</tr>

			<tr id='total-row'>
				<td colspan='4'>TOTAL</td>
				<td class="center-col">{{ $currency }} {{ number_format ( $order->order_total, 2 ) }}</td>
			</tr>

		@endif

		@if($order->is_validated == 1)

			<tr id='subtotal-row'>
				<td colspan='4'>SUBTOTAL ({{ $order->val_order_nb_items }} item(s))</td>
				<td class="center-col">{{ $currency }} {{ number_format ( $order->val_order_subtotal, 2 ) }}</td>
			</tr>

		@if($order->is_wholesale == 1)
			<tr id='subtotal-row'>\n
				<td colspan='4'>WHOLESALE (-30%)</td>\n
				<td class="center-col">{{ $currency }} {{ number_format( 0.7 * $order->val_order_subtotal, 2 ) }}</td>\n
			</tr>
		@endif

			<tr id='shipping-row'>
				<td colspan='4'>SHIPPING ({{ $order->val_order_shipping_details }})</td>
				<td class="center-col">{{ $currency }} {{ number_format ( $order->val_order_shipping, 2 ) }}</td>
			</tr>

			<tr id='total-row'>
				<td colspan='4'>TOTAL</td>
				<td class="center-col">{{ $currency }} {{ number_format ( $order->val_order_total, 2 ) }}</td>
			</tr>

		@endif

		</table>

		<h3>attached message: </h3>
		<p>{{ $order->val_order_message }}</p>
	</div>

	 <a class="a-button-style right" href="{{ $order->id }}/validate">VALIDATE</a>

@stop
