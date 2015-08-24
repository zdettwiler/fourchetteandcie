@extends('email_layout')

@section('page_title', 'Handstamped Silverware')

@section('preloader')
	A new order has been place and you need to validate it asap!
@stop

@section('content')

	<h2 style="font-family: 'Times New Roman', 'Palatino', serif; font-weight:100; -webkit-font-smoothing:antialiased; font-size: 50px; margin: 0px; font-weight: 300; border-top: 2px solid #000000; border-bottom: 2px solid #000000; text-align: center;">New Order!<h2>

	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">Dear Papi,<br><br>
		An order has just been placed (see below for details). You need to validate asap, so that the customer can pay.</p>

	<a href="http://www.fourchetteandcie.com/admin/orders/{{ $order->id }}" style="display: block; margin: auto; width: 70%; color: #FFFFFF; text-align: center; font-size: 18px; font-family: Arial, sans-serif; text-decoration: none; padding: 15px 0; background-color: #7cffb1; border-radius: 7px;">VALIDATE THE ORDER</a>

	<h3 style="font-family: sans-serif; font-size: 20px; font-weight: bold; padding: 0; margin: 0;">Customer</h3>
	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">
		{{ $order->customer_name }}<br>
		{!! str_replace('\n', "<br>", $order->customer_address) !!}<br>
		<span style="font-size: 20px">☎</span> {{ $order->customer_phone }} // <span style="font-size: 20px">&#64;</span> {{ $order->customer_email }}
	</p>

	<h3 style="font-family: sans-serif; font-size: 20px; font-weight: bold; padding: 0; margin: 0;">Order</h3>
	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">
		Order #{{ sprintf('%03u', $order->id) }} placed on {{ $order->placed_datetime }}<br>
		{{ $order->order_nb_items }}
		@if($order->order_nb_items > 1)
			items
		@else
			item
		@endif
		/ subtotal: €{{ $order->order_subtotal}}.

	</p>



	<p style="font-family: sans-serif; font-size: 16px; font-weight: 100; padding: 0 20px;">With love,<br>Zach</p>

@stop
