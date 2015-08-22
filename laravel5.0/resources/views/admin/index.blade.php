{{-- Admin - Index --}}
@extends('admin_layout')

@section('page_title', 'Admin')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin.css" type="text/css" media="all"/>

	<style>
		.widget
		{
			float: left;
			margin: 2%;
			width: 46%;
			padding: 20px;
			color: #FFFFFF;
			background-color: #7CFFB1;
		}
		.widget h3,
		.widget span
		{
			margin: 0;
			color: #FFFFFF;
			text-align: center;
			font-family: 'Roboto Condensed';
			font-weight: thin;
		}
		.widget a
		{
			margin: 0;
		}

		span.tot_orders
		{
			font-family: 'Roboto Condensed';
			font-size: 200px;
			font-weight: thin;
			color: #FFFFFF;
			margin: 0;
			text-align: center;
		}


	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/layout.js"></script>
@stop

@section('content')

    <h2>Welcome to the Admin Dashboard!</h2>

	<div class="widget">
    <a href="admin/orders">

        <h3>Orders</h3>
		<table>
			<tr>
				<td><span style="font-size: 60px;">{{ $nb_not_val_orders }}</span></td>
				<td><span style="font-size: 15px;">need<br>Validation</span></td>
				<td rowspan="3"><span style="font-size: 150px;">/{{ $nb_orders }}</span></td>
			</tr>
			<tr>
				<td><span style="font-size: 60px;">{{ $nb_val_orders }}</span></td>
				<td><span style="font-size: 15px;">wait<br>Payment</span></td>
			</tr>
			<tr>
				<td><span style="font-size: 60px;">{{ $nb_payed_orders }}</span></td>
				<td><span style="font-size: 15px;">are<br>Done</span></td>
			</tr>
		</table>

    </a>
    </div>

	<div class="widget">
	<a href="admin/items">

        <h3>Items</h3>
		<table>
			<tr>
				<td><span style="font-size: 60px;">{{ $nb_new_items }}</span></td>
				<td><span style="font-size: 15px;">New</span></td>
				<td rowspan="3"><span style="font-size: 150px;">/{{ $nb_items }}</span></td>
			</tr>
			<tr>
				<td><span style="font-size: 60px;">{{ $nb_best_seller_items }}</span></td>
				<td><span style="font-size: 15px;">Best Sellers</span></td>
			</tr>
			<tr>
				<td><span style="font-size: 60px;">{{ $nb_sold_out_items }}</span></td>
				<td><span style="font-size: 15px;">Sold Out</span></td>
			</tr>
		</table>

    </a>
    </div>

@stop
