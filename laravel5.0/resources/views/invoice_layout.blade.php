<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('page_title')</title>

	@yield('include')

</head>

<body>


	<div id="invoice-header">
		<img src="http://www.fourchetteandcie.com/pictures/title_mint.png">
	</div>

	<div id="invoice-customer-details">
		<p><b>billed to:</b><br>
			<span style="text-transform: uppercase">@yield('customer-name')</span><br>
			@yield('customer-address')<br>
			@yield('customer-phone')<br>
			@yield('customer-email')
		</p>
	</div>

	<p id="invoice-nb">
		<span class="mint">Invoice</span><br>
		<span class="mint big">nº @yield('order-id')</span><br>
		placed on @yield('order-validated-datetime')
	</p>

	@yield('order')

	<br>
	<p style="text-align: center;">TVA non applicable, art. 293 B du CGI</p>

	<p class="order-message">
		<b>a little message for you:</b><br>
		@yield('message')<br><br>
		MERCI BEAUCOUP POUR VOTRE COMMANDE!
	</p>
	<br>
	<p class="fandc-details">fourchette &amp; cie - 383, rue du général de gaulle - 62110 hénin-beaumont - france<br>
		nº siret 523087575000016 - fourchetteandcie.com - fourchetteandcie@gmail.com</p>


</body>
</html>
