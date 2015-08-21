{{-- Admin - Edit Cake Stand Item --}}
@extends('admin_layout')

@section('page_title', 'Admin // Edit Cake Stand Item')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin_forms.css" type="text/css" media="all"/>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="".public_path()."/js/layout.js"></script>
	<script src="".public_path()."/js/reach_basket.js"></script>
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
			/*var xhr = new XMLHttpRequest();

			xhr.open('GET', '../functions/api.php?' + command, true);
			xhr.addEventListener('readystatechange', function() {

				if (xhr.readyState === 4 && xhr.status === 200)
				{
					$("table#basket-contents").html(xhr.responseText);
					basket_notification(command);	
				}
				else if (xhr.readyState == 4 && xhr.status != 200)
				{
					alert("ERROR!" + '\n\nCode :' + xhr.status + '\nText : ' + xhr.statusText + '\nMessage : ' + xhr.responseText);
				}
			}, false);

			xhr.send(null);
			// $('#scroll').jScrollPane().data('jsp').reinitialise();*/

			return false;
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

			$("input[type='submit']").on('click', function() {
				upload_progress();
			});
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
		</div>	

		<div id="form-container">

			<div id="categ-list-cake-stand">
				<div id="cutlery-img">
					<h2>Item Picture</h2>
					{!! Form::file('img_cake_stand[]', ['multiple'=>true]) !!}<br><br>
				</div>

				<div id="cake-stand-categ">
					<h2>Category</h2>
					{!! Form::checkbox('categs_cake_stand[0]', 'two-plates') !!}<p class="checkbox-label">Two Plates</p><br>
					{!! Form::checkbox('categs_cake_stand[1]', 'two-oval-plates') !!}<p class="checkbox-label">Two Oval Plates</p><br>
					{!! Form::checkbox('categs_cake_stand[2]', 'plate-gravy-boat') !!}<p class="checkbox-label">Plate Gravy Boat</p><br>
					{!! Form::checkbox('categs_cake_stand[3]', 'three-plates') !!}<p class="checkbox-label">Three Plates</p><br>
				</div>

				<div id="cake-stand-name">
					<h2>Item Name</h2>
					{!! Form::text('name_cake_stand') !!}<br>
				</div>

				<div id="cake-stand-price">
					<h2>Item Price</h2>
					<p class="checkbox-label">€</p>{!! Form::text('price_cake_stand') !!}<br><br>
				</div>

				{!! Form::submit('ADD TO CATALOGUE'); !!}
			</div>
		</div>

		
		

	{!! Form::close() !!}
@stop