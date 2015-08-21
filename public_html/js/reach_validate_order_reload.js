function reach_validate_order_reload(id, command)
{
	var xhr = new XMLHttpRequest();

	xhr.open('GET', '../../../admin/orders/'+id+'/validate/'+encodeURIComponent(command), true);
	xhr.addEventListener('readystatechange', function() {

		if (xhr.readyState === 4 && xhr.status === 200)
		{
			$("#wholesale-status").attr("src", "http://www.fourchetteandcie.com/pictures/"+ xhr.responseText.substring(0,1) +".png")

			$("table#validation-table").html(xhr.responseText);

		}
		else if (xhr.readyState == 4 && xhr.status != 200)
		{
			alert("ERROR!" + '\n\nCode :' + xhr.status + '\nText : ' + xhr.statusText + '\nMessage : ' + xhr.responseText);
		}
	}, false);

	xhr.send(null);

	return false;
}

$(function() {
	reach_validate_order_reload(id, 'SHOW');

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
		var shipping_details = encodeURIComponent( $(this).val() );
		// console.log('UPDATE_SHIPPING_DETAILS-null-' + shipping_details);
		reach_validate_order_reload(id, 'UPDATE_SHIPPING_DETAILS-null-' + shipping_details);
	});

	// WHOLESALE TOGGLE
	$("#toggle-wholesale").on("click", function() {
		// console.log('TOGGLE_WHOLESALE');
		reach_validate_order_reload(id, 'TOGGLE_WHOLESALE');
	});

	// MESSAGE
	$("#validation-table").on("focusout", "textarea", function() {
		var message = encodeURIComponent( $(this).val() );
		// console.log('TOGGLE_WHOLESALE');
		reach_validate_order_reload(id, 'UPDATE_MESSAGE-null-' + message);
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