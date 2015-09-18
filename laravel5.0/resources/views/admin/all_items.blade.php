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
			z-index: 50;
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
@stop

@section('content')

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
				<div class='result' item-ref='{{ $item->ref }}'>
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
