@extends('home_layout')

@section('page_title', 'Fourchette &amp; Cie')

@section('include')
	<link rel="stylesheet" href="css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="css/basket.css" type="text/css" media="all"/>

	<style>
		html, body
		{
			margin-top: 30px;
		}
	</style>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="js/layout.js"></script>
	<script src="js/reach_basket.js"></script>
@stop

@section('basket')

	<table id="basket-contents">
	</table>

@stop


@section('content')

	<div id="home-content">
		<div class="block-link" id="block-link-title">
			<img id="title" src="pictures/home/title_mint.png" width="60%" style="display: block; margin: auto;">
			<br><br><br>
			<h2 style="color: #FFFFFF; text-align: center; display: block; margin: auto; font-weight: bold; border: 2px solid #FFFFFF; width: 500px;">SITE STILL IN CONSTRUCTION<h2>
			<p style="color: #FFFFFF; text-align: center;">Sorry for the inconvenience. All will be finished soon.</p>
		</div>

		{{-- <div id="novelties" style="border-bottom: 20px solid #7CFFB1;">
			@foreach($novelties as $section => $value)
			@foreach($value as $ref)
				<a href="" style="width: 25%; float: left; margin: 0;"><img src="pictures/{{$section}}/500px/{{$ref}}.jpg" width="100%"></a>
			@endforeach
			@endforeach
		</div> --}}

		<div class="block-link-left" id="block-link-silverware">
		</div>
		<div class="block-link-right">
			<h3>HANDSTAMPED SILVERWARE</h3>
			<p>Say it with words! Our keepsake silverware are all handstamped with love in our little French atelier. Here you will find an ever growing collection of sayings and words all the better to express your feelings, wishes or to mark a special occasion! We scour flea markets, garage sales, and old dusty drawers around France and Europe to find the treasure that will become a poetic keepsake.</p>
			<br>
			<a href="#" class="a-button-style">COMING SOON</a>
		</div>


		<div class="block-link-left">
			<h3>CAKE STANDS</h3>
			<p>Having a tea party, wedding party, birthday party, garden party or any other kind of party? These cake stands will bring height and delight to your table. Made with vintage French plates.</p>
			<br>
			<a href="#" class="a-button-style">COMING SOON</a>
		</div>
		<div class="block-link-right" id="block-link-cake-stand">
		</div>


		<div class="block-link-left" id="block-link-furniture">
		</div>
		<div class="block-link-right">
			<h3>FURNITURE</h3>
			<p>All our furniture is found by us and left in it's "jus" (juice in French) so that you can paint, re-upholster to your heart's desire! We bring French and vintage to your door step.</p>
			<br>
			<a href="#" class="a-button-style">COMING SOON</a>
		</div>


		<div class="block-link-left">
			<h3>BRIC-A-BRAC</h3>
			<p>Bring your home some love and interest with something unique, cool and French from our curated collection of charming objects.</p>
			<br>
			<a href="#" class="a-button-style">COMING SOON</a>
		</div>
		<div class="block-link-right" id="block-link-bric-a-brac">
		</div>


		<div class="block-link-left" id="block-link-lighting">
		</div>
		<div class="block-link-right">
			<h3>LUMINAIRES</h3>
			<p>A curated collection of vintage, unique, French chandeliers and mid century lighting.</p>
			<br>
			<a href="#" class="a-button-style">COMING SOON</a>
		</div>





		<div class="block-link-left">
			<h3 style="color: #444444; ">ABOUT US</h3>
			<p style="color: #444444;">fourchetteandcie@gmail.com</p>
			<br>
			<a href="#" class="a-button-style">COMING SOON</a>
		</div>
		<div class="block-link-right" id="block-link-about-us">
		</div>
	</div>

@stop
