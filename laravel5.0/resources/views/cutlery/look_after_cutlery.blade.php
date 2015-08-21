@extends('master_layout')

@section('page_title', 'Looking After Your Cutlery')

@section('include')
	<link rel="stylesheet" href="../css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../css/basket.css" type="text/css" media="all"/>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="../js/layout.js"></script>
	<script src="../js/reach_basket.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script>
		$(document).ready(function(){
			$('div.item-img-zoom').zoom();
		});
	</script>
@stop

@section('basket')

	<table id="basket-contents">
	</table>

@stop

@section('content')

	<h2>How to look after your handstamped silver cutlery.</h2>
	<p>In order to keep your original handstampped silverware in tip top condition we recommend a gentle hand wash and, as with any silverplated object, a good old polish from time to time would keep it looking spic and span.</p>

@stop