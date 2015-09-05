function search_db(query)
{
	var tags = '';
	$('.search-tag').each(function() {
	   tags += $(this).html() + '|';
	});

	$.ajax({
		type: 'GET',
		url: '../../../search/' + encodeURIComponent(tags+query),
		success: function(results) {
			display_response(results);
		}
	});
}

function display_response(json_results)
{
	var results = $.parseJSON(json_results);
	console.log(results);
	var result_template = $("#template-search-result-order-validation").html();
	$("#results-box table").html('');

	if(results.length === 0)
	{
		html_result = "<tr class='result'>\n <td colspan='3'><p>No result...</p></td>\n </tr>";
	}
	else
	{
		$.each( results, function( i, result ) {
			console.log(result);
			$("#results-box table").append( Mustache.render(result_template, result) );
		});
	}

	return false;
}

function select_result(ref)
{
	var keep_result = $("tr[item-ref='"+ref+"'")[0].outerHTML;
	$("#selection table").append(keep_result);
	return false;
}

$(function() {
	var search_timer;
	var no_search = ['', '#', '$', '@'];

	$(document).on("keyup", "#search-input", function(event) {
		var $query = $(this).val();
		clearTimeout(search_timer);

        // if no + tag i.e. not creating new item, then normal search
		if($("#search-tags span:first").html() != '+')
		{

    		// search only if query !empty and !key-tag
    		if( $query != '' && $.inArray( $query.substr(0, 1), no_search ) == -1 )
    		{
    			search_timer = setTimeout(function() {
    				 search_db( $query );
    			 }, 500 );
    		}
    		else
    		{
    			$("#results-box table").html('');
    		}

    		// SEARCH TAGS
    		if(event.keyCode == 32)
    		{
    			var tag = $query.split(' ')[0];

    			// #ref search
    			if($query.substr(0, 1) == '#')
    			{
    				$("#search-input").val('');
    				$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
    			}
    			// $section search
    			if($query.substr(0, 1) == '$')
    			{
    				$("#search-input").val('');
    				$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
    			}
    			// @categ search
    			if($query.substr(0, 1) == '@')
    			{
    				$("#search-input").val('');
    				$("#search-tags").append("<span class='search-tag'>"+tag+"</span>");
    			}
                // + custom item creation
                if($query == '+ ')
                {
                    $("#search-input").val('');
                    $("#search-tags").append("<span class='search-tag'>+</span>");
                    $("#search-input").attr('placeholder', 'enter custom item name');
                    $("#results-box table").html('');


                    // reach_validate_order_reload(id, 'ADD-'+ref);
                }
    			search_db( $("#search-input").val() )
    		}
        }


		// if + tag new item creation process
		else if($("#search-tags span:first").html() == '+')
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

	// delete a search tag
	$(document).on("keyup", function(event) {
		if((event.keyCode == 8 || event.keyCode == 46) && $("#search-input").val() == '')
		{
			$("#search-tags .search-tag:last-child").remove();
		}
	});


	$("#fade").on("click", function() {

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
