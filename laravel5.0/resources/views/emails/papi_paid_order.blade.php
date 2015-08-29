@extends('email_layout')

@section('page_title', 'Handstamped Silverware')

@section('preloader')
	The order nº{{ sprintf('%03u', $order_id) }} is paid, the invoice is ready, get to work!
@stop

@section('content')

	<h2 style="font-family: 'Times New Roman', 'Palatino', serif; font-weight:100; -webkit-font-smoothing:antialiased; font-size: 50px; margin: 0px; font-weight: 300; border-top: 2px solid #000000; border-bottom: 2px solid #000000; text-align: center;">Payed Order<h2>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Dear Papi,<br><br>
		The order nº{{ sprintf('%03u', $order_id) }} has been paid, and the invoice is finalised. You can check it out by following the link below.
		<br>Keep up the good work!</p>

	<a href="http://www.fourchetteandcie.com/admin/orders/{{ $order->id }}" style="display: block; margin: auto; width: 70%; color: #FFFFFF; text-align: center; font-size: 18px; font-family: Arial, sans-serif; text-decoration: none; padding: 15px 0; background-color: #7cffb1; border-radius: 7px;">VIEW THE ORDER</a>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">With love,<br>Zach</p>

@stop
