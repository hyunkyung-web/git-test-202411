$(function () {
	$(".sub-list-toggle").on("click", function () {
		$(this).toggleClass("active");
		const subList = $(this).next("ul");
		subList.toggle();

		const icon = $(this).find("i");
		if (subList.css("display") == "block") {
			console.log(icon.prop("class"));
//			icon.attr("class", "fas fa-chevron-up");
//			icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
		} else {
			icon.attr("class", "fas fa-chevron-down");
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

function updateFileName() {
	const fileInput = $("#file").get(0);
	const uploadNameInput = $(".upload-name");

	if (fileInput.files.length > 0) {
		uploadNameInput.val(fileInput.files[0].name);
	} else {
		uploadNameInput.val("Add file...");
	}
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
			location.href = "/admin/template_form";
			break;
		case 900:
			location.href = "/admin/user_list";
			break;
		case 910:
			location.href = "/admin/user_form";
			break;
	}
}


function msgBtnAdd(){
	
	let btnStr='';
	let btnCnt = $("#ftButton tr").length/2;
	
	if(btnCnt == 5){		
		alert("버튼은 최대 5개까지만 생성 할 수 있습니다.");
		return;
	}
	
	btnStr+='<tr><td>';
	btnStr+='<button type="button" class="btn_remove" onclick="msgBtnRemove(this);">X</button>&nbsp;&nbsp;<select name="btn_type[]">';
	btnStr+='<option value="">타입</option>';
	btnStr+='<option value="WL">웹버튼</option>';
	btnStr+='</select>';							
	btnStr+='</td>';
	btnStr+='<td><input type="text" name="btn_name[]" placeholder="버튼명" /></td></tr>';
	btnStr+='<tr><td colspan="2"><input type="text" name="btn_link[]" placeholder="연결링크" /></td></tr>';
	
	$("#ftButton").append(btnStr);
}

function msgBtnRemove(e){
	
	let prTr = $(e).parent().parent();
	prTr.next().remove();
	prTr.remove();
	return;
	
}

