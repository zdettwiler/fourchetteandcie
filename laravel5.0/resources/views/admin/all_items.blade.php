{{-- Admin - Catalogue --}}
@extends('admin_layout')

@section('page_title', 'DEV Items')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>

	<style>
		h2
		{
			text-align: center;
		}
		/* SEARCH BOX */
		#search-container
		{
			position: relative;
			width: 70%;
			margin: auto;
		}
		#search-box
		{
			display: block;
			position: relative;
			width: 100%;
			height: 42px;
			margin: 0 auto 10px auto;
			padding: 3px 2px;
			border-radius: 7px;
			background: #FFFFFF;
			box-shadow: 0 0 10px rgba(124, 255, 177, 0.7);
		}
		#search-tags
		{
			display: inline-block;
			float: left;
		}
		.search-tag
		{
			display: inline-block;
			height: 36px;
			font-size: 27px;
			font-family: "Roboto Condensed", Helvetica, sans-serif;
			font-weight: 300;
			color: #FFFFFF;
			background-color: #76F2A8;
			border-radius: 7px;
			font-style: normal;
			padding: 1px 4px;
			margin: 0 1px;
		}
		.search-tag .hidden-data
		{
			display: none;
		}
		#loading
		{
			display: none;
			float: right;
			overflow: hidden;
			height: 35px;
			width: 35px;
		}
		#loading img
		{
			overflow: hidden;
			height: 35px;
			width: 35px;
		}

		#search-input
		{
			display: inline-block;
			-moz-box-sizing: border-box;
		    -webkit-box-sizing: border-box;
		    box-sizing: border-box;
			-webkit-appearance: none;

		    width: 100%;
			height: 35px;
			margin-left: 5px;

			font-size: 27px;
			font-family: "Roboto Condensed", Helvetica, sans-serif;
			font-weight: 300;
			outline: none;
			border: none;
		}

		#search-box #search-input:focus
		{
			border: 1px solid #000000;
			border-color: #FFFFFF;
			box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
		}
		p#search-info
		{
			display: block;
			margin: 0px auto;
			text-align: center;
			padding: 0;
			color: #888888;
			position: relative;
		}
		#results-box
		{
			width: 100%;
			display: block;
			margin: auto;
			background-color: #FAFAFA;
			position: relative;
		}
		.result
		{
			width: 100%;
			height: 200px;
			margin: 2px 0;
			float: left;
		}
		.result-img
		{
			width: 200px;
			height: 200px;
			margin-right: 20px;
			float: left;
		}
		.result-details
		{
			height: 200px;
			width: 100%;
			float: left;
		}

		.editable
		{
			cursor: pointer;
		}
		.result-details span
		{
			font-family: "Source Sans Pro", Helvetica, sans-serif;
		}
		.result-name
		{
			margin: 10px 0 0 0;
			padding: 0;
			font-size: 30px;
		}
		.result-descr
		{
			margin: 0;
			padding: 0;
			font-size: 20px;
			font-style: italic;
		}
		.result-categ
		{
			margin: 0;
			padding: 0;
			font-size: 20px;

		}
		.result-price
		{
			margin: 0;
			padding: 0;
			font-size: 20px;
			text-align: right;
			float: right;
		}

		.toggleable
		{
			cursor: pointer;
		}
		div.is-or-not-0
		{
			margin: 2px;
			padding-top: 5px;
			float: left;
			width: 50px;
			height: 50px;
			background-color: #DDDDDD;
		}
		div.is-or-not-1
		{
			margin: 2px;
			padding-top: 5px;
			float: left;
			width: 50px;
			height: 50px;
			background-color: #ACFFC4;
		}
		div.is-or-not-0 p,
		div.is-or-not-1 p
		{
			margin: 0;
			font-size: 12px;
			text-align: center;
		}
		div.is-or-not-0 img,
		div.is-or-not-1 img
		{
			display: block;
			margin: auto;
		}

		#img-manager
		{
			display: block;
			width: 70%;
			height: 70%;
			padding: 10px;
			position: fixed;
			top: -5000px;
			left: 15%;
			background-color: #FFFFFF;
			z-index: 51;
			box-shadow: inset 0 10px 20px -20px #000000;
		}
		#img-manager h2,
		#img-manager p
		{
			text-align: center;
			margin: 0;
		}
		#img-manager #img-manager-imgs
		{
			display: block;
			margin: auto;
		}
		#img-manager #img-manager-imgs img
		{
			width: 200px;
			height: 200px;
		}
		#img-manager-imgs .img-container
		{
			width: 200px;
			width: 200px;
			margin: 5px;
			position: relative;
			float: left;
		}
		#img-manager-imgs .img-container #progress-bar
		{
			position: absolute;
			bottom: 4px;
			left: 0px;
			width: 50%;
			height: 10px;
			background-color: #7CFFB1;
		}
	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/mustache.js"></script>
	{{-- <script src="http://localhost/display-only/fourchetteandcie/public_html/js/search_db.js"></script> --}}
	<script src="http://www.fourchetteandcie.com/js/search_db.js"></script>
	{{-- <script src="http://localhost/display-only/fourchetteandcie/public_html/js/reach_edit_items_reload.js"></script> --}}
	<script src="http://www.fourchetteandcie.com/js/reach_edit_items_reload.js"></script>

	<script>
		function display_response(json_results)
		{
			var results = $.parseJSON(json_results);
			var template_search_result_order_validation = $("#template-editable-items").html();
			$("#results-box").html('');

			if($.isEmptyObject(results))
			{
				$("#results-box").append("<tr class='result'>\n <td colspan='3'><p>No result...</p></td>\n </tr>");
			}
			else
			{
				$.each( results, function( i, result ) {
					result.ref_section = result.ref.substr(0,1);
					$("#results-box").append( Mustache.render(template_search_result_order_validation, result) );
				});
			}

			return false;
		}
	</script>

	<script>
		$(function() {
			var file_reader = new FileReader(),
				form_data = new FormData();

			$('body').on('change', '#new-imgs', function() {
				var i = 0, len = this.files.length, img, file;

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
						form_data.append("new_img", file);
					}
				}
				upload_nem_img(form_data);


			});

			$('body').on('click', '.result-img img', function() {
				var item_ref = $(this).parents('div.result').attr('item-ref');
				var item_img_count = parseInt($(this).parents('div.result').attr('item-img-count'));
				form_data.append("ref", item_ref);
				form_data.append("img_nb", (item_img_count+1));
				form_data.append("_token", $('input[name=_token]').val());

				build_img_manager(item_ref, item_img_count);
			});

			$('#fade').click(function() {
				$('#img-manager').animate({'top': '-5000px'}, 500);
			})

		});

		function build_img_manager(ref, img_count)
		{
			var i=1;

			$('#fade').show();
			$('#img-manager span.ref-box').html(ref);
			$('#img-manager-imgs').html('');

			for(i=1 ; i<=img_count ; i++)
			{
				if(i == 1)
				{
					$('#img-manager-imgs').append("<div class='img-container'><img src='http://fourchetteandcie.com/pictures/"+ ref.substr(0,1) +"/500px/"+ ref +".jpg' width='200px'></div>");
				}
				else
				{
					$('#img-manager-imgs').append("<div class='img-container'><img src='http://fourchetteandcie.com/pictures/"+ ref.substr(0,1) +"/500px/"+ ref +"_"+ i +".jpg' width='200px'></div>");
				}
			}

			$('#img-manager').animate({'top': '60px'}, 500);
		}

		function upload_nem_img(form_data)
		{
			$.ajax({
				type: 'POST',
				url: $('form').attr('action'),
				data: form_data,
				processData: false,
				contentType: false,
				beforeSend: function() {
					$('#progress-bar').css('width', '0%');
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
				success: function(response) {
					response = $.parseJSON(response);
					$('#progress-bar').animate({'width': 100 +'%'}, 200).delay(200).fadeOut(400, function() {
						$(this).remove();
					});
					$("div.result[item-ref='"+ response.ref +"']").attr('item-img-count', response.img_nb);
					form_data.append("img_nb", (parseInt(response.img_nb)+1));
				},
				error: function(error) {
					console.log(error);
					// $('#progress-bar').animate({'width': '100%', 'background-color': '#e74c3c'}, 200).css('box-shadow', '0 0 10px #e74c3c');
				}
			})
		}
		function show_imgs_to_upload(source)
		{
			$('#img-manager-imgs').append("<div class='img-container'><img src='"+ source +"' width='200px'><div id='progress-bar'></div></div>");
		}
	</script>
@stop

@section('content')

	<div id='img-manager'>
		<h2>Image Manager</h2>
		<p><span class='ref-box'></span></p>

		<div id='img-manager-imgs'>
		</div>

		{!! Form::open(['files' => true, 'action' => 'AdminItemsController@post_new_img']) !!}
			{!! Form::file('new_imgs', ['id'=>'new-imgs']) !!}
		{!! Form::close() !!}
	</div>

	<p id='search-info'>try [#]+ref+[space]</i>, <i>&#36;section</i> or <i>@category</i>.</p><br>
	<div id='search-container'>
		<div id='search-box'>
			<div id='search-tags'></div>
			<div id='loading'><img src="http://fourchetteandcie.com/pictures/loading.gif"></div>
			<div style='overflow: hidden'>
				<input id='search-input' type='text' autocomplete='off' placeholder='search an item' >
			</div>
		</div>
	</div>

	<br><br>
	<div id='results-box' class='big-results'>
		@foreach($section_list as $section)
			@foreach($items[$section] as $item)
				<div class='result' item-ref='{{ $item->ref }}' item-img-count='{{ $item->img_count }}'>
			        <div class='result-img'>
			            <img src="http://fourchetteandcie.com/pictures/{{ $item->ref[0] }}/500px/{{ $item->ref }}.jpg" width="200px" height="200px">
			        </div>

			        <div style="overflow: hidden">
			        <div class="result-details">
			            <span class="ref-box">{{ $item->ref }}</span>
			            <span class="editable result-name" target="EDIT_NAME-{{ $item->ref }}" contenteditable="true">{{ $item->name }}</span><br>
			            <span class="editable result-price" target="EDIT_PRICE-{{ $item->ref }}" contenteditable="true">{{ $item->price }}</span>
			            <span class="editable result-descr" target="EDIT_DESCR-{{ $item->ref }}" contenteditable="true">{{ $item->descr }}</span><br>
			            <span class="result-categ" target="EDIT_CATEG-{{ $item->ref }}" contenteditable="false">{{ $item->categ }}</span><br><br>

			            <div class="is-or-not-{{ $item->is_new }} toggleable" target="TOGGLE_NEW-{{ $item->ref }}">
			                <p>new</p>
			                <img src="http://fourchetteandcie.com/pictures/{{ $item->is_new }}.png">
			            </div>

			            <div class="is-or-not-{{ $item->is_best_seller }} toggleable" target="TOGGLE_BEST_SELLER-{{ $item->ref }}">
			                <p>b. seller</p>
			                <img src="http://fourchetteandcie.com/pictures/{{ $item->is_best_seller }}.png">
			            </div>

			            <div class="is-or-not-{{ $item->is_sold_out }} toggleable" target="TOGGLE_SOLD_OUT-{{ $item->ref }}">
			                <p>sold out</p>
			                <img src="http://fourchetteandcie.com/pictures/{{ $item->is_sold_out }}.png">
			            </div>
			        </div>
			        </div>
			    </div>
			@endforeach
		@endforeach
	</div>

@stop

@section('mustache-templates')
	@include('mustache_template_editable_items')
@stop
