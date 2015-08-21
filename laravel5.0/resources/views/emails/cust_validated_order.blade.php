@extends('email_layout')

@section('page_title', 'Handstamped Silverware')

@section('preloader')
	Your order has been validated! Ready to pay?
@stop

@section('content')

	<h2 style="font-family: 'Times New Roman', 'Palatino', serif; font-weight:100; -webkit-font-smoothing:antialiased; font-size: 50px; margin: 0px; font-weight: 300; border-top: 2px solid #000000; border-bottom: 2px solid #000000; text-align: center;">Validated Order<h2>
	
	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Dear {{ $order->customer_name }},<br><br>
		Your order has been validated. You can view it by clicking on the button below. From there you will also be able to make your payment.</p>

	<a href="" style="display: block; margin: auto; width: 70%; color: #FFFFFF; text-align: center; font-size: 18px; font-family: Arial, sans-serif; text-decoration: none; padding: 15px 0; background-color: #7cffb1; border-radius: 7px;">SEE THE ORDER</a>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">We hope you'll be pleased!</p>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">À bientôt<br>Éric &amp; Iris</p>

@stop