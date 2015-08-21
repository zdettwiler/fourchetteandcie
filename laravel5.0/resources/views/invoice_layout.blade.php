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
		<img src="http://localhost/fourchetteandcie/public/pictures/title_mint.png">
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
		placed on @yield('order-placed-datetime')
	</p>

	@yield('order')

	<br>
	<p style="text-align: center;">TVA non applicable, art. 293 B du CGI</p>

	<p class="order-message">
		<b>a little message for you:</b><br>
		{{ $order->val_order_message }}<br><br>
		MERCI BEAUCOUP POUR VOTRE COMMANDE!
	</p>


</body>
</html>
