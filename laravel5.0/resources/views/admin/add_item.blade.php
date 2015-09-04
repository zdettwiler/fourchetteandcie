@extends('admin_layout')

@section('page_title', 'Admin // Add Item')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin_forms.css" type="text/css" media="all"/>
	<style>


	</style>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://localhost/display-only/fourchetteandcie/public_html/js/layout.js"></script>

	<script>
		function preview_img(input)
		{

			if (input.files && input.files[0])
			{
				$.each(input.files, function( key, value ) {
					var reader = new FileReader();

					reader.onload = function (e)
					{
						$("#img-preview-container").append("<img class='img-preview' src='"+e.target.result+"' height='400' width='400'><br>");
						// $('#img-preview').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[key]);
				});
			}

		}

		$(function() {
			$("input[type='file']").change(function() {
				preview_img(this);
			});
		}
	</script>
@stop

@section('notification-bar')

	@if(Session::has('notification'))
		<div id="notification" class="{{ Session::get('notification')['type'] }}">
			<p>{{ Session::get('notification')['message'] }}</p>
		</div>
	@endif

@stop

@section('content')
	{!! Form::open(['files' => true]) !!}
		{!! Form::file('img_key_holder[]', ['multiple'=>true]) !!}
		{!! Form::submit('ADD TO CATALOGUE'); !!}
	{!! Form::close() !!}
@stop
