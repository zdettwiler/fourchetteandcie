@extends('master_layout')

@section('page_title', 'Personalised Cutlery')

@section('include')
	<link rel="stylesheet" href="../css/main.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../css/nav.css" type="text/css" media="all"/>
	<link rel="stylesheet" href="../css/basket.css" type="text/css" media="all"/>

	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="../js/layout.js"></script>
	<script src="../js/reach_basket.js"></script>
	<script src="../js/jquery.zoom.min.js"></script>
	<script>
		$(document).ready(function(){
			$('div.item-img-zoom').zoom();
		});
	</script>
@stop

@section('basket')

	<table id="basket-contents">
	</table>

@stop

@section('content')

	<h2>Personalise your gift to make it unique!</h2>

	<p>Our personalised gifts are made from using authentic vintage silver plated pieces.</p>

	<p>Our collection ranges from teaspoons to cake knives and key rings. Whatever the occasion you can now create a personalised gift which is as unique as the person for whom you are buying it. We have some personalised cutlery for you to have a look at to get some inspiration and get creative!</p>

	<p>Please always carefully check your personalisation - we will make it exactly as you have requested. You cannot change a personalised order once we tooked it in our atelier.</p>

	<p>Price: 5€ per word added to the price of your prefered piece.</p>

	<p>Please choose short messages, like names, or dates or other short quotes or love declarations so it will fit on to your item!</p>

	<p>That's how to do it:</p>
	<ul>
		<li>Enter your words - make sure you're happy with them;</li>
		<li>Select the item of your choice;</li>
		<li>Add it to the basket;</li>
		<li>We will validate your personalisation and do our best to meet your desires.</li>
	</ul>


	{!! Form::open() !!}

		{!! Form::text('perso-stamped', 'Stamped Text') !!}

		{!! Form::select('perso-item', array(
					'Spoons' => array(
							'teaspoon' => 'Teaspoon',
							'big-spoon' => 'Big Spoon',
							'dessert-spoon' => 'Dessert Spoon',
							'baby-spoon' => 'Baby Spoon'
						),

					'Forks' => array(
							'big-fork' => 'Big Fork',
							'dessert-fork' => 'Dessert Fork'
						),

					'Knives' => array(
							'knife' => 'Knife'
						),

					'Servers' => array(
							'serving-spoon' => 'Serving Spoon',
							'serving-fork' => 'Serving Fork',
							'cake-server' => 'Cake Server',
							'ladle' => 'Ladle'
						)
					));		!!}

		{!! Form::submit('ADD TO BASKET'); !!}

	{!! Form::close() !!}

	<br>
	<br>
	<br>
	<br>
	<br>

@stop
