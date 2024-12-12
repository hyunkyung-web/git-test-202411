$(function () {
	$(".sub-list-toggle").on("click", function () {
		$(this).toggleClass("active");
		const subList = $(this).next("ul");
		subList.toggle();

		console.log("test");
		const icon = $(this).find("i");
		if (subList.is(":visible")) {
			icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
		} else {
			icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");
		}
	});

	if ($("#smarteditor").length) {
		startEditor();
	}
});

function startEditor() {
	var oEditor = [];
	nhn.husky.EZCreator.createInIFrame({
		oAppRef: oEditor,
		elPlaceHolder: "editorTxt",
		sSkinURI: "/public/common/smarteditor/SmartEditor2Skin.html",
		fCreator: "createSEditor2",
	});
}

function openMenu(menuNum = 0) {
	switch (menuNum) {
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
		case 910:
			location.href = "/admin/user_form";
			break;
	}
}
