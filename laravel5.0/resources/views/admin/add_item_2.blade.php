{{-- Admin - Add Item --}}
@extends('admin_layout')

@section('page_title', 'Admin // Add Item')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin_forms.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="".public_path()."/js/layout.js"></script>
	<script type="text/javascript">
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

		/*function preview_img(input)
		{

			if (input.files && input.files[0])
			{
				$.each(input.files, function( key, value ) {
					var reader = new FileReader();

					$("#img-preview-container").append("<img id='img-preview-"+key+"' src='' height='200' width='200'>");

					reader.onload = function (e, key)
					{
						$('#img-preview-'+key).attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[key]);
				});
			}
		}*/

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
			var sections = ["cutlery", "cake-stand", "key-holder"];

			$("select[name='section']").change(function() {
				$.each(sections, function(index, value) {
					$("#form-container-"+value).hide();
				});

				$("#form-container-"+$(this).val()).show();
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

	@if(Session::has('notification'))
		<div id="notification" class="{{ Session::get('notification')['type'] }}">
			<p>{{ Session::get('notification')['message'] }}</p>
		</div>
	@endif

@stop

@section('content')

	{!! Form::open(['files' => true]) !!}

		{!! Form::select('section', array(
					'' => 'Select Section',
					'cutlery' => 'Cutlery',
					'cake-stand' => 'Cake Stand',
					'key-holder' => 'Key Holder',
					'furniture' => 'Furniture',
					'bric-a-brac' => 'Bric-à-Brac'
				));		!!}<br><br>
		<div id="img-preview-container">
		</div>

		<div id="form-container">
			{{-- CATEG LIST CUTLERY --}}
			<div id="form-container-cutlery">
				<div id="cutlery-stamped">
					<h2>Item Stamped</h2>
					{!! Form::text('stamped_cutlery') !!}<br><br>
				</div>

				<div id="cutlery-img">
					<h2>Item Picture</h2>
					{!! Form::file('img_cutlery[]', ['multiple'=>true]) !!}<br><br>
				</div>

				<div id="cutlery-categ">
					<h2>Category</h2>
					<label>{!! Form::checkbox('categs_cutlery[0]', 'teaspoon', true) !!}Teaspoon</label><br>
					<label>{!! Form::checkbox('categs_cutlery[1]', 'big-spoon') !!}Big Spoon</label><br>
					<label>{!! Form::checkbox('categs_cutlery[2]', 'dessert-spoon') !!}Dessert Spoon</label><br>
					<label>{!! Form::checkbox('categs_cutlery[3]', 'baby-spoon') !!}Baby Spoon</label><br>
					<label>{!! Form::checkbox('categs_cutlery[4]', 'big-fork') !!}Big Fork</label><br>
					<label>{!! Form::checkbox('categs_cutlery[5]', 'dessert-fork') !!}Dessert Fork</label><br>
					<label>{!! Form::checkbox('categs_cutlery[6]', 'knife') !!}Knife</label><br>
					<label>{!! Form::checkbox('categs_cutlery[7]', 'serving-spoon') !!}Serving Spoon</label><br>
					<label>{!! Form::checkbox('categs_cutlery[8]', 'serving-fork') !!}Serving Fork</label><br>
					<label>{!! Form::checkbox('categs_cutlery[9]', 'cake-server') !!}Cake Server</label><br>
					<label>{!! Form::checkbox('categs_cutlery[10]', 'ladle') !!}Ladle</label><br>
					<label>{!! Form::checkbox('categs_cutlery[11]', 'pair') !!}Pair</label><br>
					<label>{!! Form::checkbox('categs_cutlery[12]', 'christmas') !!}Christmas</label><br><br>
				</div>

				<div id="cutlery-descr">
					<h2>Item Description</h2>
					{!! Form::text('descr_cutlery', 'Teaspoon') !!}<br><br>
				</div>

				<div id="cutlery-price">
					<h2>Item Price</h2>
					<p class="form-label">€</p>{!! Form::text('price_cutlery', '15') !!}<br><br>
				</div>

				{!! Form::submit('ADD TO CATALOGUE'); !!}


			</div>
			{{-- END CATEG LIST CUTLERY --}}

			{{-- CATEG LIST CAKE STAND --}}
			<div id="form-container-cake-stand">
				<div id="cutlery-img">
					<h2>Item Picture</h2>
					{!! Form::file('img_cake_stand[]', ['multiple'=>true]) !!}<br><br>
				</div>

				<div id="cake-stand-categ">
					<h2>Category</h2>
					{!! Form::checkbox('categs_cake_stand[0]', 'two-plates') !!}<p class="form-label">Two Plates</p><br>
					{!! Form::checkbox('categs_cake_stand[1]', 'two-oval-plates') !!}<p class="form-label">Two Oval Plates</p><br>
					{!! Form::checkbox('categs_cake_stand[2]', 'plate-gravy-boat') !!}<p class="form-label">Plate Gravy Boat</p><br>
					{!! Form::checkbox('categs_cake_stand[3]', 'three-plates') !!}<p class="form-label">Three Plates</p><br>
				</div>

				<div id="cake-stand-name">
					<h2>Item Name</h2>
					{!! Form::text('name_cake_stand') !!}<br>
				</div>

				<div id="cake-stand-price">
					<h2>Item Price</h2>
					<p class="form-label">€</p>{!! Form::text('price_cake_stand') !!}<br><br>
				</div>

				{!! Form::submit('ADD TO CATALOGUE'); !!}
			</div>
		{{-- END CATEG LIST CAKE STAND --}}

		{{-- CATEG LIST KEY HOLDER --}}
			<div id="form-container-key-holder">
				<div id="key-holder-img">
					<h2>Item Picture</h2>
					{!! Form::file('img_key_holder[]', ['multiple'=>true]) !!}<br><br>
				</div>

				<div id="key-holder-categ">
					<h2>Category</h2>
					{!! Form::checkbox('categs_key_holder[0]', 'teaspoon', true) !!}<p class="form-label">Teaspoon</p><br>
					{!! Form::checkbox('categs_key_holder[1]', 'big-spoon') !!}<p class="form-label">Big Spoon</p><br>
					{!! Form::checkbox('categs_key_holder[2]', 'dessert-spoon') !!}<p class="form-label">Dessert Spoon</p><br>
					{!! Form::checkbox('categs_key_holder[3]', 'baby-spoon') !!}<p class="form-label">Baby Spoon</p><br>
					{!! Form::checkbox('categs_key_holder[4]', 'big-fork') !!}<p class="form-label">Big Fork</p><br>
					{!! Form::checkbox('categs_key_holder[5]', 'dessert-fork') !!}<p class="form-label">Dessert Fork</p><br>
					{!! Form::checkbox('categs_key_holder[6]', 'knife') !!}<p class="form-label">Knife</p><br>
					{!! Form::checkbox('categs_key_holder[7]', 'serving-spoon') !!}<p class="form-label">Serving Spoon</p><br>
					{!! Form::checkbox('categs_key_holder[8]', 'serving-fork') !!}<p class="form-label">Serving Fork</p><br>
					{!! Form::checkbox('categs_key_holder[9]', 'cake-server') !!}<p class="form-label">Cake Server</p><br>
					{!! Form::checkbox('categs_key_holder[10]', 'ladle') !!}<p class="form-label">Ladle</p><br>
					{!! Form::checkbox('categs_key_holder[11]', 'pair') !!}<p class="form-label">Pair</p><br>
					{!! Form::checkbox('categs_key_holder[12]', 'christmas') !!}<p class="form-label">Christmas</p><br><br>
				</div>

				<div id="key-holder-stamped">
					<h2>Item Stamped</h2>
					{!! Form::text('stamped_key_holder') !!}<br><br>
				</div>

				<div id="key-holder-descr">
					<h2>Item Description</h2>
					{!! Form::text('descr_key_holder', 'Teaspoon') !!}<br><br>
				</div>

				<div id="key-holder-price">
					<h2>Item Price</h2>
					<p class="form-label">€</p>{!! Form::text('price_key_holder', '15') !!}<br><br>
				</div>

				{!! Form::submit('ADD TO CATALOGUE'); !!}
			</div>
		</div>




	{!! Form::close() !!}
@stop
