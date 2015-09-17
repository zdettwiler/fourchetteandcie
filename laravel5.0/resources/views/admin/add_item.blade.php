@extends('admin_layout')

@section('page_title', 'Admin // Add Item')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/admin_forms.css" type="text/css" media="all"/>
	<style>
		#new-item-img
		{
			display: inline-block;
			width: 300px;
			height: 400px;
			float: left;
			margin-right: 20px;
		}
		#new-item-details
		{
			display: inline-block;
			width: 100%;
		}

		input[type="text"]
		{
			background-color: #FFFFFF;
			border: none;
			margin: 5px 0;
			width: 100%;
		}
		#new-item-name
		{
			font-family: "Roboto Condensed", Helvetica, sans-serif;
			font-size: 40px;
		}
		#new-item-descr
		{
			width: 80%;
			float: left;
			font-size: 30px;
			font-style: italic;
		}
		#new-item-price
		{
			width: 20%;
			float: right;
			font-size: 30px;
		}
		#new-item-category
		{
			font-size: 30px;
		}


		#progress-bar
		{
			position: fixed;
			top: 60px;
			left: 0px;
			width: 0%;
			height: 5px;
			background-color: #7CFFB1;
			box-shadow: 0 0 15px #7CFFB1, 0 0 5px #7CFFB1;
		}

	</style>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://localhost/display-only/fourchetteandcie/public_html/js/layout.js"></script>

	<script>
		$(function() {
			var imgs = $("#new-item-imgs"),
				file_reader = new FileReader();
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
						form_data.append("imgs[]", file);
					}
				}
			});

			$("input[type='submit']").click(function(event){
				event.preventDefault();
				form_data.append("_token", $('input[name=_token]').val());
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
				beforeSend: function() {},
				xhr: function() {
					myXhr = $.ajaxSettings.xhr();
					if(myXhr.upload)
					{
						myXhr.upload.addEventListener('progress', function(event) {
							if(event.lengthComputable)
							{
								var percentComplete = (event.loaded / event.total) * 100;
								$('#progress-bar').css('width', percentComplete +'%');
							}
						}, false);
					}
					else
					{
						console.log("Uploadress is not supported.");
					}

					return myXhr;
				},
				success: function(response) {
					console.log('YES');
				}
			})
		}
		function show_imgs_to_upload(source)
		{
			$("#new-item-img-preview").attr("src", source);
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

	<div id="progress-bar">
	</div>

	{!! Form::open(['files' => true]) !!}

	    <div id='new-item-img'>
            <img id="new-item-img-preview" src="" width="300px" height="300px">
			{!! Form::file('imgs[]', ['id'=>'new-item-imgs', 'multiple'=>true]) !!}
        </div>

        <div style="overflow: hidden">
        <div id="new-item-details">
            <input id="new-item-name" type="text" placeholder="add a name">
        	<input id="new-item-price" type="text" placeholder="€0.00"><br>
            <input id="new-item-descr" type="text" placeholder="add a description"><br>
            <input id="new-item-categ" type="text" placeholder="add a category"><br><br><br>
        </div>
		</div>


		{!! Form::submit('ADD TO CATALOGUE'); !!}
	{!! Form::close() !!}
@stop
