@extends('admin_layout')

@section('page_title', 'Admin // Edit')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/ondisplay.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/jquery.zoom.min.js"></script>
	<script type="text/javascript">
		function preview_img(input)
		{

			if (input.files && input.files[0])
			{
				$.each(input.files, function( key, value ) {
					var reader = new FileReader();

					reader.onload = function (e)
					{
						$("#img-preview-container").append("<img class='img-preview' src='"+e.target.result+"' height='200' width='200'><br>");
						// $('#img-preview').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[key]);
				});
			}

		}

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
		<img class="item-img" src="http://www.fourchetteandcie.com/pictures/{{ $item->sectionfullname() }}/500px/{{ $item->ref() }}.jpg">
	</div>

	<div id="ondisplay-details">


	{{-- CUTLERY FORM --}}
		@if($item->sectionfullname() == 'cutlery')

			<h2>{{ $item->stamped() }}</h2>
			<h5>{{ $item->descr() }} ({{ implode(", ", $item->categ()) }})</h5>
			<h5>€{{ $item->price() }}</h5>

			<br><br>

			{!! Form::open() !!}



				<input type='text' name='ref' value='{{ $item->ref() }}'><br>
				<input type='text' name='stamped' value='{{ $item->name() }}'><br>
				<input type='text' name='descr' value='{{ $item->descr() }}'><br>
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
				<input type='text' name='categ' value="{{ implode(', ', $item->categ()) }}"><br>
				<input type='text' name='price' value='{{ $item->price() }}'><br>

				<input type='submit' name='submit' value='UPDATE'>

			{!! Form::close() !!}

	{{-- CAKE STAND FORM --}}
		@elseif($item->sectionfullname() == 'cake-stand')

			<h2>{{ $item->name() }}</h2>
			<h5>{{ $item->descr() }} ({{ implode(", ", $item->categ()) }})</h5>
			<h5>€{{ $item->price() }}</h5>

			<br><br>

			{!! Form::open() !!}



				<input type='text' name='ref' value='{{ $item->ref() }}'><br>
				<input type='text' name='stamped' value='{{ $item->name() }}'><br>
				{{-- <input type='text' name='descr' value='{{ $item->descr() }}'><br> --}}
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
				<input type='text' name='categ' value="{{ implode(', ', $item->categ()) }}"><br>
				<input type='text' name='price' value='{{ $item->price() }}'><br>

				<input type='submit' name='submit' value='UPDATE'>

			{!! Form::close() !!}

		@endif


		{{-- <a href="{{ $item->id + 1 }}">next</h2> --}}

	</div>



@stop
