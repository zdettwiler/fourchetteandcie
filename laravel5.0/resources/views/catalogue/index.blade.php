{{-- Catalogue --}}
@extends('master_layout')

@section('page_title', 'Catalogue')

@section('include')
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://localhost/fourchetteandcie/public/css/basket.css" type="text/css" media="all"/>

	<style>
		span.boxed
		{
			display: inline-block;
			height: 20px;
			width: 30px;
			color: #FFFFFF;
			background-color: #000000;
			text-align: center;
			font-style: normal;
		}
		table
		{
			width: 100%;
		}
	</style>
	
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/layout.js"></script>
	<script src="http://localhost/fourchetteandcie/public/js/reach_basket.js"></script>
@stop

@section('basket')

	<table id="basket-contents">
	</table>

@stop

@section('content')

	@foreach($section_list as $section)
		@if($section == 'cutlery')

			<h2>Cutlery</h2>
		
			<table>
				@foreach($items['cutlery'] as $item)
					<tr>
						<td><img class='item-img' src='http://localhost/fourchetteandcie/public/pictures/{{ $section }}/100px/{{ $item->ref }}_thumb.jpg' height='50'></td>
						<td><span class="boxed">{{ $item->ref }}</span> <b>{{ $item->stamped }}</b><br>
							{{ $item->descr }} ({{ $item->categ }})</td>
						<td>€{{ $item->price }}</td>
						
					</tr>
				@endforeach
			</table>

		@elseif($section == 'cake-stand')

			<h2>Cake Stand</h2>
		
			<table>
				@foreach($items['cake-stand'] as $item)
					<tr>
						<td><img class='item-img' src='http://localhost/fourchetteandcie/public/pictures/{{ $section }}/100px/{{ $item->ref }}_thumb.jpg' height='50'></td>
						<td><span class="boxed">{{ $item->ref }}</span> <b>{{ $item->name }}</b><br>
							({{ $item->categ }})</td>
						<td>€{{ $item->price }}</td>
						
					</tr>
				@endforeach
			</table>

		@endif

	@endforeach

@stop