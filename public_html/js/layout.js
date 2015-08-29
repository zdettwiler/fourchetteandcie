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


	var img_viewer_available_height = $("#item-viewer-imgs").height();
	$("#main-imgs img").height(0.8 * img_viewer_available_height);
	$("#thumb-imgs img").height(0.2 * img_viewer_available_height);


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
		item_ref = $(item).attr('item-ref');
		item_section = item_ref.substring(0,1);
		img_count = $(item).attr('img-count');

		$("#item-viewer").addClass('opened');
		$("#item-viewer, #button-add-to-basket").attr('item-ref', item_ref);
		$("#item-viewer").animate({left:0});

		$('#main-imgs').html('');
		$('#thumb-imgs').html('');

		for (var i = 1; i <= $(item).attr('img-count'); i++)
		{
			if(i==1)
			{
				$('#main-imgs').append("<img class='item-img viewing' img-nb='"+i+"' src='http://www.fourchetteandcie.com/pictures/"+ item_section +"/500px/"+ item_ref +".jpg'>");
				$('#thumb-imgs').append("<img class='item-img' img-nb='"+i+"' src='http://www.fourchetteandcie.com/pictures/"+ item_section +"/100px/"+ item_ref +"_thumb.jpg'>");
			}
			else
			{
				$('#main-imgs').append("<img class='item-img' img-nb='"+i+"' src='http://www.fourchetteandcie.com/pictures/"+ item_section +"/500px/"+ item_ref +"_"+ i +".jpg'>");
				$('#thumb-imgs').append("<img class='item-img' img-nb='"+i+"' src='http://www.fourchetteandcie.com/pictures/"+ item_section +"/100px/"+ item_ref +"_thumb_"+ i +".jpg'>");
			}

		}

		$('#item-viewer-imgs img.main-img').attr('src', $('img.item-img', item).attr('src'));
		$('#item-viewer-stamped').html($('.item-details .item-stamped-descr span.item-stamped', item).html());
		$('#item-viewer-descr').html($('.item-details .item-stamped-descr span.item-descr', item).html());
		$('#item-viewer-price').html($('.item-details .item-price span', item).html());
		$('#item-viewer-more-button').attr('href', 'handstamped-silverware/'+$(item).attr('item-ref'));

		items_per_row();
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

function confirm_action(message, confirmed_action)
{
	$("body #confirm-action").remove();
	$("#fade").hide();

	if(message)
	{
		$("#fade").show();
		$("body").prepend("<div id='confirm-action'><div id='title'><h3>Please Confirm</h3></div><div id='message'><p>"+ message +"</p><p style='text-align: right; margin: 0; padding-right: 7px;'><button onclick='confirm_action()'>CANCEL</button> <button onclick='"+ confirmed_action +"()'>CONFIRM</button></p></div></div>");
	}
}
function toggle_payed()
{
	var xhr = new XMLHttpRequest();

	xhr.open('GET', '../../admin/orders/'+id+'/validate/'+encodeURIComponent("TOGGLE_PAYED"), true);
	xhr.addEventListener('readystatechange', function() {

		if (xhr.readyState === 4 && xhr.status === 200)
		{
			$("#payed-status").attr("src", "http://www.fourchetteandcie.com/pictures/1.png");
		}
		else if (xhr.readyState == 4 && xhr.status != 200)
		{
			alert("ERROR!" + '\n\nCode :' + xhr.status + '\nText : ' + xhr.statusText + '\nMessage : ' + xhr.responseText);
		}
	}, false);

	xhr.send(null);

	$("body #confirm-action").remove();
	$("#fade").hide();

	return false;
}
function submit_validated_order()
{
	window.location.replace("validate/submit");
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
		confirm_action();
	});

	$("li.item, #close-viewer").on("click", function() {
		toggle_viewer(this);
	});

	$(document).on("click", "#thumb-imgs img", function(){
		$(".viewing").removeClass('viewing');
		$("#main-imgs img[img-nb='"+ $(this).attr('img-nb')+ "']").addClass('viewing');
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

	// PAYED TOGGLE
	$("#toggle-payed").on("click", function() {
		confirm_action("Are you sure the customer has paid?", "toggle_payed");
	});

	// SUBMIT VALIDATED ORDER
	$("#submit-validation").on("click", function() {
		confirm_action("Are you sure the order is ready for the customer?", "submit_validated_order");
		$("html, body").animate({ scrollTop: 0 }, "slow");
  		return false;
	});




});
