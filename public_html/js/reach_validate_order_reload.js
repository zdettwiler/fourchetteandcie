function reach_validate_order_reload(id, command)
{
	$.ajax({
		type: 'GET',
		url: '../../../admin/orders/'+id+'/validate/'+encodeURIComponent(command),
		beforeSend: function() {
			$("#loading").html('WAIT');
			$("#validation-table").css('cursor', 'not-allowed');
		},
		success: function(order) {
			var order = $.parseJSON(order);
			order.val_order = $.parseJSON( order.val_order );

			$("#wholesale-status").attr("src", "http://www.fourchetteandcie.com/pictures/"+ order.is_wholesale +".png");
			toggle_currency(order.order_currency);

			// fill html table from template
			var template_order_validation_table_item = $("#template-order-validation-table-item").html();
			var template_order_validation_table_totals = $("#template-order-validation-table-totals").html();

			// table header
			$("#validation-table").html(""
				+ "<tr class='table-header'>"
				+ "<td></td>"
				+ "<td style='width:50%;'>Item Description</td>"
				+ "<td>Qty</td>"
				+ "<td>Unit. Price</td>"
				+ "<td>Total</td>"
				+ "</tr>"
			);

			// order items
			$.each( order.val_order, function( i, item ) {
				item.price       = Number(item.price).toFixed(2);
				item.total       = Number(item.qty * item.price).toFixed(2);
				item.ref_section = item.ref.substr(0,1);

				if(item.ref_section == '_') {
					item.img_path = "0.png";
				} else {
					item.img_path = item.ref_section + "/100px/"+ item.ref +"_thumb.jpg";
				}

				if(item.qty == 1) {
					item.minus_button = "<img src='http://www.fourchetteandcie.com/pictures/bin.png' height='20'>";
				} else {
					item.minus_button = "-";
				}

				if(order.order_currency == 'eur') {
					item.currency = '€';
				} else if(order.order_currency == 'aud') {
					item.currency = 'AU$';
				}

				$("#validation-table").append( Mustache.render(template_order_validation_table_item, item) );
			});

			// order totals
			order.val_order_subtotal = Number(order.val_order_subtotal).toFixed(2);
			order.val_order_shipping = Number(order.val_order_shipping).toFixed(2);
			order.val_order_total    = Number(order.val_order_total).toFixed(2);

			if(order.is_wholesale == 1) {
				order.wholesale_subtotal = Number(0.7 * order.val_order_subtotal).toFixed(2);
			}

			if(order.order_currency == 'eur') {
				order.order_currency = '€';
			} else if(order.order_currency == 'aud') {
				order.order_currency = 'AU$';
			}

			if(order.val_order_nb_items > 1) {
				order.nb_items_plural = 's';
			} else {
				order.nb_items_plural = '';
			}

			$("#validation-table").append( Mustache.render(template_order_validation_table_totals, order) );

		},
		complete: function () {
			$("#loading").html('EDIT');
			$("#validation-table").css('cursor', 'auto');
		}
	});


}

function toggle_currency(currency, reload)
{
	if(currency == 'eur')
	{
		$(".switch").animate({
			left: '0px'
		}, 'fast', function(){
			$(".option-aud").removeClass('switch-selection');
			$(".option-eur").addClass('switch-selection');
		});
	}
	else if(currency == 'aud')
	{
		$(".switch").animate({
			left: '35px'
		}, 'fast', function(){
			$(".option-eur").removeClass('switch-selection');
			$(".option-aud").addClass('switch-selection');
		});
	}
}

$(function() {
	reach_validate_order_reload(id, 'SHOW');

	// CURRENCY SWITCH
	$(document).on("click", "#currency-switch", function(){
		if( $(".option-eur").hasClass('switch-selection') )
		{
			toggle_currency('aud');
			reach_validate_order_reload(id, 'TOGGLE_CURRENCY');
		}
		else if($(".option-aud").hasClass('switch-selection'))
		{
			toggle_currency('eur');
			reach_validate_order_reload(id, 'TOGGLE_CURRENCY');
		}
	});

	// MORE BUTTON
	$("#validation-table").on("click", ".item-qty-plus-button", function() {
		var new_qty = parseInt( $(this).siblings('.item-qty-value').html() ) + 1;
		var item_ref = $(this).parents('tr').attr('item-ref');
		//console.log('UPDATE_QTY-' + item_ref + '-' + new_qty);
		reach_validate_order_reload(id, 'UPDATE_QTY-' + item_ref + '-' + new_qty);
	});

	// LESS BUTTON
	$("#validation-table").on("click", ".item-qty-minus-button", function() {
		var new_qty = parseInt( $(this).siblings('.item-qty-value').html() ) - 1;
		var item_ref = $(this).parents('tr').attr('item-ref');
		reach_validate_order_reload(id, 'UPDATE_QTY-' + item_ref + '-' + new_qty);
	});

	// COMMENT
	$("#validation-table").on("focusout", "input[type=text].edit-comment", function() {
		var new_comment = encodeURIComponent( $(this).val() );
		if(new_comment == ''){ new_comment = '--null'; }
		var item_ref = $(this).parents('tr').attr('item-ref');
		// console.log('UPDATE_COMMENT-' + item_ref + '-' + new_comment);
		reach_validate_order_reload(id, 'UPDATE_COMMENT-' + item_ref + '-' + new_comment);
	});

	// UNIT PRICE
	$("#validation-table").on("focusout", "input[type=text].edit-unit-price", function() {
		var unit_price = encodeURIComponent( $(this).val() );
		var item_ref = $(this).parents('tr').attr('item-ref');
		// console.log('UPDATE_UNIT_PRICE-' + item_ref + '-' + unit_price);
		reach_validate_order_reload(id, 'UPDATE_UNIT_PRICE-' + item_ref + '-' + unit_price);

	});

	// SHIPPING
	$("#validation-table").on("focusout", "input[type=text].edit-shipping", function() {
		var shipping = encodeURIComponent( $(this).val() );
		// console.log('UPDATE_SHIPPING-null-' + shipping);
		reach_validate_order_reload(id, 'UPDATE_SHIPPING-null-' + shipping);

	});

	// SHIPPING DETAILS
	$("#validation-table").on("focusout", "input[type=text].edit-shipping-details", function() {
		var shipping_details = $(this).val();
		if(shipping_details == '')
		{
			shipping_details = ' ';
		}
		reach_validate_order_reload(id, 'UPDATE_SHIPPING_DETAILS-null-' + encodeURIComponent(shipping_details) );
	});

	// WHOLESALE TOGGLE
	$("#toggle-wholesale").on("click", function() {
		// console.log('TOGGLE_WHOLESALE');
		reach_validate_order_reload(id, 'TOGGLE_WHOLESALE');
	});

	// MESSAGE
	$("#validation-table").on("focusout", "textarea", function() {
		var message = $(this).val();
		if(message == '')
		{
			message = ' ';
		}
		reach_validate_order_reload(id, 'UPDATE_MESSAGE-null-' + encodeURIComponent(message) );
	});


	$('#validation-table').on("keypress", "input", function(event) {
        if( $(this).attr('id') != "search-input" )
		{
			if(event.keyCode == 13)
			{
	            $(this).blur();
	            return false; // prevent the button click from happening
	        }
        }

});

});
