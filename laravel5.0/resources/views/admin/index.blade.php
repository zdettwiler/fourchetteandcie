{{-- Admin - Index --}}
@extends('admin_layout')

@section('page_title', 'Admin')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/admin.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
@stop

@section('content')

    <h2>Welcome to the Admin Dashboard!</h2>

	<div class="module width-50">
    <a href="admin/orders">
        <h3>Orders</h3>
        <p><span>{{ $nb_not_val_orders }}/{{ $nb_orders }}</span><br>
        orders need to be validated</p>
    </a>
    </div>

	<div class="module width-50">
        <h3>Items</h3>
    </div>

@stop
