{{-- Admin - Edit Cutlery Item --}}
@extends('admin_layout')

@section('page_title', 'Admin // Edit Cutlery Item')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin_forms.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/layout.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/reach_basket.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/jquery.zoom.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('div#img-preview-container').zoom();
		});
	</script>
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

		function upload_progress()
		{
		}

		$(function() {
			var sections = ["cutlery", "cake-stand"];

			$("select[name='section']").change(function() {
				$.each(sections, function(index, value) {
					$("#categ-list-"+value).hide();
				});

				$("#categ-list-"+$(this).val()).show();
			});

			$("input[type='file']").change(function() {
				preview_img(this);
			});

			// $("input[type='submit']").on('click', function() {
			// 	upload_progress();
			// });
		});

	</script>
@stop

@section('notification-bar')

	@if(Session::has('errors'))
		<div id="notification-bar">
			<p>
			@foreach (Session::get('errors') as $message)
				{{ $message}}{!! '<br>' !!}
			@endforeach
			</p>
		</div>
	@endif
	
@stop

@section('content')

	{!! Form::open(['files' => true]) !!}

		<div id="img-preview-container">
			<img class='img-preview' src='http://localhost/fourchetteandcie/public/pictures/{{ $item->get_sectionfullname() }}/500px/{{ $item->get_ref() }}.jpg' height='300' width='300'><br>
		</div>	

		<div id="form-container">

			<div id="categ-list-cutlery">
				<div class="form-field">
					<h2 class="item-title">{!! Form::text('stamped', $item->get_stamped() ) !!}</h2>
					<h5 class="item-details">{!! Form::text('descr', $item->get_descr() ) !!}
						{!! Form::text('price', $item->get_price() ) !!}</h5>
				</div>

				<div class="form-field">
					<h2>Item Picture</h2>
					{!! Form::file('imgs[]', ['multiple'=>true]) !!}<br><br>

				</div>

				<div class="form-field">
					<h2>Category</h2>
					{!! Form::checkbox('categs[0]', 'teaspoon', in_array('teaspoon', $item->get_categ())) !!}<p class="label">Teaspoon</p><br>
					{!! Form::checkbox('categs[1]', 'big-spoon', in_array('big-spoon', $item->get_categ())) !!}<p class="label">Big Spoon</p><br>
					{!! Form::checkbox('categs[2]', 'dessert-spoon', in_array('dessert-spoon', $item->get_categ())) !!}<p class="label">Dessert Spoon</p><br>
					{!! Form::checkbox('categs[3]', 'baby-spoon', in_array('baby-spoon', $item->get_categ())) !!}<p class="label">Baby Spoon</p><br>
					{!! Form::checkbox('categs[4]', 'big-fork', in_array('big-fork', $item->get_categ())) !!}<p class="label">Big Fork</p><br>
					{!! Form::checkbox('categs[5]', 'dessert-fork', in_array('dessert-fork', $item->get_categ())) !!}<p class="label">Dessert Fork</p><br>
					{!! Form::checkbox('categs[6]', 'knife', in_array('knife', $item->get_categ())) !!}<p class="label">Knife</p><br>
					{!! Form::checkbox('categs[7]', 'serving-spoon', in_array('serving-spoon', $item->get_categ())) !!}<p class="label">Serving Spoon</p><br>
					{!! Form::checkbox('categs[8]', 'serving-fork', in_array('serving-fork', $item->get_categ())) !!}<p class="label">Serving Fork</p><br>
					{!! Form::checkbox('categs[9]', 'cake-server', in_array('cake-server', $item->get_categ())) !!}<p class="label">Cake Server</p><br>
					{!! Form::checkbox('categs[10]', 'ladle', in_array('ladle', $item->get_categ())) !!}<p class="label">Ladle</p><br>
					{!! Form::checkbox('categs[11]', 'pair', in_array('pair', $item->get_categ())) !!}<p class="label">Pair</p><br>
					{!! Form::checkbox('categs[12]', 'christmas', in_array('christmas', $item->get_categ())) !!}<p class="label">Christmas</p><br><br>
				</div>

				{!! Form::submit('UPDATE'); !!}

				
			</div>

	{!! Form::close() !!}
@stop