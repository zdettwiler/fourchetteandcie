function search_db(query)
{
	var xhr = new XMLHttpRequest();

	xhr.open('GET', 'http://www.fourchetteandcie.com/search/' + encodeURIComponent(query), true);
	xhr.addEventListener('readystatechange', function() {

		if (xhr.readyState === 4 && (xhr.status === 200 || xhr.status === 0))
		{
			display_response(xhr.responseText);
			// console.log(xhr.responseText);
		}
		else if (xhr.readyState == 4 && xhr.status != 200)
		{
			// alert("ERROR!" + '\n\nCode :' + xhr.status + '\nText : ' + xhr.statusText + '\nMessage : ' + xhr.responseText);
		}
	}, false);

	xhr.send(null);

	return xhr;
}

function display_response(json)
{
	var response = $.parseJSON(json);
	var html_result;

	if(response.results.length === 0)
	{
		html_result = "<tr class='result'>\n <td colspan='3'><p>No result...</p></td>\n </tr>";
	}
	else{
	$.each( response.results, function( key, result ) {

		//<img src='http://localhost/fourchetteandcie/public/pictures/". $section_ref_code[ $result->ref[0] ] ."/100px/". $result->ref ."_thumb.jpg' width='50px' />\n
		html_result += "	<tr class='result' item-ref='"+ result.ref +"'>\n<td class='result-img'>\n </td>\n <td class='result-details'>\n <p><span class='ref-box'>"+ result.ref +"</span> "+ result.stamped +"<br>\n <i>"+ result.descr +"</i> (<span class='categ-box'>"+ result.categ +"</span>)</p>\n </td>\n <td class='result-price'>\n <p>€"+ result.price +"</p>\n </td>\n </tr>\n\n";
	});
	}
	$("#results-box table").html(html_result);
	return false;
}

function select_result(ref)
{
	var keep_result = $("tr[item-ref='"+ref+"'")[0].outerHTML;
	$("#selection table").append(keep_result);
	return false;
}

$(function() {
	var previous_request;

	// delete a search tag
	$(document).on("keyup", function(event) {
		if((event.keyCode == 8 || event.keyCode == 46) && $("#search-input").val() == '')
		{
			$("#search-tags .search-tag:last-child").remove();
		}
	});

	$(document).on("keyup", "#search-input", function(event) {

		// if no + tag i.e. not creating new item, then normal search
		if($("#search-tags span:first").html() != '+')
		{
			$("#search-input").attr('placeholder', 'search an item');
			if($(this).val() == '')
			{
				$("#results-box table").html('');
				return;
			}

			// SEARCH TAGS
			if(event.keyCode == 32)
			{
				var query = $(this).val();
				var tag;

				// #ref search
				if(query.substr(0, 1) == '#')
				{
					tag = query.split(' ')[0];
					$("#search-input").val('');
					$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
				}
				// $section search
				if(query.substr(0, 1) == '$')
				{
					tag = query.split(' ')[0];
					$("#search-input").val('');
					$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
				}
				// @categ search
				if(query.substr(0, 1) == '@')
				{
					tag = query.split(' ')[0];
					$("#search-input").val('');
					$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
				}
				// +add custom item
				if(query.substr(0, 1) == '+')
				{
					tag = query.split(' ')[0];
					$("#search-input").val('');
					$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
					$("#search-input").attr('placeholder', 'enter custom item name');
					$("#results-box table").html('');


					// reach_validate_order_reload(id, 'ADD-'+ref);
				}
			}

			if(event.keyCode == 13 && $("#search-tags span:first").html() == '+')
			{
				event.preventDefault();

			}

			setTimeout(function(){}, 500);

			if($(this).val() != '')
			{
				previous_request = search_db($(this).val());
			}

		}

		// if + tag new item creation process
		else if ($("#search-tags span:first").html() == '+')
		{
			// add name
			if($("#search-tags .search-tag:last-child").html() == '+')
			{
				$("#results-box table").html("<tr class='result' item-ref='-custom'>\n<td class='result-img'>\n </td>\n <td class='result-details'>\n <p><span class='ref-box'>-custom</span> "+ $(this).val() +"<br>\n <i>[descr]</i></p>\n </td>\n <td class='result-price'>\n <p>€[price]</p>\n </td>\n </tr>");

				if(event.keyCode == 13)
				{
					event.stopPropagation();
					name = $("#search-input").val();
					$("#search-input").val('');
					$("#search-tags").append("<span class='search-tag name'>+name<span class='hidden-data'>"+name+"</span></span>");
					$("#search-input").attr('placeholder', 'enter custom item description');
				}

				return false;
			}

			// add descr
			if($("#search-tags .search-tag:last-child").html().substr(0,5) == '+name')
			{
				$("#results-box table").html("<tr class='result' item-ref='-custom'>\n<td class='result-img'>\n </td>\n <td class='result-details'>\n <p><span class='ref-box'>-custom</span> "+ $("span.name .hidden-data").html() +"<br>\n <i>"+$(this).val()+"</i></p>\n </td>\n <td class='result-price'>\n <p>€[price]</p>\n </td>\n </tr>");

				if(event.keyCode == 13)
				{
					descr = $("#search-input").val();
					$("#search-input").val('');
					$("#search-tags").append("<span class='search-tag descr'>+descr<span class='hidden-data'>"+descr+"</span></span>");
					$("#search-input").attr('placeholder', 'enter custom price description');
				}

				return false;
			}

			// add price
			if($("#search-tags .search-tag:last-child").html().substr(0,6) == '+descr')
			{
				$("#results-box table").html("<tr class='result' item-ref='custom'>\n<td class='result-img'>\n </td>\n <td class='result-details'>\n <p><span class='ref-box'>custom</span> "+ $("span.name .hidden-data").html() +"<br>\n <i>"+ $("span.descr .hidden-data").html() +"</i></p>\n </td>\n <td class='result-price'>\n <p>€"+$(this).val()+"</p>\n </td>\n </tr>");

				if(event.keyCode == 13)
				{
					price = $("#search-input").val();
					new_item = $("span.name .hidden-data").html() + '--' + $("span.descr .hidden-data").html() + '--' + price;
					console.log(new_item);
					$("#search-input").val('');
					$("#search-tags").html('');
					$("#results-box table").html('');

					reach_validate_order_reload(id, 'ADD_CUSTOM-null-'+new_item);
				}

				return false;
			}

		}
	});


	$(document).on("focusin", "#search-input", function() {
		if($(this).val() != '')
		{
			var previous_request = search_db($(this).val());
		}
		$("#fade").show();
		// $('html, body').css({
		// 	'overflow': 'hidden',
		// 	'height': '100%'
		// });
	});


	$("#fade").on("click", function() {

		if(previous_request && previous_request.readyState < 4)
		{
			previous_request.abort();
		}

		$("#results-box table").html('');
		$("#fade").hide();
		// $('html, body').css({
		// 	'overflow': 'auto',
		// 	'height': 'auto'
		// });
	});

	$(document).on("click", "div#results-box table tr.result", function() {
		var ref = $(this).attr('item-ref');
		reach_validate_order_reload(id, 'ADD-'+ref);
	});


});
