$(document).ready(function ($) {
    $('.default').each(function() {    
        var field = $(this);

        field.attr('defaultValue', field.val());
        field.attr('_changed', 'false');

        field.focus(function() {
            if ($(this).attr('_changed') == 'false')
                $(this).val('');
        });

        field.blur(function() {
            if ($(this).val() == '') {
                $(this).val($(this).attr('defaultValue'));
                $(this).attr('_changed', 'false');
                $(this).addClass('default');
                $(this).attr('name', '');
            }
        });
        
        field.keydown(function() {
            if ($(this).attr('_changed') == 'false') {
                $(this).attr('_changed', 'true');
                $(this).removeClass('default');
            }
        });
    });
});

function email(id) {
	window.open("/email/"+id,
		"Email This Article",
		"menubar=no,width=420,height=300,toolbar=no,status=no,resizable=no,location=no,scrollbars=no");
}

function submission() {
	window.open("/submission/",
		"Submission — The Wesleyan Argus",
		"menubar=no,width=3750,height=625,toolbar=no,status=no,resizable=no,location=no,scrollbars=no");
}