<!DOCTYPE html>
<html lang="en" style="position: relative;min-height: 100%;">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('page_title')</title>

	@yield('include')

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-62374327-1', 'auto');
		ga('send', 'pageview');
	</script>

</head>

<body>
<div style="min-height: 100%;overflow:auto;	padding-bottom: 150px;">
	<div id="fade"></div>
	<div id="nav">
		<div id="contain-svg-menu">
			<svg id="svg-menu" xmlns="http://www.w3.org/2000/svg" height="30" width="30" version="1.1" viewBox="0 0 30 30">
				<g fill="#000">
					<rect id="rect4144" height="2" width="30" y="5" x="0"/>
					<rect id="rect4146" height="2" width="30" y="14" x="0"/>
					<rect id="rect4148" height="2" width="30" y="23" x="0"/>
				</g>
			</svg>
		</div>

		<h1 id="page-title"><span>F&C</span> @yield('page_title')</h1>



		<!-- <div id="contain-svg-basket">
			<div id="basket-count"><span>?</span></div>
			<svg id="svg-basket" xmlns="http://www.w3.org/2000/svg" version="1.1" height="30" width="23" viewBox="0 0 22 30.581257">
				<g id="layer1" transform="translate(0 -1021.8)">

					<rect id="rect4164" height="21.997" width="19.997" stroke="#000" y="1029.4" x="1.0014" stroke-width="2.0027" fill="none"/>
					<path id="path4166" d="m1.1921e-7 1044.8h22" stroke="#000" stroke-width="2.0022" fill="none"/>
					<path id="path4213" style="color-rendering:auto;text-decoration-color:#000000;color:#000000;isolation:auto;mix-blend-mode:normal;shape-rendering:auto;solid-color:#000000;block-progression:tb;text-decoration-line:none;text-decoration-style:solid;image-rendering:auto;white-space:normal;text-indent:0;text-transform:none" d="m11.002 1021.8c-0.94013 0-1.8812 0.2447-2.7227 0.7305-1.6783 0.969-2.7151 2.7621-2.7207 4.6992h-0.00195v0.016 4.9843h1.9102v-5c0.0056-1.2582 0.67535-2.4174 1.7656-3.0468 1.0949-0.6321 2.4403-0.6321 3.5352 0 1.0903 0.6294 1.762 1.7886 1.7676 3.0468 0.000024 0.01 0 0.01 0 0.016v4.9843h1.9082v-4.9843-0.016s-0.002 0.0001-0.002 0c-0.0056-1.9371-1.0405-3.7302-2.7188-4.6992-0.84143-0.4858-1.7806-0.7305-2.7207-0.7305z" fill="#000"/>
				</g>
			</svg>
		</div> -->
	</div>

	<div id="nav-links">
		<ul>
			<li><a href="http://localhost/fourchetteandcie/public/">Home</a></li>
			<li><a href="http://localhost/fourchetteandcie/public/handstamped-silverware">Handstamped Silverware</a></li>
			<li><a href="http://localhost/fourchetteandcie/public/handstamped-silverware/looking-after-your-handstamped-cutlery">Look after your silverware</a></li>
			<li><a href="http://localhost/fourchetteandcie/public/cake-stands">Cake Stands</a></li>
			<li><a href="http://localhost/fourchetteandcie/public/furniture">Furniture</a></li>
			<li><a href="http://localhost/fourchetteandcie/public/bric-a-brac">Bric-a-Brac</a></li>
		</ul>
	</div>

	<div id="basket">
		<h2>basket</h2>
		<hr>

		@yield('basket')

		<br><br>
		<button id="button-empty-basket">EMPTY</button>
		<a class="a-button-style" href="http://localhost/fourchetteandcie/public/checkout">CHECKOUT</a>
	</div>

	<div id="item-viewer">
		<div id="close-viewer"><img src="http://localhost/fourchetteandcie/public/pictures/cross.png"></div>
		<div id="item-viewer-content">

			<div id="item-viewer-imgs">
				<img class="item-img big" src="">
			</div>

			<div id="item-viewer-details">
				<h2 id="item-viewer-stamped"></h2>
				<h5 id="item-viewer-descr"></h5>
				<h5 id="item-viewer-price"></h5>

				<br><br><br><br><br>
				<!-- <button id="button-add-to-basket">ADD TO BASKET</button> -->
			</div>
		</div>
	</div>

	<div id="content">
		@yield('categ-bar')

		@yield('content')
	</div>

</div>

<footer>
	<div id="footer-fandcie-details">
		<p>Fourchette & Cie<br>
			383, rue du Général de Gaulle<br>
			62110 - Hénin-Beaumont<br>
			FRANCE</p>
	</div>

	<div id="footer-various-details">
		<a href=""><img src="http://www.fourchetteandcie.com/pictures/facebook.png" width="29px" alt="PayPal Logo" /></a>
		<a href="https://instagram.com/fourchetteandcie/"><img src="http://www.fourchetteandcie.com/pictures/instagram.png" width="29px" alt="PayPal Logo" /></a>
		<a href=""><img src="http://fourchetteandcie.com/pictures/paypal.jpg" height="29px" alt="PayPal Logo" /></a>
	</div>

	<div id="footer-links">
		<ul>
			<li><a href="http://www.fourchetteandcie.com/handstamped-silverware">Handstamped Silverware</a></li>
			<li><a href="http://www.fourchetteandcie.com/cake-stands">Cake Stands</a></li>
		</ul>
	</div><br>

	<div id="signature">
		<p>webdesigned by <a href="mailto:z.dettwiler@gmail.com">zach dettwiler</a></p>
	</div>
</footer>


</body>
</html>
