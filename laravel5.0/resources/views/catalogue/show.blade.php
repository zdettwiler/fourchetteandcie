{{-- Catalogue - Show item --}}
@extends('master_layout')

@section('page_title', 'Catalogue')

@section('include')
	<link rel="stylesheet" href="../css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../css/basket.css" type="text/css" media="all"/>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
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

	<div>
		<div id="item-viewer-content">

			<div id="item-viewer-imgs">
				<img class="item-img" src="../pictures/cutlery/500px/{{ $item->ref() }}.jpg">
			</div>

			<div id="item-viewer-details">
				<h2 id="item-viewer-stamped">{{ $item->stamped() }} (c{{ $item->id() }})</h2>
				<h5 id="item-viewer-descr">{{ $item->descr() }}</h5>
				<h5 id="item-viewer-price">€{{ $item->price() }}</h5>
				
				<br><br><br><br><br>
				<button id="button-add-to-basket">ADD TO BASKET</button>
			</div>
		</div>
	</div>

@stop