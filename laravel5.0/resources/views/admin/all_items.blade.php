{{-- Admin - Catalogue --}}
@extends('admin_layout')

@section('page_title', 'Admin // Catalogue')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/basket.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/admin.css" type="text/css" media="all"/>

	<style>
		table
		{
			width: 70%;
			border-collapse: collapse;
		}
		td
		{
			text-align: center;
		}
		td.cell-check
		{
			width: 90px;
		}
		tr.table-header
		{
			color: #FFFFFF;
			background-color: #222222;
			border-bottom: 2px solid #000000;
		}

		td.cell-details
		{
			text-align: left;
			padding: 10px;
			vertical-align: middle;
		}


		span.edit-text,
		span.edit-toggle
		{
			font-style: normal;
		}
		span.edit-text,
		span.edit-toggle
		{
			cursor: pointer;
		}

		#search-results
		{
			display: none;
		}

	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://www.fourchetteandcie.com/js/layout.js"></script>
	<script src="http://www.fourchetteandcie.com/js/reach_edit_items_reload.js"></script>
	<script src="http://www.fourchetteandcie.com/js/search_db_2.js"></script>
@stop


@section('content')

	<div id='search-box'>
		<div id='search-tags'></div>
		<div style='overflow: hidden'>
			<input id='search-input' type='text' autocomplete='off' placeholder='search an item' >
		</div>
	</div>

	<div id='search-results'>
		<h2>Search Results</h2>

		<table>
			<tr class="table-header">
				<td class="cell-img"></td>
				<td class="cell-details">Details</td>
				<td class="cell-check">New</td>
				<td class="cell-check">Best Seller</td>
				<td class="cell-check">Sold Out</td>
				<td class="cell-price">Price</td>
			</tr>

			<div id="results"></div>
		</table>
	</div>

	<div id='db_items'>

	{{-- SORT BY SECTION --}}
	@foreach($section_list as $section)
		@if($section == 'cutlery')

			<h2>Cutlery</h2>

			{{-- SORT BY CATEG --}}
			@foreach($cutlery_categ_list as $cutlery_categ)

				<h3>{{ $cutlery_categ }}</h3>

				<table>
					<tr class="table-header">
						<td class="cell-img"></td>
						<td class="cell-details">Details</td>
						<td class="cell-check">New</td>
						<td class="cell-check">Best Seller</td>
						<td class="cell-check">Sold Out</td>
						<td class="cell-price">Price</td>

					</tr>

					{{-- GO THROUGH ITEMS --}}
					@foreach($items['cutlery'] as $item)

						{{-- CHECK IF IN CATEG --}}
						@if( in_array($cutlery_categ, explode(', ', $item->categ)) )

							<tr item-ref="{{ $item->ref }}">
								<td class="cell-img">
									<img class='item-img' src='http://www.fourchetteandcie.com/pictures/{{ $item->ref[0] }}/500px/{{ $item->ref }}.jpg' height='200'>
								</td>
								<td class="cell-details">
									<span class="ref-box">{{ $item->ref }}</span>
									<b><span class="edit-text" target="EDIT_STAMPED">{{ $item->stamped }}</span></b><br>
									<span class="edit-text" target="EDIT_DESCR">{{ $item->descr }}</span><br>
									(<span class="edit-text" target="EDIT_CATEG">{{ $item->categ }}</span>)
								</td>
								<td class="cell-check">
									<span class="edit-toggle" target="TOGGLE_NEW">
										<img src="http://www.fourchetteandcie.com/pictures/{{ $item->is_new }}.png">
									</span>
								</td>
								<td class="cell-check">
									<span class="edit-toggle" target="TOGGLE_BEST_SELLER">
										<img src="http://www.fourchetteandcie.com/pictures/{{ $item->is_best_seller }}.png">
									</span>
								</td>
								<td class="cell-check">
									<span class="edit-toggle" target="TOGGLE_SOLD_OUT">
										<img src="http://www.fourchetteandcie.com/pictures/{{ $item->is_sold_out }}.png">
									</span>
								</td>
								<td class="cell-price">
									€ <span class="edit-text" target="EDIT_PRICE">{{ $item->price }}</span>
								</td>

							</tr>

						@endif
						{{-- END CHECK IF IN CATEG --}}

					@endforeach
					{{-- END GO THROUGH ITEMS --}}

				</table>

			@endforeach
			{{-- END SORT BY CATEG --}}

		@elseif($section == 'cake-stand')

			<h2>Cake Stand</h2>

			<table>
				@foreach($items['cake-stand'] as $item)
					<tr>
						<td class="cell-img"><img class='item-img' src='http://www.fourchetteandcie.com/pictures/{{$item->ref[0] }}/100px/{{ $item->ref }}_thumb.jpg' height='50'></td>
						<td class="cell-details"><span class="ref-box">{{ $item->ref }}</span> <b>{{ $item->name }}</b><br>
							{{ $item->categ }} ({{ $item->categ }})</td>
						<td class="cell-price">€{{ $item->price }}</td>

					</tr>
				@endforeach
			</table>

		@endif

	@endforeach
	{{-- END SORT BY SECTION --}}

	</div>

@stop
