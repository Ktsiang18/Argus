$(document).ready(function($){var $c=$("#tabs");var $lis=$c.find("ul li");$c.find("ul li a").click(function(){$lis.removeClass("ui-tabs-selected");$(this).closest("li").addClass("ui-tabs-selected");$c.find("div").hide().filter($(this).attr("href")).show();return false;});});
function wespeak(){
	window.open("/submission",
		"Submit to the Argus",
		"menubar=no,width=420,height=350,toolbar=no,status=no,resizable=no,location=no,scrollbars=no");
}