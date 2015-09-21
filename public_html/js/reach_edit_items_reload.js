function reach_edit_items_reload(command)
{
	$.ajax({
		type: 'GET',
		url: 'items/quick-edit/'+ encodeURIComponent(command),
		beforeSend: function() {
			$('#loading').css('display', 'inline-block');
			$("body").css('cursor', 'not-allowed');
		},
		success: function(response) {
			response = decodeURIComponent(response);
			response = response.split('-');

			if(response[0].substr(0,6) == 'TOGGLE')
			{
				if(response[2] == 0)
				{
					$("div[target='"+ response[0] +"-"+ response[1] +"']").removeClass('is-or-not-1').addClass('is-or-not-0');
					$("div[target='"+ response[0] +"-"+ response[1] +"'] img").attr('src', 'http://fourchetteandcie.com/pictures/0.png');
				}
				if(response[2] == 1)
				{
					$("div[target='"+ response[0] +"-"+ response[1] +"']").removeClass('is-or-not-0').addClass('is-or-not-1');
					$("div[target='"+ response[0] +"-"+ response[1] +"'] img").attr('src', 'http://fourchetteandcie.com/pictures/1.png');
				}
			}
			else if(response[0].substr(0,4) == 'EDIT')
			{
				$("span[target='"+ response[0] +"-"+ response[1] +"']").removeClass('editing').addClass('editable');
				$("span[target='"+ response[0] +"-"+ response[1] +"']").html(response[2]);
			}


		},
		complete: function () {
			$('#loading').css('display', 'none');
			$("body").css('cursor', 'auto');
		}
	});
}

$(function() {

    // for toggle values
    $("body").on("click", ".toggleable", function() {
		var target = $(this).attr("target");
		reach_edit_items_reload(target);
	});

	$("body").on("focusout", ".editable", function() {
		var new_value = $(this).html();
		var target = $(this).attr('target');
		reach_edit_items_reload(target +'-'+ new_value);
	});

    $('body').on("keypress", ".editable", function(event) {
        if(event.keyCode == 13)
		{
			event.preventDefault();
			$(this).blur();
			var new_value = $(this).html();
			var target = $(this).attr('target');
			reach_edit_items_reload(target +'-'+ new_value);
			return false;
        }
    });


});
