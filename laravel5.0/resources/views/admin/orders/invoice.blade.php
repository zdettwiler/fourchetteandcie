{{-- Admin - Make Invoice --}}
@extends('invoice_layout')

@section('page_title', 'Invoice')

@section('include')
	<link rel="stylesheet" href="http://www.fourchetteandcie.com/css/invoice.css" type="text/css" media="all">
@stop

@section('customer-name', $order->customer_name)
@section('customer-address', str_replace("\\n", "<br>", $order->customer_address))
@section('customer-phone', $order->customer_phone)
@section('customer-email', $order->customer_email)
@section('order-id', sprintf('%03u', $order->id))
@section('order-validated-datetime', date('d/m/Y H:i:s', $order->validated_datetime))

@section('order')

		<table id="invoice-order">
			<tr class="table-header">

				<td class="center-col" style='width:60%;'>ITEM DESCRIPTION</td>

				<td class="center-col">QTY</td>
				<td class="center-col">PRICE/PC</td>
				<td class="center-col">TOTAL</td>
			</tr>

		@foreach($order_details as $item)

			<tr>
				<td style='width: 60%;'>{{ $item['ref'] }} {{ $item['name'] }}{{ $item['stamped'] }}<span> - {{ $item['descr'] }}</span><br>
					<span style="font-size: 10px;"><i>{{ $item['comment'] }}</span></td>

				<td class="center-col">{{ $item['qty'] }}</td>
				<td class="center-col">{{ $currency }}{{ number_format($item['price'], 2) }}</td>
				<td class="center-col">{{ $currency }}{{ number_format($item['qty'] * $item['price'], 2) }}</td>
			</tr>

		@endforeach

			<tr id='subtotal-row'>
				<td class="right-col" colspan='3'>SUBTOTAL ({{ $order->val_order_nb_items }} item(s))</td>
				<td class="center-col">{{ $currency }}{{ number_format ( $order->val_order_subtotal, 2 ) }}</td>
			</tr>

			@if($order->is_wholesale == 1)
				<tr id='wholesale-row'>
					<td class="right-col" colspan='3'>WHOLESALE (-30%)</td>
					<td class="center-col">{{ $currency }} {{ number_format( 0.7 * $order->val_order_subtotal, 2 ) }}</td>
				</tr>
			@endif

			<tr id='shipping-row'>
				<td class="right-col" colspan='3'>SHIPPING ({{ $order->val_order_shipping_details }})</td>
				<td class="center-col">{{ $currency }}{{ number_format( $order->val_order_shipping, 2 ) }}</td>
			</tr>

			<tr id='total-row'>
				<td></td>
				<td  class="right-col bordered" colspan='2'>TOTAL</td>
				<td class="center-col bordered">{{ $currency }}{{ number_format( $order->val_order_total, 2 ) }}</td>
			</tr>
		</table>
@stop

@section('message')
	{{ $order->val_order_message }}<br><br>

	@if($order->order_currency == 'aud')
	Thank you for a quick bank-transfer as indicated below, so we can send over your order:<br>
	Commonwealth Bank<br>
	367 Collins Street, MELBOURNE / VIC<br>
	BSB No 063000<br>
	Account No 12525984 / Iris Lara Fabbricotti & Eric Dettwiler<br>
	SWIFT CTBAAU2S
	@endif
@endsection
