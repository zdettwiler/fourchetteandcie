@extends('email_layout')

@section('page_title', 'Handstamped Silverware')

@section('preloader')
	Your order has been placed. We're on it!
@stop

@section('content')

	<h2 style="font-family: 'Times New Roman', 'Palatino', serif; font-weight:100; -webkit-font-smoothing:antialiased; font-size: 50px; margin: 0px; font-weight: 300; border-top: 2px solid #000000; border-bottom: 2px solid #000000; text-align: center;">Your Submitted Order<h2>
	
	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Dear {{ $order->customer_name }},<br><br>
		Your order has been placed, thank you very much.<br>
		Due to the unique, original and vintage nature of each of our items, there may be slight differences in the form and style of the objects. To ensure your total satisfaction, we always validate your order swiftly before payment.</p>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">À bientôt,<br>Éric &amp; Iris</p>

@stop