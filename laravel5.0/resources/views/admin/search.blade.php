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
		#search-box
		{
			display: table;
			margin: auto;
			width: 70%;
			height: 42px;
			padding: 0px 5px;
			font-size: 18px;
			font-family: "Roboto Condensed", Helvetica, sans-serif;
			font-weight: 300;
			border: 1px solid #555555;			
		}
		#search-tags
		{
			display: table-cell;
		}
		#search-text
		{
			display: table-cell;
			height: 40px;
			width: 100%;
			border: none;
			background-color: #EEEEEE;
			outline: none;
			font-size: 18px;
			font-family: "Roboto Condensed", Helvetica, sans-serif;
			font-weight: 300;
		}
		#results-box
		{
			width: 50%;
			display: block;
			margin: auto;
			background-color: #FAFAFA;
		}
		span.tag
		{
			padding: 3px 6px 3px 6px;
			color: #FFFFFF;
			background-color: #000000;
			border-radius: 5px;
		}
	</style>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/searchdb.js"></script>
@stop

@section('content')
	
	<h2>Search Item</h2>
	<div id="search-box">
		<div id="search-tags"><span class="tag">&#64;section</span> <span class="tag">#ref</span></div>
		<input id="search-text" type="text" >
	</div>



	
@stop