{{-- Admin - Orders --}}
@extends('admin_layout')

@section('page_title', 'Admin // Catalogue')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>

	<style>
		table
		{
			width: 100%;
			border-collapse: collapse;
		}
		tr.table-header
		{
			color: #FFFFFF;
			background-color: #222222;
			border-bottom: 2px solid #000000;
		}
		tr:hover
		{
			background-color: #E3E3E3;
		}
		td
		{
			text-align: center;
		}
	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/reach_basket.js"></script>
@stop

@section('content')

	{{-- ORDERS TO VALIDATE --}}
	<h2>Orders to Validate</h2>
	<table>

		<tr class="table-header">
			<td>Order #</td>
			<td>Placed at</td>
			<td>Validated?</td>
			<td>Payed?</td>
			<td>Wholesale?</td>
			<td>Customer Name</td>
			<td>Nb Items</td>
			<td>Shipping</td>
			<td>Subtotal</td>
		</tr>

		@foreach($orders as $order)

			@if(!$order->is_validated)
				<tr>
					<td><a href="http://www.fourchetteandcie.com/admin/orders/{{ $order->id }}" class="ref-box">#{{ sprintf('%03u', $order->id) }}</a></td>
					<td>{{ date('d/m/Y H:i:s', $order->placed_datetime) }}</td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_validated }}.png"></td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_payed }}.png"></td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_wholesale }}.png"></td>
					<td>{{ $order->customer_name }}</td>
					<td>{{ $order->order_nb_items }}</td>
					<td>
						@if($order->order_currency == 'eur')
						 	€
						@elseif($order->order_currency == 'aud')
							AU$
						@endif

						{{ number_format ( $order->order_shipping, 2 ) }}
					</td>
					<td>
						@if($order->order_currency == 'eur')
						 	€
						@elseif($order->order_currency == 'aud')
							AU$
						@endif

						{{ number_format ( $order->order_subtotal, 2 ) }}
					</td>
				</tr>
			@endif

		@endforeach

	</table><br>


	{{-- VALIDATED ORDERS --}}
	<h2>Validated Orders</h2>
	<table>
		<tr class="table-header">
			<td>Order #</td>
			<td>Placed at</td>
			<td>Validated?</td>
			<td>Payed?</td>
			<td>Wholesale?</td>
			<td>Customer Name</td>
			<td>Nb Items</td>
			<td>Shipping</td>
			<td>Subtotal</td>
		</tr>

		@foreach($orders as $order)

			@if($order->is_validated AND !$order->is_payed)
				<tr>
					<td><a href="http://www.fourchetteandcie.com/admin/orders/{{ $order->id }}" class="ref-box">#{{ sprintf('%03u', $order->id) }}</a></td>
					<td>{{ date('d/m/Y H:i:s', $order->placed_datetime) }}</td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_validated }}.png"></td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_payed }}.png"></td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_wholesale }}.png"></td>
					<td>{{ $order->customer_name }}</td>
					<td>{{ $order->val_order_nb_items }}</td>
					<td>
						@if($order->val_order_currency == 'eur')
						 	€
						@elseif($order->val_order_currency == 'aud')
							AU$
						@endif

						{{ number_format ( $order->val_order_shipping, 2 ) }}
					</td>
					<td>
						@if($order->val_order_currency == 'eur')
						 	€
						@elseif($order->val_order_currency == 'aud')
							AU$
						@endif

						{{ number_format ( $order->val_order_subtotal, 2 ) }}
					</td>
				</tr>
			@endif

		@endforeach

	</table><br>

	{{-- PAYED ORDERS --}}
	<h2>Payed Orders</h2>
	<table>
		<tr class="table-header">
			<td>Order #</td>
			<td>Placed at</td>
			<td>Validated?</td>
			<td>Payed?</td>
			<td>Wholesale?</td>
			<td>Customer Name</td>
			<td>Nb Items</td>
			<td>Shipping</td>
			<td>Subtotal</td>
		</tr>

		@foreach($orders as $order)

			@if($order->is_validated AND $order->is_payed)
				<tr>
					<td><a href="http://www.fourchetteandcie.com/admin/orders/{{ $order->id }}" class="ref-box">#{{ sprintf('%03u', $order->id) }}</a></td>
					<td>{{ date('d/m/Y H:i:s', $order->placed_datetime) }}</td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_validated }}.png"></td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_payed }}.png"></td>
					<td><img src="http://www.fourchetteandcie.com/pictures/{{ $order->is_wholesale }}.png"></td>
					<td>{{ $order->customer_name }}</td>
					<td>{{ $order->val_order_nb_items }}</td>
					<td>
						@if($order->val_order_currency == 'eur')
						 	€
						@elseif($order->val_order_currency == 'aud')
							AU$
						@endif

						{{ number_format ( $order->val_order_shipping, 2 ) }}
					</td>
					<td>
						@if($order->val_order_currency == 'eur')
						 	€
						@elseif($order->val_order_currency == 'aud')
							AU$
						@endif

						{{ number_format ( $order->val_order_subtotal, 2 ) }}
					</td>
				</tr>
			@endif

		@endforeach

	</table>

@stop
