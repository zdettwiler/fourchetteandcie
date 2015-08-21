@extends('email_layout')

@section('page_title', 'Handstamped Silverware')

@section('preloader')
	Thank you so much for your order! Find the invoice here...
@stop

@section('content')

	<h2 style="color: #7cffb1; font-family: 'Times New Roman', 'Palatino', serif; font-weight:100; -webkit-font-smoothing:antialiased; font-size: 50px; margin: 0px; font-weight: 300; border-top: 2px solid #000000; border-bottom: 2px solid #000000; text-align: center;">THANK YOU!<h2>
	
	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Dear {{ $order->customer_name }},<br><br>
		Thank your for your order and payment. We will inform you as soon as your order has been shipped.<br>
		You can find the invoice of the order by clicking on this button:</p>

	<a href="" style="display: block; margin: auto; width: 70%; color: #FFFFFF; text-align: center; font-size: 18px; font-family: Arial, sans-serif; text-decoration: none; padding: 15px 0; background-color: #7cffb1; border-radius: 7px;">SEE THE INVOICE</a>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Here is a reminder of your order:</p>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS DETAILS.</p>

	<a href="" style="display: block; margin: auto; width: 70%; color: #FFFFFF; text-align: center; font-size: 18px; font-family: Arial, sans-serif; text-decoration: none; padding: 15px 0; background-color: #7cffb1; border-radius: 7px;">SEE THE INVOICE</a>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Sincerly,<br>Fourchette &amp; Cie</p>

@stop