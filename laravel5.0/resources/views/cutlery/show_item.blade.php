@extends('master_layout')

@section('page_title', 'Handstamped Silverware')

@section('include')
	<link rel="stylesheet" href="../../css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../../css/ondisplay.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../../css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../../css/basket.css" type="text/css" media="all"/>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="../../js/layout.js"></script>
	<script src="../../js/jquery.zoom.min.js"></script>
	<script>
		$(document).ready(function(){
			$('#ondisplay-imgs').zoom();
		});
	</script>
@stop

@section('basket')
	<p>Your basket is empty.</p>
@stop

@section('content')
	
	<div id="ondisplay-imgs">
		<img class="item-img" src="../../pictures/{{ $item->get_sectionfullname() }}/500px/{{ $item->get_ref() }}.jpg">
		
	</div>

	<div id="ondisplay-details">
		
		<h2>{{ $item->get_stamped() }}</h2>
		<h5>{{ $item->get_descr() }}</h5>
		<h5>€{{ $item->get_price() }}</h5>
		
		<br><br><br><br><br>
		<button class="two">ADD TO BASKET</button>

	</div>

@stop