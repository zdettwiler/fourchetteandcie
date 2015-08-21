{{-- Admin - Catalogue --}}
@extends('checkout_layout')

@section('page_title', 'Checkout // Confirm')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/checkout-progress-bar.css" type="text/css" media="all"/>

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

	<div class="step current">
		<span class="step-nb">3</span>
		<span class="step-name">confirm</span>
	</div>

	<div class="step">
		<span class="step-nb">4</span>
		<span class="step-name">place</span>
	</div>

	<div class="step">
		<span class="step-nb">5</span>
		<span class="step-name">payment</span>
	</div>

	<div class="step">
		<span class="step-nb">6</span>
		<span class="step-name">thank you</span>
	</div>
@stop

@section('content')

	<h2>Please confirm that you are happy with your order,</h2>
	<p>and check one last time that your details are correct. This will make our life easier...</p>

	<p style="font-size: 20px;">
		<b>{{ $shipping_details['name'] }}</b><br>
		{{ $shipping_details['address1'] }}<br>
	@if($shipping_details['address2'] != '')
		{{ $shipping_details['address2'] }}<br>
	@endif
		{{ $shipping_details['zip'] }} {{ $shipping_details['city'] }}<br>
		{{ $shipping_details['country'] }}<br>
		{{ $shipping_details['email'] }}<br>
		{{ $shipping_details['phone'] }}
	</p>


	<h2>Your Basket</h2>
	<table id="basket-contents">

	</table>

	<br><br><br><br>

	<a href="http://www.fourchetteandcie.com/checkout/{{ $order_token }}/shipping" class="a-button-style" style="float: left;">PREVIOUS</a>
	<a href="http://www.fourchetteandcie.com/checkout/{{ $order_token }}/shipping/confirm/placed" class="a-button-style" style="float: right;">I CONFIRM</a>

@stop
