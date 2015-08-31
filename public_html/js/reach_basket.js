function reach_basket(command)
{
	var xhr = new XMLHttpRequest();

	xhr.open('GET', 'basket/' + command, true);
	xhr.addEventListener('readystatechange', function() {

		if (xhr.readyState === 4 && xhr.status === 200)
		{
			var end_pos = xhr.responseText.indexOf('<');
			var basket_count = xhr.responseText.substring(0,end_pos);

			$("#basket-count span").html(basket_count);
			blink_basket_count();

			var html_basket = xhr.responseText.substring(end_pos, xhr.responseText.length);
			$("table#basket-contents").html(html_basket);
		}
		else if (xhr.readyState == 4 && xhr.status != 200)
		{
			//alert("ERROR!" + '\n\nCode :' + xhr.status + '\nText : ' + xhr.statusText + '\nMessage : ' + xhr.responseText);
		}
	}, false);

	xhr.send(null);

	return false;
}

$(function() {
	// reach_basket('HTML');

	$("#button-add-to-basket").on("click", function() {
		// $(this).attr('item-ref');
		console.log( $(this).attr('item-ref') );
		reach_basket("ADD-"+$(this).attr('item-ref'));
	});

	$("#button-empty-basket").on("click", function() {
		reach_basket("EMPTY");
	});

	$("#basket").on("click", ".item-qty-plus-button", function() {
		var new_qty = parseInt( $(this).siblings('.item-qty-value').html() ) + 1;
		var item_ref = $(this).parents('tr').attr('item-ref');
		console.log('UPDATE-' + item_ref + '-' + new_qty);
		reach_basket('UPDATE-' + item_ref + '-' + new_qty);
	});

	$("#basket").on("click", ".item-qty-minus-button", function() {
		var new_qty = parseInt( $(this).siblings('.item-qty-value').html() ) - 1;
		var item_ref = $(this).parents('tr').attr('item-ref');

		reach_basket('UPDATE-' + item_ref + '-' + new_qty);
	});

	$(document).on("click", ".item-qty-plus-button", function() {
		var new_qty = parseInt( $(this).siblings('.item-qty-value').html() ) + 1;
		var item_ref = $(this).parents('tr').attr('item-ref');
		console.log('UPDATE-' + item_ref + '-' + new_qty);
		reach_basket('UPDATE-' + item_ref + '-' + new_qty);
	});

	$(document).on("click", ".item-qty-minus-button", function() {
		var new_qty = parseInt( $(this).siblings('.item-qty-value').html() ) - 1;
		var item_ref = $(this).parents('tr').attr('item-ref');

		reach_basket('UPDATE-' + item_ref + '-' + new_qty);
	});


});
