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

	$(".btn-login").click(function () {
		loginVerify();
	});

	// tab - 체크박스 관련 내용
	$("input[name=chk_all]").click(function () {
		updateAllCheck();
	});
	$("input[name=chk_address]").click(function () {
		updateEachCheck();
	});
	$(".address_selected_wrap").on("click", ".label_added", function () {
		const checkboxId = $(this).attr("for");
		// input - 체크제거
		const checkbox = $(`#${checkboxId}`);
		if (checkbox.length) {
			checkbox.prop("checked", false);
		}
		// 라벨 저거
		$(this).remove();
		updateEachCheck();

		sendData();
	});
	// 탭화면의 모든 label 제거
	$(".address_selected_wrap").on("click", "#delete_labelAll", function () {
		$(".address_selected").empty();
	});

	// $("#delete_labelAll").on("click", function () {
	// 	alert("yes");
	// 	$(".address_selected").empty();
	// });

	if ($("#smarteditor").length) {
		nhn.husky.EZCreator.createInIFrame({
			oAppRef: oEditor,
			elPlaceHolder: "body_text",
			sSkinURI: "/public/common/smarteditor/SmartEditor2Skin.html",
			fCreator: "createSEditor2",
		});
	}
});

//스마트 에디터 오브젝트
var oEditor = [];

function openTab(event, currentTab) {
	resetAllCheck();
	$(".popup").removeClass("active");
	const tabContents = $(".tab_content");
	const tabButtons = $(".btn_tab");

	tabContents.each(function () {
		$(this).removeClass("active");
	});
	tabButtons.each(function () {
		$(this).removeClass("active");
	});

	$(`#${currentTab}`).addClass("active");
	$(event.currentTarget).addClass("active");
}

function openPopup(obj) {
	$(obj).addClass("active");
	// $(".tab_content").removeClass("active");
}
function closePopup() {
	$(".popup").removeClass("active");
}

var TARGET_TYPE;

//탭 클릭시, popup -- reset
function openAddressBook(send_type) {
	TARGET_TYPE = send_type;
	openPopup(".mobile_screen_pop");

	console.log(TARGET_TYPE);
}

// 함수 통합
function resetAllCheck() {
	$("input[name=chk_address]").prop("checked", false);
	$("input[name=chk_all]").prop("checked", false);
	$(".address_selected").empty();
}
function updateAllCheck() {
	if ($("input[name=chk_all]").is(":checked")) {
		$("input[name=chk_address]").prop("checked", true);
	} else {
		$("input[name=chk_address]").prop("checked", false);
	}

	updateEachCheck();
}

function updateEachCheck() {
	//전체체크 해제
	// console.log($("input[name=chk_address]").length);
	// console.log($("input[name=chk_address]:checked").length);
	const allChecked =
		$("input[name=chk_address]").length ===
		$("input[name=chk_address]:checked").length;

	$("#chk_all").prop("checked", allChecked);

	//confirm 버튼때문에 - 라벨추가, sendData 따로 분리
}
function confirmData() {
	// let chkData = [];
	let addStr = "";
	$(".address_selected").empty();

	addStr += `<button id="delete_labelAll" class="white">reset</button>`;
	$("input[name=chk_address]:checked").each(function () {
		// chkData.push($(this).val());
		addStr += `<label for="${this.id}" class="label_added"><span>${this.title} X</span></label>`;
	});

	$(".address_selected").append(addStr);

	sendData();
	closePopup();
}

function sendData() {
	let phoneInfo = [];
	let emailInfo = [];
	$('input[name="chk_address"]:checked').each(function () {
		let phone = $(this).data("phone");
		let email = $(this).data("email");

		if (phone) {
			phoneInfo.push(phone);
		}
		if (email) {
			emailInfo.push(email);
		}
	});

	$("#kakako_target").val(phoneInfo.join(","));
	$("#lms_target").val(phoneInfo.join(","));
	$("#email_target").val(emailInfo.join(","));
}

//확인버트 클릭시 -- 현재 데이터 업데이트
//취소버튼 클릭시 -- 단순히 popup close

// Mobile burger
document.addEventListener("DOMContentLoaded", function () {
	const hamburgerMenu = document.querySelector(".hamburger-menu");
	const navLinks = document.querySelector(".menu-toggle");

	navLinks.addEventListener("click", function () {
		hamburgerMenu.classList.toggle("active");
		navLinks.classList.toggle("active");
	});
});

function loginVerify() {
	if ($.trim($("#user_id").val()).length == 0) {
		alert("아이디를 입력하세요");
		$("#user_id").focus();
		return;
	}
	if ($.trim($("#user_pw").val()).length == 0) {
		alert("비밀번호를 입력하세요");
		$("#user_pw").focus();
		return;
	}

	var postData = $("#frm1").serialize();

	$.ajax({
		type: "POST",
		url: "/admin/login_verify",
		data: postData,
		dataType: "json",
		beforeSend: function () {},
		success: function (data) {
			if (data.result == "ok") {
				location.replace("/admin/main");
			} else {
				alert(data.msg);
			}
		},
		error: function (request, status, err) {
			alert("Server Error Occured:" + err);
			return;
		},
	});
}

