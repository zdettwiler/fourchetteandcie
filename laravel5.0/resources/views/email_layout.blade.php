<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>@yield('page_title')</title>	
</head>

<body>
	<div style="">
		<p style="color: #FFFFFF; margin: 0; padding: 0; font-size: 1px;">@yield('preloader')</p>
	</div>

	<div style="width: 100%">

		<div style="max-width: 600px; width: 70%; margin: auto; padding: 10px; ">
			<img src="http://www.fourchetteandcie.com/pictures/logo.png" style="width: 60%; margin: 50px auto; display: block;">
		</div>

		<div style="width: 70%; margin: 0px auto; padding: 10px;">
			@yield('content')

			<hr style="width: 100%; height: 0px; border: 1px solid #000000; ">
		</div>
	</div>
</body>
</html>
