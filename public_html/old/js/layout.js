function resize_window()
{
	items_per_row();

}

function items_per_row()
{
	var available_width = $(window).width()
	var item_min_width = 400;
	var item_width = 0;

	nb_items_per_row = Math.floor(available_width / item_min_width);
	item_width = available_width / nb_items_per_row;

	$(".item img").css({width: item_width});
	$(".item .item-details").css({width: item_width});
	// $(".item .item-details").css({height: item_width - 40});
	// $(".item span.select").css("width", item_width - 20);
	// $(".item span.select").css("height", item_width - 20);
	// $(".item p.description").css("width", item_width - 70);

	return false;
}

function reach_basket(command)
{
	var xhr = new XMLHttpRequest();

	xhr.open('GET', '../functions/api.php?' + command, true);
	xhr.addEventListener('readystatechange', function() {

		if (xhr.readyState === 4 && xhr.status === 200)
		{
			$("table#basket-contents").html(xhr.responseText);
			basket_notification(command);	
		}
		else if (xhr.readyState == 4 && xhr.status != 200)
		{
			alert("ERROR!" + '\n\nCode :' + xhr.status + '\nText : ' + xhr.statusText + '\nMessage : ' + xhr.responseText);
		}
	}, false);

	xhr.send(null);
	// $('#scroll').jScrollPane().data('jsp').reinitialise();

	return false;
}

function basket_notification(command)
{
	if(command.search("SHOW") == -1)
	{
		$('#basket-link').animate({'width': '300px'}, function() {
			$('#basket-notif').fadeIn().delay(1400).fadeOut();
		}).delay( 2000 ).animate({'width': '60px'});
			
	}
}


$(document).ready(function()
{

	resize_window();
	$(window).resize(resize_window);
	//reach_basket('BASKET_SHOW');

// DISPLAY BAKSET
	$('#basket-link').click(function(){
		if(parseInt($('#shopwindow').css('left')) >= 0)
		{
			$("#item-viewer").animate({'height': 0, 'padding': 0}, function() {
				$("#item-viewer").remove();
			});
			
			$('#shopwindow').animate({'left': '-50%'}, 500);
		}

		if(parseInt($('#shopwindow').css('left')) < 0)
		{
			$('#shopwindow').animate({'left': 0}, 500);
		}
	});

// DISPLY NAV MENU
	$('#menu-link').click(function(){
		if(parseInt($('#shopwindow').css('left')) < 5)
		{
			$('#shopwindow').animate({'left': 200}, 500);
		}

		if(parseInt($('#shopwindow').css('left')) > 195)
		{
			$('#shopwindow').animate({'left': 0}, 500);
		}
		
	});

// ITEMS, ADD TO BASKET
	$('.item').click(function(){

		$("#item-viewer").remove();

		var insertHere = $(this);

		while( insertHere.next('.item').offset().top == insertHere.offset().top )
		{
			insertHere = insertHere.next('.item');
		}

		insertHere.after("<div id='item-viewer'><span id='close'>X</span><img id='item-viewer-pict' src= '' alt=''><div id='item-viewer-details'><p id='item-viewer-ref'></p><p id='item-viewer-stamped'></p><p id='item-viewer-descr'></p><p id='item-viewer-price'></p><br><button id='button-add-to-basket'>add to basket</button><p>The width of a plank is 10 cm.</p></div></div>");

		$('#item-viewer').addClass('class', $(this).attr('id'));
		$('#item-viewer-pict').attr('src', $('img.item-pict', this).attr('src'));
		$('#item-viewer-ref').html('ref: #'+$('.item-details p.item-ref', this).html());
		$('#item-viewer-stamped').html($('.item-details p.item-stamped', this).html());
		$('#item-viewer-descr').html($('.item-details p.item-descr', this).html());
		$('#item-viewer-price').html($('.item-details p.item-price', this).html());
		$('#button-add-to-basket').addClass($(this).attr('id'));

		$('#item-viewer').animate({'height': '60%'});

		$('html, body').animate({
			scrollTop: $("#item-viewer").offset().top -60
		}, 500);
	});

	$(document).on('click', '#close', function(){
		$("#item-viewer").animate({'height': 0, 'padding': 0}, function() {
			$("#item-viewer").remove();
		});
	});

	$(document).on('click', '#button-add-to-basket', function(){
		var ref = $(this).attr("class").split("-").pop();
		var categ = ref[0];
		var id = ref.slice(1);

		console.log( 'BASKET_ADD=' + ref );
		reach_basket('BASKET_ADD=' + ref);

		// console.log( $(this).attr("class").match(/\d+/)[0] );
	});

	$('#button-empty').click(function(){
		if(confirm("Do you really want to empty the basket?"))
		{
			reach_basket('BASKET_EMPTY');
		}
		else
		{
			return false;
		}
	});



// DROP DOWN
	$('.dropdown .selected').click(function(){
		$('.options').slideToggle('fast');
	});
	$('.dropdown .options span').click(function(){
		var select = $(this).html();
				
		$('span.selected-item').html(select);
		$('.options').slideToggle('fast');

	});


});