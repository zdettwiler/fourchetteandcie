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
		<img class="item-img" src="../../pictures/{{ $item->img }}">
	</div>

	<div id="ondisplay-details">


		
		<h2>{{ $item->stamped }}</h2>
		<h5>{{ $item->descr }} ({{ $item->categ }})</h5>
		<h5>€{{ $item->price }}</h5>
		
		<br><br>

		{!! Form::open() !!}

			<input type='text' name='ref' value='{{ $item->ref }}'><br>
			<input type='text' name='stamped' value='{{ $item->stamped }}'><br>
			<input type='text' name='descr' value='{{ $item->descr }}'><br>
			{{-- <select>
				<option value="spoons">All Spoons</option>
				<option value="teaspoons">Teaspoons</option>
				<option value="big-spoons">Big Spoons</option>
				<option value="dessert-spoons">Dessert Spoons</option>

				<option value="forks"></option>
				<option value="big forks"></option>
				<option value="dessert forks"></option>

				<option value="knives"></option>

				<option value="servers"></option>
				<option value="serving-spoons"></option>
				<option value="serving-forks"></option>
				<option value="cake-servers"></option>
			</select> --}}
			<input type='text' name='categ' value='{{ $item->categ }}'><br>
			<input type='text' name='price' value='{{ $item->price }}'><br>

			<input type='submit' name='submit' value='UPDATE'>

		{!! Form::close() !!}


		<a href="{{ $item->id + 1 }}">next</h2>

	</div>



@stop