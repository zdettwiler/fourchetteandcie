<!DOCTYPE html>
<html lang="en">
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
	</div>

	<div id="nav-links">
		<ul>
			<li>Home</li>
			<li>Handstamped Silverware</li>
			<li>Cake Stands</li>
			<li>etc</li>
			<li>Home</li>
		</ul>
	</div>


	<div id="checkout-progress-bar">
		@yield('checkout-progress-bar')
	</div>

	<div id="content">
		@yield('content')
	</div>

	<br><br><br><br><br><br>

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
