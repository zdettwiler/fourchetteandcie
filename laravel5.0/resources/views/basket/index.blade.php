@extends('checkout_layout')

@section('page_title', 'Basket')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/reach_basket.js"></script>
	<script src="http://www.fourchetteandcie.com/js/jquery.zoom.min.js"></script>
	<script>
		reach_basket('HTML');
	</script>
@stop

@section('content')

	<table id="basket-contents">
	</table>	

	<h2>Basket Mass: {{ $shipping_price }}g</h2>

@stop