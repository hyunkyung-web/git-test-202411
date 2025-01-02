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

// Mobile burger
document.addEventListener("DOMContentLoaded", function () {
	const hamburgerMenu = document.querySelector(".hamburger-menu");
	const navLinks = document.querySelector(".menu-toggle");

	navLinks.addEventListener("click", function () {
		hamburgerMenu.classList.toggle("active");
		navLinks.classList.toggle("active");
	});
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
		case 800:
			location.href = "/admin/member_list";
			break;
		case 810:
			location.href = "/admin/member_form";
			break;
		case 900:
			location.href = "/admin/user_list";
			break;
		case 910:
			location.href = "/admin/user_form";
			break;
	}
}

function imgUrlView(imgUrl) {
	$("#img_url").val("");
	$("#img_url").val(imgUrl);
	cmmClosePop(".pop_img");
}

function msgBtnAdd() {
	let btnStr = "";
	let btnCnt = $("#ftButton tr").length / 2;

	if (btnCnt == 5) {
		alert("버튼은 최대 5개까지만 생성 할 수 있습니다.");
		return;
	}

	btnStr += "<tr><td>";
	btnStr +=
		'<button type="button" class="btn_remove" onclick="msgBtnRemove(this);">X</button>&nbsp;&nbsp;';
	btnStr +=
		'<select class="category-select form-select" name="btn_type[]" class="category-select form-select">';
	btnStr += '<option value="WL">웹버튼</option>';
	btnStr += "</select>";
	btnStr += "</td>";
	btnStr +=
		'<td><input type="text" name="btn_name[]" placeholder="버튼명" /></td></tr>';
	btnStr +=
		'<tr><td colspan="2"><input type="text" name="btn_link[]" placeholder="연결링크" /></td></tr>';

	$("#ftButton").append(btnStr);
}

function msgBtnRemove(e) {
	let prTr = $(e).parent().parent();
	prTr.next().remove();
	prTr.remove();
	return;
}

function returnList(){
	history.go(-1);
}

function templateList(page) {
	let postUrl = "/admin/template_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

/******************************************************************
 *	함수명: templateSave()
 *	기능: 템플릿 저장
 ******************************************************************/
function templateSave(editMode) {
	//	var reqArr = ["txtNm", "txtDate", "txtTime", "txtRuntime", "txtAgenda", "txtSpeaker", "txtPasskey"];
	//	var chkReq = false;
	//
	//	if(editMode == "D"){
	//		if(!confirm('데이터를 삭제하시겠습니까?')){
	//			return;
	//		}
	//		imgDelete('event', $("#txtIdx").val(), "delete");
	//	} else {
	//		$.each(reqArr, function(idx, item){
	//			if($.trim($("#"+item).val()).length == 0){
	//				cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
	//				$("#"+item).focus();
	//				chkReq = true;
	//				return false;
	//			}
	//		});
	//		if(chkReq){
	//			console.log('필수입력 누락');
	//			return;
	//		}
	//	}

	$("#editMode").val(editMode);
	var postData = new FormData($("#frm1")[0]);
	//	var postData = $("#frm1").serialize();

	$.ajax({
		type: "POST",
		enctype: "multipart/form-data",
		contentType: false,
		processData: false,
		url: "/admin/template_save",
		data: postData,
		dataType: "json",
		beforeSend: function () {},
		success: function (data) {
			alert(data.msg);
			if (editMode != "D") {
				$("#idx").val(data.rtn_idx);
				if(data.result=="ok"){
					location.replace("/admin/template_form/"+data.idx);	
				}				
			} else {
				templateList("main");
			}
			return;
		},
		error: function (request, status, err) {
			console.log(err);
			return;
		},
	});
}


function memberList(page) {
	let postUrl = "/admin/member_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

/******************************************************************
*	함수명: memberSave()
*	기능: 사용자 저장
******************************************************************/
function memberSave(editMode){
	
//	var reqArr = ["userId", "userPw", "userNm"];
//	var chkReq = false;
//	
//	if(editMode=="N"){
//		$.each(reqArr, function(idx, item){
//			if($.trim($("#"+item).val()).length == 0){
//				cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
//				$("#"+item).focus();
//				chkReq = true;
//				return false;
//			}			
//		});
//		
//		if(chkReq){
//			console.log('필수입력 누락');
//			return;
//		}
//		if($.trim($("#userPw").val()) != $.trim($("#userPw_2").val())){
//			cmmShowMsg('비밀번호가 일치하지 않습니다.');
//			return;
//		}
//	}
	
	$("#editMode").val(editMode);
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/member_save/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			alert(data.msg);

			if(data.result=="ok"){
				location.replace("/admin/member_form/"+data.idx);	
			}
			
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function userList(page) {
	let postUrl = "/admin/user_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

/******************************************************************
*	함수명: userSave()
*	기능: 사용자 저장
******************************************************************/
function userSave(editMode){
//	var reqArr = ["user_id", "user_pw", "user_nm"];
//	var chkReq = false;
//	
//	if(editMode=="N"){
//		$.each(reqArr, function(idx, item){
//			if($.trim($("#"+item).val()).length == 0){
//				cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
//				$("#"+item).focus();
//				chkReq = true;
//				return false;
//			}			
//		});
//		
//		if(chkReq){
//			console.log('필수입력 누락');
//			return;
//		}
//		if($.trim($("#user_pw").val()) != $.trim($("#user_pw_2").val())){
//			cmmShowMsg('비밀번호가 일치하지 않습니다.');
//			return;
//		}
//	}
//	
//	if(editMode=="U"){
//		if($(".user_pw").css("display")!="none"){
//			if($.trim($("#user_pw").val()).length == 0){
//				cmmShowMsg('비밀번호를 입력하세요.');
//				$("#user_pw").focus();
//				return;
//			}
//			if($.trim($("#user_pw").val()) != $.trim($("#user_pw_2").val())){
//				cmmShowMsg('비밀번호가 일치하지 않습니다.');
//				$("#user_pw").focus();
//				return;
//			}
//		}
//		
//		for(i=2; i<reqArr.length; i++){
//			if($.trim($("#"+reqArr[i]).val()).length == 0){
//				cmmShowMsg ($("#"+reqArr[i]).prop("placeholder")+' 필수입력 누락입니다.');
//				$("#"+reqArr[i]).focus();
//				return;
//			}
//		}
//	}
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/user_save/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.result=="ok"){
				location.replace("/admin/user_form/"+data.idx);
			}			
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function userDuplicateCheck(){
	
	if($.trim($("#user_id").val()).length == 0) {
		alert("아이디를 입력하세요.");
		return;
	}
	
	var userId = $("#user_id").val();
	
	$.ajax({	
		  type: "POST",
		  url: "/admin/user_duplicate_check",
		  data: {user_id:userId},
		  dataType: "json",
		  success: function(data){
			alert(data.msg);
			return;
		  },
		  error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		  }
	});
}

/******************************************************************
*	함수명: admChgUserPw()
*	기능: 사용자 암호변경 모드 전환
******************************************************************/
function userPasswordChange(){
	var chgMod = $(".user-password").css("display");
	//암호변경 모드가 아님
	if(chgMod == "none"){
		$(".user-password").show();
		$("#btnChgPw").text('변경취소');
	} else {			
		$(".user-password").hide();
		$("#btnChgPw").text('암호변경');
	}
}
