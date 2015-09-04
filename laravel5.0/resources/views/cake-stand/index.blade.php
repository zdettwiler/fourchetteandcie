@extends('master_layout')

@section('page_title', 'Cake Stands')

@section('include')
	<link rel="stylesheet" href="css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="css/basket.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="js/layout.js"></script>
	<script src="js/reach_basket.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script>
		$(document).ready(function(){
			if($(window).width() > 450)
			{
				$('div.item-img-zoom').zoom();
			}
		});
	</script>
@stop

@section('basket')

	<table id="basket-contents">
	</table>

@stop

@section('categ-bar')

@stop

@section('content')

	<ul id="shopwindow">

	@foreach($items as $item)
		<li class="item" item-ref="{{ $item->ref }}" img-count="{{ $item->img_count }}">
			<div class="item-img-zoom"><img class="item-img" src="http://www.fourchetteandcie.com/pictures/s/500px/{{ $item->ref }}.jpg"></div>
			<div class="item-details">
				<div class="item-price"><span>€{{ $item->price }}</span></div>
				<div class="item-stamped-descr">
					<span class="item-stamped">{{ $item->name }} ({{ $item->ref }})</span>
				</div>
			</div>
		</li>
	@endforeach

	</ul>

@stop
