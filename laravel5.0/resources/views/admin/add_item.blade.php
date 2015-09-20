@extends('admin_layout')

@section('page_title', 'Admin // Add Item')

@section('include')
	<link rel="stylesheet" href="http://fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://fourchetteandcie.com/css/admin_forms.css" type="text/css" media="all"/>
	<style>
		#progress-bar
		{
			position: fixed;
			top: 60px;
			left: 0px;
			width: 0%;
			height: 3px;
			background-color: #7CFFB1;
			box-shadow: 0 0 10px #7CFFB1;
		}

		tr td
		{
			/*max-height: 50px;*/
			overflow: hidden;
			padding: 5px;
			vertical-align: middle;
			border-top: 1px solid #DDDDDD;
		}
		tr td p
		{
			margin: 0px;
			padding: 0px;
			font-size: 15px;
		}
		tr td.result-img
		{
			margin: 0px;
			padding: 0px;
			width: 200px;
		}
		tr td.result-details
		{
			width: 80%;
		}
		tr td.result-price
		{
			width: 20%;
		}

	</style>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/mustache.js"></script>
	<script src="http://fourchetteandcie.com/js/layout.js"></script>

	<script>
		$(function() {
			var imgs = $("#new-item-imgs"),
				file_reader = new FileReader(),
				form_data = new FormData();

			$('#new-item-imgs').change(function() {
				var i = 0, len = this.files.length, img, reader, file;

				for ( ; i< len ; i++)
				{
					file = this.files[i];

					if (!!file.type.match(/image.*/))
					{
						file_reader.onloadend = function(event) {
							show_imgs_to_upload(event.target.result);
						};
						file_reader.readAsDataURL(file);
						// form_data.append("imgs[]", file);
						form_data.append("new_item_imgs", file);
					}
				}
			});

			$("input[type='submit']").click(function(event){
				event.preventDefault();

				$("input:checkbox:checked").each(function(){
				    form_data.append("new_item_categ[]", $(this).val());
				});

				form_data.append("_token", $('input[name=_token]').val());
				form_data.append("new_item_section", $('select[name=new_item_section]').val());
				form_data.append("new_item_name", $('input[name=new_item_name]').val());
				form_data.append("new_item_price", $('input[name=new_item_price]').val());
				form_data.append("new_item_descr", $('input[name=new_item_descr]').val());
				submit_form(form_data);
			});

		});
		function submit_form(form_data)
		{
			$.ajax({
				type: 'POST',
				url: $('form').attr('action'),
				data: form_data,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('#progress-bar').css({'width': '0%', 'background-color': '#7CFFB1', 'box-shadow': '0 0 10px #7CFFB1'}).show();
				},
				xhr: function() {
					myXhr = $.ajaxSettings.xhr();
					if(myXhr.upload)
					{
						myXhr.upload.addEventListener('progress', function(event) {
							if(event.lengthComputable)
							{
								var percentComplete = 0.9 * (event.loaded / event.total) * 100;
								// $('#progress-bar').css('width', percentComplete +'%');
								$('#progress-bar').animate({'width': percentComplete +'%'}, 200);
							}
						}, false);
					}
					else
					{
						console.log("Uploadress is not supported.");
					}

					return myXhr;
				},
				success: function(json_response) {
					$('#progress-bar').animate({'width': '100%'}).delay(200).fadeOut();
					$('input[type=submit]').val('OK!');

					var new_item = $.parseJSON(json_response);
					var template_search_result_order_validation = $("#template-search-result").html();
					$("#notification-bar").html('');

					new_item.ref_section = new_item.ref.substr(0,1);
					$("#notification-bar").append("<div class='notification positive'><p>The item has been successfully added to the database!<br><br></p><table>" + Mustache.render(template_search_result_order_validation, new_item) + "</table></div>" );

					return false;
				},
				error: function(error) {
					console.log(error);
					$('#progress-bar').animate({'width': '100%', 'background-color': '#e74c3c'}, 200).css('box-shadow', '0 0 10px #e74c3c');
				}
			})
		}
		function show_imgs_to_upload(source)
		{
			$("#new-item-img-preview").attr("src", source);
		}
	</script>
@stop

@section('content')

	<div id="progress-bar">
	</div>

	<div id="notification-bar">
	</div>

	{!! Form::open(['files' => true]) !!}

	    <div id='new-item-img'>
            <img id="new-item-img-preview" src="" width="300px" height="300px">
			{{-- {!! Form::file('imgs[]', ['id'=>'new-item-imgs', 'multiple'=>true]) !!} --}}
			{!! Form::file('new_item_imgs', ['id'=>'new-item-imgs']) !!}
        </div>

        <div style="overflow: hidden">
        <div id="new-item-details">
			{!! Form::select('new_item_section', array(
						'cutlery' => 'Cutlery',
						'cake-stand' => 'Cake Stand'
						// 'furniture' => 'Furniture',
						// 'bric-a-brac' => 'Bric-à-Brac'
					));	!!}

			{!! Form::text('new_item_name', '', ['id'=>'new-item-name', 'placeholder'=>'add a name']) !!}
			{!! Form::text('new_item_price', '', ['id'=>'new-item-price', 'placeholder'=>'€0.00']) !!}
			{!! Form::text('new_item_descr', '', ['id'=>'new-item-descr', 'placeholder'=>'add a description']) !!}

			<label>{!! Form::checkbox('new_item_categ[0]', 'teaspoon', true) !!}Teaspoon</label>
			<label>{!! Form::checkbox('new_item_categ[1]', 'big-spoon') !!}Big Spoon</label>
			<label>{!! Form::checkbox('new_item_categ[2]', 'dessert-spoon') !!}Dessert Spoon</label>
			<label>{!! Form::checkbox('new_item_categ[3]', 'baby-spoon') !!}Baby Spoon</label>
			<label>{!! Form::checkbox('new_item_categ[4]', 'big-fork') !!}Big Fork</label>
			<label>{!! Form::checkbox('new_item_categ[5]', 'dessert-fork') !!}Dessert Fork</label>
			<label>{!! Form::checkbox('new_item_categ[6]', 'knife') !!}Knife</label>
			<label>{!! Form::checkbox('new_item_categ[7]', 'serving-spoon') !!}Serving Spoon</label>
			<label>{!! Form::checkbox('new_item_categ[8]', 'serving-fork') !!}Serving Fork</label>
			<label>{!! Form::checkbox('new_item_categ[9]', 'cake-server') !!}Cake Server</label>
			<label>{!! Form::checkbox('new_item_categ[10]', 'ladle') !!}Ladle</label>
			<label>{!! Form::checkbox('new_item_categ[11]', 'pair') !!}Pair</label>
			<label>{!! Form::checkbox('new_item_categ[12]', 'christmas') !!}Christmas</label><br>

			<label>{!! Form::checkbox('new_item_categ[20]', 'two-plates') !!}Two Plates</label>
			<label>{!! Form::checkbox('new_item_categ[21]', 'two-oval-plates') !!}Two Oval Plates</label>
			<label>{!! Form::checkbox('new_item_categ[22]', 'plate-gravy-boat') !!}Plate Gravy Boat</label>
			<label>{!! Form::checkbox('new_item_categ[23]', 'three-plates') !!}Three Plates</label>
        </div>
		</div>


		{!! Form::submit('ADD TO CATALOGUE'); !!}
	{!! Form::close() !!}
@stop

@section('mustache-templates')
	@include('mustache_template_search_result')
@stop
