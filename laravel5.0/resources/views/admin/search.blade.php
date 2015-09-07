{{-- Admin - SEARCH --}}
@extends('admin_layout')

@section('page_title', 'DEV Search')

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
			width: 100%%;
			height: 30px;
			z-index: 100;
			margin: 0 auto 10px auto;
			padding: 3px 2px;
			border-radius: 7px;
			background: #FFFFFF;
		}
		#search-tags
		{
			display: inline-block;
			float: left;
		}
		.search-tag
		{
			display: inline-block;
			height: 24px;
			font-size: 17px;
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
		#search-input
		{
			display: inline-block;
			-moz-box-sizing: border-box;
		    -webkit-box-sizing: border-box;
		    box-sizing: border-box;

		    width: 100%;
			height: 24px;
			margin-left: 5px;

			font-size: 17px;
			font-family: "Roboto Condensed", Helvetica, sans-serif;
			font-weight: 300;
			outline: none;
			border: none;
		}

		#search-box #search-input:focus
		{
			border: 1px solid #000000;border-color: #FFFFFF;
			box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
		}
		p#search-info
		{
			display: block;
			margin: 0px auto;
			text-align: center;
			padding: 0;
			color: #FFFFFF;
			z-index: 100;
			position: relative;
		}
		#results-box
		{
			width: 100%;
			display: block;
			margin: auto;
			background-color: #FAFAFA;
			z-index: 100;
			position: relative;
		}
		#results-box table
		{
			border-collapse: collapse;
			box-shadow: 0 0 10px rgba(124, 255, 177, 0.7);
		}
		#results-box table tr:hover
		{
			background-color: #EEEEEE;
			cursor: pointer;
		}
		#results-box table tr td
		{
			/*max-height: 50px;*/
			overflow: hidden;
			padding: 5px;
			vertical-align: middle;
			border-top: 1px solid #DDDDDD;
		}
		#results-box table tr td p
		{
			margin: 0px;
			padding: 0px;
			font-size: 15px;
		}
		#results-box table tr td.result-img
		{
			margin: 0px;
			padding: 0px;
			width: 200px;
		}
		#results-box table tr td.result-details
		{
			width: 90%;
		}

		#search-tag
		{
			color: #000000;
			background-color: #EEEEEE;
		}
	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/mustache.js"></script>
	{{-- <script src="http://localhost/display-only/fourchetteandcie/public_html/js/search_db.js"></script> --}}
	<script src="http://www.fourchetteandcie.com/js/search_db.js"></script>
@stop

@section('content')

	<h2>Search Item</h2>
	<p id='search-info'>try <i>+{space}</i>, <i>#ref</i>, <i>&#36;section</i> or <i>@category</i>.</p>
	<div id='search-container'>
		<div id='search-box'>
			<div id='search-tags'></div>
			<div style='overflow: hidden'>
				<input id='search-input' type='text' autocomplete='off' placeholder='search an item' >
			</div>
		</div>
	</div>

	<br><br>
	<h2 style="text-align: left;">Results:</h2>
	<div id='results-box' class='big-results'><table> </table></div>

@stop

@section('mustache-templates')
	@include('mustache_template')
@stop
