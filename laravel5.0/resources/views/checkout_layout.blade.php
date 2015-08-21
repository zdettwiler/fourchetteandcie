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
<div style="height: 100%; min-height:100%; position:relative;">

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
		{{-- @yield('basket') --}}
	</div>

	{{-- <div id="footer">
		<div id="footer-links">
			<ul>
				<li><a href="http://www.fourchetteandcie.com/handstamped-silverware">Cake Servers</a></li>
				<li><a href="http://www.fourchetteandcie.com/cake-servers">Cake Servers</a></li>
				<li><a href="http://www.fourchetteandcie.com/cake-servers">Cake Servers</a></li>
				<li><a href="http://www.fourchetteandcie.com/cake-servers">Cake Servers</a></li>
				<li><a href="http://www.fourchetteandcie.com/cake-servers">Cake Servers</a></li>
			</ul>
		</div>
	</div> --}}

</div>
</body>
</html>
