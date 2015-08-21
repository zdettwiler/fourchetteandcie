{{-- Admin - Catalogue --}}
@extends('checkout_layout')

@section('page_title', 'Checkout // Shipping')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/forms.css" type="text/css" media="all"/>
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

	<div class="step current">
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

	{!! Form::open(['files' => true, 'url' => 'http://www.fourchetteandcie.com/checkout/'.bin2hex(openssl_random_pseudo_bytes(16)).'/shipping/confirm']) !!}

		<div id="form-container">
			<div class="form-field">
				{!! Form::label('name', 'Name') !!}
				{!! Form::text('name') !!}<br><br>

				{!! Form::label('address1', 'Address') !!}<br>
				{!! Form::text('address1') !!}<br>
				{!! Form::text('address2') !!}<br>

				{!! Form::label('zip', 'ZIP', ['style' => 'width: 30px;']) !!}
				{!! Form::text('zip', '', ['style' => 'width: 30%;']) !!}

				{!! Form::label('city', 'City', ['style' => 'width: 70px;']) !!}
				{!! Form::text('city', '', ['style' => 'width: 50%;']) !!}<br>

				{!! Form::label('country', 'Country') !!}<br>
				{!! Form::text('country') !!}<br><br>

				{!! Form::label('email', 'E-Mail') !!}<br>
				{!! Form::text('email') !!}<br>

				{!! Form::label('phone', 'Phone') !!}<br>
				{!! Form::text('phone') !!}<br>

			</div>
		</div>

		<br><br><br><br>

		<a href="http://www.fourchetteandcie.com/checkout" class="a-button-style" style="float: left;">PREVIOUS</a>

		{!! Form::submit('NEXT', ['style' => 'display: block; float: right;']); !!}

	{!! Form::close() !!}


	{{-- <a href="http://www.fourchetteandcie.com/checkout/shipping/confirm" class="a-button-style" style="float: right;">NEXT</a> --}}

@stop
