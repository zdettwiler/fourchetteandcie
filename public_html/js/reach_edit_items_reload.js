function reach_edit_items_reload(ref, command)
{
	var xhr = new XMLHttpRequest();

	xhr.open('GET', 'quick-edit/'+ encodeURIComponent(command), true);
	xhr.addEventListener('readystatechange', function() {

		if (xhr.readyState === 4 && xhr.status === 200)
		{
            $("tr[item-ref='"+ ref +"']").html(xhr.responseText);
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

    // for toggle values
    $("table").on("click", ".edit-toggle", function() {
		var target = $(this).attr("target");
		var item_ref = $(this).parents('tr').attr('item-ref');
		console.log(target+'-'+item_ref);
		reach_edit_items_reload(item_ref, target+'-'+item_ref);
	});

    // for text edit
    $("table").on("click", ".edit-text", function() {
		if(!$(this).hasClass('editing'))
        {
            var current_val = $(this).html();

            $(this).addClass('editing');
            $(this).html("<input type='text' value='"+ current_val +"'>");
            // console.log(current_val);
        }
	});

    $('table').on("keypress", "input", function(event) {
        if(event.keyCode == 13)
		{
            var new_val = $(this).val();
            var target = $(this).parents('span').attr("target");
            var item_ref = $(this).parents('tr').attr('item-ref');

			$(this).blur();
			reach_edit_items_reload(item_ref, target+'-'+item_ref+'-'+new_val);
            return false; // prevent the button click from happening
        }
    });


});
