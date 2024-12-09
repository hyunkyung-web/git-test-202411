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


function openMenu(menuNum=0){
	
	switch(menuNum){
		case 100:
			location.href = "/admin/contents_list";
			break;
		case 110:
			location.href = "/admin/contents_form";
			break;
		case 200:
			location.href = "/admin/template_list";
			break;
		case 210:
			location.href = "/admin/template_list";
			break;
		case 900:
			location.href = "/admin/user_list";
			break;
	}
}