/*
$(document).ready(function() {
	// Collapse everything but the first menu:
	$("#VerColMenu > li > a").find("+ ul").slideUp(1);
	// Expand or collapse:
	$("#VerColMenu > li > a").click(function() {;
		$("#VerColMenu > li > a").not(this).find("+ ul").slideUp(1);
		$(this).find("+ ul").slideToggle("fast");
		$("#VerColMenu > li > a").not(this).removeClass("current");
		$(this).addClass("current");
	});
	
	// Collapse everything but the first menu:
	$("#VerColMenu1 > li > a").find("+ ul").slideUp(1);
	// Expand or collapse:
	$("#VerColMenu1 > li > a").click(function() {;
		$("#VerColMenu1 > li > a").not(this).find("+ ul").slideUp(1);
		$(this).find("+ ul").slideToggle("fast");
		$("#VerColMenu1 > li > a").not(this).removeClass("current");
		$(this).addClass("current");
	});
});
*/

$(document).ready(function() {
	// Collapse everything but the first menu:
	$("#VerColMenu > li > a").find("+ ul").slideUp(1);
	// Expand or collapse:
	$("#VerColMenu > li > a").click(function() {;
		//$("#VerColMenu > li > a").not(this).find("+ ul").slideUp(1);
		$(this).find("+ ul").slideToggle("fast");
		$("#VerColMenu > li > a").not(this).removeClass("current");
		$(this).addClass("current");
	});
	
	// Collapse everything but the first menu:
	$("#VerColMenu1 > li > a").find("+ ul").slideUp(1);
	// Expand or collapse:
	$("#VerColMenu1 > li > a").click(function() {;
		//$("#VerColMenu1 > li > a").not(this).find("+ ul").slideUp(1);
		$(this).find("+ ul").slideToggle("fast");
		$("#VerColMenu1 > li > a").not(this).removeClass("current");
		$(this).addClass("current");
	});
});