function updateFileName() {
	const fileInput = $("#attach_file").get(0);
	const uploadNameInput = $(".upload-name");

	if (fileInput.files.length > 0) {
		uploadNameInput.val(fileInput.files[0].name);
	}
}

function openMenu(menuNum = 0) {
	switch (menuNum) {
		case 101:
			location.href = "/admin/contents_form";
			break;
		case 102:
			location.href = "/admin/contents_list";
			break;
		case 201:
			location.href = "/admin/template_form";
			break;
		case 202:
			location.href = "/admin/template_list";
			break;
		case 210:
			location.href = "/admin/message_list";
			break;
		case 301:
			location.href = "/admin/notice_form";
			break;
		case 302:
			location.href = "/admin/notice_list";
			break;
		case 501:
			location.href = "/admin/member_form";
			break;
		case 502:
			location.href = "/admin/member_list";
			break;
		case 601:
			location.href = "/admin/user_form";
			break;
		case 602:
			location.href = "/admin/user_list";
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

function returnList() {
	history.go(-1);
}

function noticeList(page = 1) {
	let postUrl = "/admin/notice_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

function contentsList(page = 1) {
	let postUrl = "/admin/contents_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

function noticeSave(editMode) {
	oEditor.getById["body_text"].exec("UPDATE_CONTENTS_FIELD", []);
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
		url: "/admin/contents_save",
		data: postData,
		dataType: "json",
		beforeSend: function () {},
		success: function (data) {
			alert(data.msg);
			if (editMode != "D") {
				$("#idx").val(data.rtn_idx);
				if (data.result == "ok") {
					location.replace("/admin/notice_form/" + data.idx);
				}
			} else {
				contentsList();
			}
			return;
		},
		error: function (request, status, err) {
			console.log(err);
			return;
		},
	});
}

/******************************************************************
 *	함수명: templateSave()
 *	기능: 템플릿 저장
 ******************************************************************/
function contentsSave(editMode) {
	oEditor.getById["body_text"].exec("UPDATE_CONTENTS_FIELD", []);
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
		url: "/admin/contents_save",
		data: postData,
		dataType: "json",
		beforeSend: function () {},
		success: function (data) {
			alert(data.msg);
			if (editMode != "D") {
				$("#idx").val(data.rtn_idx);
				if (data.result == "ok") {
					location.replace("/admin/contents_form/" + data.idx);
				}
			} else {
				contentsList();
			}
			return;
		},
		error: function (request, status, err) {
			console.log(err);
			return;
		},
	});
}

function templateList(page = 1) {
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
				if (data.result == "ok") {
					location.replace("/admin/template_form/" + data.idx);
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

function messageList(page = 1) {
	let postUrl = "/admin/message_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

function sendKakaoTalk(msgType) {
	$("#msg_target").val($("#kakako_target").val());

	let postData = new FormData($("#frm1")[0]);

	$.ajax({
		type: "POST",
		enctype: "multipart/form-data",
		contentType: false,
		processData: false,
		url: "/bizmsg/push_contents_msg",
		dataType: "json",
		data: postData,
		beforeSend: function () {},
		success: function (data) {
			alert(data.msg);
		},
		error: function (request, status, err) {
			alert("Server Error Occured:" + err);
			return;
		},
	});
}

function memberList(page = 1) {
	let postUrl = "/admin/member_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

/******************************************************************
 *	함수명: memberSave()
 *	기능: 사용자 저장
 ******************************************************************/
function memberSave(editMode) {
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
		beforeSend: function () {},
		success: function (data) {
			alert(data.msg);

			if (data.result == "ok") {
				location.replace("/admin/member_form/" + data.idx);
			}
		},
		error: function (request, status, err) {
			console.log(err);
			return;
		},
	});
}

function userList(page = 1) {
	let postUrl = "/admin/user_list/" + page;

	$("#frmSearch").attr("action", postUrl).submit();
}

/******************************************************************
 *	함수명: userSave()
 *	기능: 사용자 저장
 ******************************************************************/
function userSave(editMode) {
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
		beforeSend: function () {},
		success: function (data) {
			alert(data.msg);
			if (data.result == "ok") {
				location.replace("/admin/user_form/" + data.idx);
			}
		},
		error: function (request, status, err) {
			console.log(err);
			return;
		},
	});
}

function userDuplicateCheck() {
	if ($.trim($("#user_id").val()).length == 0) {
		alert("아이디를 입력하세요.");
		return;
	}

	var userId = $("#user_id").val();

	$.ajax({
		type: "POST",
		url: "/admin/user_duplicate_check",
		data: { user_id: userId },
		dataType: "json",
		success: function (data) {
			alert(data.msg);
			return;
		},
		error: function (request, status, err) {
			alert("Server Error Occured:" + err);
			return;
		},
	});
}

/******************************************************************
 *	함수명: admChgUserPw()
 *	기능: 사용자 암호변경 모드 전환
 ******************************************************************/
function userPasswordChange() {
	var chgMod = $(".user-password").css("display");
	//암호변경 모드가 아님
	if (chgMod == "none") {
		$(".user-password").show();
		$("#btnChgPw").text("변경취소");
	} else {
		$(".user-password").hide();
		$("#btnChgPw").text("암호변경");
	}
}
