{{-- Admin - Catalogue --}}
@extends('checkout_layout')

@section('page_title', 'Checkout // Order Placed')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/checkout-progress-bar.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
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

	<div class="step current">
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

	<h2>Your order (#{{ sprintf('%03u', $order_id) }}) has been successfully placed.</h2>
	<p>We have received your order and we will validate it as soon as possible. We will make sure we are able to meet your desires and will come back to you as soon as possible for you to pay. That done, we'll ship your order over to you...</p>

@stop
