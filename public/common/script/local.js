$(function () {	
	
	$(".sub-list-toggle").on("click", function () {

		
		const subList = $(this).next("ul");
		subList.toggle();

		const icon = $(this).find("i");
		if (subList.is(":visible")) {
			icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
		} else {
			icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");
		}
	});
	
});
