function items_per_row()
{
	var available_width = 0.8 * $(window).width();
	var item_min_width = 300;
	var item_width = 0;

	nb_items_per_row = Math.floor(available_width / item_min_width);
	item_width = (available_width / nb_items_per_row) - 60;

	$(".item").css({width: item_width});
	$(".item .item-img").css({width: item_width, height: item_width});
	$(".item .item-details").css({width: item_width});

	return false;
}

function toggle_basket(command)
{

	if($("#basket").hasClass('opened') || command == 'close')
	{
		$("#fade").fadeOut();
		$("#basket").removeClass('opened');
		$("#basket").animate({top: - $(window).height() });
		$("#contain-svg-basket").css('background-color', 'rgb(255, 255, 255)');

		return;
	}

	if(!$("#basket").hasClass('opened'))
	{
		$("#fade").fadeIn('fast');
		$("#basket").addClass('opened');
		$("#basket").animate({top: 60});
		$("#contain-svg-basket").css('background-color', 'rgb(241, 241, 241)');

		return;
	}

	return false;
}

function toggle_nav_links(command)
{
	if($("#nav-links").hasClass('opened') || command == 'close')
	{
		$("#nav-links").removeClass('opened');
		$("#fade").animate({left: '0'});
		$("#nav-links").animate({left: '-30%'});
		$("body").animate({left: '0'});
		$("body").css('overflow', 'visible');
		$("#fade").fadeOut('fast');

		return;
	}

	if(!$("#nav-links").hasClass('opened'))
	{

		$("#fade").fadeIn('fast', function() {
			$("#fade").animate({left: '30%'});
			$("#nav-links").addClass('opened');
			$("#nav-links").animate({left: 0});
			$("body").css('overflow', 'hidden');
			$("body").animate({left: '30%'});
		});

		return;
	}
}

function toggle_viewer(item)
{

	if(!$("#item-viewer").hasClass('opened'))
	{
		$("#item-viewer").addClass('opened');
		$("#item-viewer, #button-add-to-basket").attr('item-ref', $(item).attr('item-ref'));
		$("#item-viewer").animate({left:0});

		console.log($(item).attr('img-count'));
		$('#item-viewer-imgs img').attr('src', $('img.item-img', item).attr('src'));
		// $('#item-viewer-ref').html('ref: #'+$('.item-details p.item-ref', item).html());
		$('#item-viewer-stamped').html($('.item-details .item-stamped-descr span.item-stamped', item).html());
		$('#item-viewer-descr').html($('.item-details .item-stamped-descr span.item-descr', item).html());
		$('#item-viewer-price').html($('.item-details .item-price span', item).html());
		// $('#button-add-to-basket').addClass($(item).attr('id'));
		$('#item-viewer-more-button').attr('href', 'handstamped-silverware/'+$(item).attr('item-ref'));

		return;
	}

	if($("#item-viewer").hasClass('opened'))
	{
		$("#item-viewer").removeClass('opened');
		$("#item-viewer").animate({left: - 1.2* $(window).width() });

		return;
	}

	return false;
}

function blink_basket_count()
{
	$("#basket-count").animate({
		backgroundColor: "#7CFFB1",
	}, 100)
	.animate({
		backgroundColor: "#CCCCCC",
	}, 1000);
}

function placeholder()
{
	myArray = $('input');
	alert(myArray.length);
}

$(function()
{
	items_per_row();
	$(window).resize(items_per_row);
	// placeholder();

	$("#contain-svg-basket").on("click", function() {
		toggle_basket();
	});

	$("#contain-svg-menu").on("click", function() {
		toggle_nav_links();
	});

	$("#fade").on("click", function() {
		toggle_basket('close');
		toggle_nav_links('close');
	});

	$("li.item, #close-viewer").on("click", function() {
		toggle_viewer(this);
	});

	$("#back-arrow").hover(function() {
		$("#back-arrow").css({
			"width": 60,
			"padding-left": 20
		});
	}, function() {
		$("#back-arrow").css({
			"width": 50,
			"padding-left": 10
		});
	});

	$(document).keyup(function(e) {
	    if (e.keyCode == 27 && $("#item-viewer").hasClass('opened')) { // escape key maps to keycode `27`
	     	$("#item-viewer").removeClass('opened');
			$("#item-viewer").animate({left: - 1.2* $(window).width() });
	    }
	});


});
