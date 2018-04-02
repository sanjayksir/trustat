var chk_global;
var final_html;
var related_storyTxt2;
localStorage.removeItem('chk_global');
localStorage.removeItem('related_storyTxt1');
var related_storyTxt;
var related_story_arr = [];

if ($("#related_storyTxt").val()) {
    related_storyTxt = $("#related_storyTxt").val();
    related_story_arr.push($("#related_storyTxt").val());
    $("#related_stories_txth").val(related_story_arr);
}


function get_stories() {
    if ($("#related_storyTxt").val()) {
        related_storyTxt = $("#related_storyTxt").val();
        related_story_arr.push($("#related_storyTxt").val());
    }
    related_story_arr = related_story_arr.filter(function (item, index, inputArray) {
        return inputArray.indexOf(item) == index;
    });

    if ($("#related_storyTxt").val() != '') {
        $.post('/spideybuzz/buzzadmn/getRelatedStories', {
            related_storyTxt: related_storyTxt,
            type: 'related'
        }, function (result) {
            $(".related_story").trigger("change");
            final_html = '<table border="0" cellpadding="5" cellspacing="5" width="100%">';
            if (localStorage.getItem("chk_global"))
                final_html += localStorage.getItem("chk_global") + '' + result;
            else
                final_html = result;
            final_html += '</table>';
			 $(".related_story_toggle_chk").show();
            $("#relatedId").html(final_html);
        });
    }else{
		 $(".related_story_toggle_chk").hide();
		 $("#relatedId").html('');
		 return false;
	}

    $("#related_stories_txt").val(related_story_arr);
}


$(document).ready(function () {
    $('.toggle_all').click(function () {
        if ($(this).is(':checked')) {
            $('.related_story').prop('checked', true);
        } else {
            $('.related_story').prop('checked', false);
        }
    });

    $('.related_story').change(function () {
        chk_global = '';
        localStorage.removeItem('chk_global');
        $('.related_story').each(function () {
            if ($(this).is(":checked")) {
                var con = $('#related_content_' + $(this).val()).html();
                chk_global += '<tr><td width="25"><input type="checkbox" name="related_storyId[]" class="related_story" id="related_storyId" value="' + $(this).val() + '" checked></td><td id="related_content_' + $(this).val() + '">' + con + '</td></tr>';
            }
        });
        localStorage.setItem("chk_global", chk_global);
    });
});
