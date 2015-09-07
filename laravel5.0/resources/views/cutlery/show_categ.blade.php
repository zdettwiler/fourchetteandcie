@extends('master_layout')

@section('page_title', 'Handstamped Silverware')

@section('include')
	<link rel="stylesheet" href="../../css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../../css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../../css/basket.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="../../js/layout.js"></script>
	<script src="../../js/reach_basket.js"></script>
	<script src="../../js/jquery.zoom.min.js"></script>
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
	<div id="categ-bar">
		<ul id="categ-links">
			<li><a href="http://www.fourchetteandcie.com/handstamped-silverware">ALL</a></li>
			<li><a href="http://www.fourchetteandcie.com/handstamped-silverware/category/spoon">SPOONS</a></li>
			<li><a href="http://www.fourchetteandcie.com/handstamped-silverware/category/fork">FORKS</a></li>
			<li><a href="http://www.fourchetteandcie.com/handstamped-silverware/category/knife">KNIVES</a></li>
			<li><a href="http://www.fourchetteandcie.com/handstamped-silverware/category/server">SERVERS</a></li>
		</ul>
	</div>
@stop

@section('content')

<p style="display: block; text-align: center;">Each piece is unique and individually handstamped. Expect variations.</p>

	<ul id="shopwindow">


	@foreach($in_categ_items as $item)
		<li class="item" item-ref="{{ $item->ref }}">
			<div class="item-img-zoom"><img class="item-img" src="../../pictures/cutlery/500px/{{ $item->ref }}.jpg"></div>
			<div class="item-details">
				<div class="item-price"><span>€{{ $item->price }}</span></div>
				<div class="item-stamped-descr">
					<span class="item-stamped">{{ $item->name }} ({{ $item->ref }})</span><br>
					<span class="item-descr"><i>{{ $item->descr }}</i></span>
				</div>
			</div>
		</li>
	@endforeach

	</ul>

@stop
