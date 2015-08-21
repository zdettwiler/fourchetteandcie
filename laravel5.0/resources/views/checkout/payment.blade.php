{{-- Admin - Catalogue --}}
@extends('checkout_layout')

@section('page_title', 'Checkout // Payment')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/checkout-progress-bar.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/admin.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/reach_basket.js"></script>
@stop

@section('checkout-progress-bar')
	<div class="step">
		<span class="step-nb">1</span>
		<span class="step-name">basket</span>
	</div>

	<div class="step">
		<span class="step-nb">2</span>
		<span class="step-name">shipping</span>
	</div>

	<div class="step">
		<span class="step-nb">3</span>
		<span class="step-name">confirm</span>
	</div>

	<div class="step">
		<span class="step-nb">4</span>
		<span class="step-name">place</span>
	</div>

	<div class="step current">
		<span class="step-nb">5</span>
		<span class="step-name">payment</span>
	</div>

	<div class="step">
		<span class="step-nb">6</span>
		<span class="step-name">thank you</span>
	</div>
@stop

@section('content')

	@if(Session::has('notification'))
		<div id="notification" class="{{ Session::get('notification')['type'] }}">
			<p>{{ Session::get('notification')['message'] }}</p>
		</div>
	@endif

	<h2>Your order (#{{ sprintf('%03u', $order->id) }}) has been validated.</h2>
	<p>Here is your validated order. Get ready to pay on PayPal.</p>

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
				<img class='item-img' src="http://www.fourchetteandcie.com/pictures/{{ $section_ref_code[ $item['ref'][0] ] }}/100px/{{ $item['ref'] }}_thumb.jpg" height='50'>
			@endif
			</td>

			<td style='width: 60%;'><span class='ref-box'>{{ $item['ref'] }}</span> {{ $item['name'] }}{{ $item['stamped'] }}<br><span>{{ $item['descr'] }}</span></td>

			<td class="center-col">{{ $item['qty'] }}</td>
			<td class="center-col">€{{ number_format($item['price'], 2) }}</td>
			<td class="center-col">€{{ number_format($item['qty'] * $item['price'], 2) }}</td>
		</tr>

	@endforeach

		<tr id='subtotal-row'>
			<td colspan='4'>SUBTOTAL ({{ $order->val_order_nb_items }} item(s))</td>
			<td class="center-col">€{{ number_format ( $order->val_order_subtotal, 2 ) }}</td>
		</tr>

	@if($order->is_wholesale == 1)
		<tr id='subtotal-row'>\n
			<td colspan='4'>WHOLESALE (-30%)</td>\n
			<td class="center-col">€{{ number_format( 0.7 * $order->val_order_subtotal, 2 ) }}</td>\n
		</tr>
	@endif

		<tr id='shipping-row'>
			<td colspan='4'>SHIPPING ({{ $order->val_order_shipping_details }})</td>
			<td class="center-col">€{{ number_format ( $order->val_order_shipping, 2 ) }}</td>
		</tr>

		<tr id='total-row'>
			<td colspan='4'>TOTAL</td>
			<td class="center-col">€{{ number_format ( $order->val_order_total, 2 ) }}</td>
		</tr>

	</table>

	<h3>attached message: </h3>
	<p>{{ $order->val_order_message }}</p>

	<br>
	<br>
	<br>

	<a href="http://www.fourchetteandcie.com/checkout/{{ $order->order_token }}/shipping/confirm/placed/payment/init" class="a-button-style" style="float: right;">PAY WITH PAYPAL</a>

@stop
