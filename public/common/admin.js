window.addEventListener('DOMContentLoaded', function(){ 
//	console.log('window addEventListener DOMContentLoaded');	
});

$(document).ready(function(){
	$(".left_area li").click(function(){
		$(".left_area li").removeClass("click");
		$(this).addClass("click");
	});
});

function adjustHeight(obj) {
  var textEle = $(obj);
  $(obj)[0].style.height = 'auto';
  var textEleHeight = textEle.prop('scrollHeight');
  textEle.css('height', textEleHeight);
};

/******************************************************************
*	함수명: callData()
*	기능: 컨텐츠 프로그램 호출
******************************************************************/
function callApi(menuCode){
	
	var callUrl;
	
	switch(menuCode){
		case 1:
			callUrl = "/admin/event_list";
			break;
		case 2:
			callUrl = "/admin/event_log_list";
			break;
		case 3:
			callUrl = "/admin/event_qna_list";
			break;
		case 4:
			callUrl = "/admin/application_list";
			break;
		case 99:
			callUrl = "/admin/faq_list";
			break;
		case 101:
			callUrl = "/admin/visit_list";
			break;
		case 201:
			callUrl = "/message/biztalk_sender";
			break;
		case 211:
			callUrl = "/message/template_list";
			break;
		case 281:
			callUrl = "/message/biztalk_log";
			break;
		case 299:
			callUrl = "/member/member_list";
			break;
		case 901:
			callUrl = "/qlink/link_list";
			break;
		case 910:
			callUrl = "/admin/member_list";
			break;
		case 911:
			callUrl = "/massemail/mass_email_list";
			break;
		case 929:
			callUrl = "/admin/utm_report";
			break;
		case 999:
			callUrl = "/admin/user_list";
			break;			
			
		default:
			callUrl = "/admin/event_calendar";
			break;
	}
	
	$.ajax({
		type: "POST",
		url: callUrl,
		data: {},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			$("#mainSearch")[0].reset();
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: eventOpen()
*	기능: 행사 상세내용 보기
******************************************************************/
function eventOpen(eventIdx=-1){
	
//	var postData = $("#poFrm1").serialize();	
//	var postData = new FormData($("#frm1")[0]);
//	검색조건을 메인페이지에 저장
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/admin/event_open",
		data: {eventIdx:eventIdx},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: eventList()
*	기능: 행사 리스트
******************************************************************/
function eventList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/admin/event_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: eventSave()
*	기능: 행사 내용 저장
******************************************************************/
function eventSave(editMode){
	
	var reqArr = ["txtNm", "txtDate", "txtTime", "txtRuntime", "txtAgenda", "txtSpeaker", "txtPasskey"];
	var chkReq = false;

	if(editMode == "D"){
		if(!confirm('데이터를 삭제하시겠습니까?')){
			return;
		}
		imgDelete('event', $("#txtIdx").val(), "delete");
	} else {
		$.each(reqArr, function(idx, item){
			if($.trim($("#"+item).val()).length == 0){
				cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
				$("#"+item).focus();
				chkReq = true;
				return false;
			}
		});
		if(chkReq){
			console.log('필수입력 누락');
			return;
		}
	}
	
	$("#editMode").val(editMode);
	var postData = new FormData($("#frm1")[0]);
//	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		contentType : false,
		processData : false,
		url: "/admin/event_save",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			  
			if(data.result == "ok"){
				cmmShowMsg(data.msg);
				if(editMode != "D"){											
					eventOpen(data.rtn_idx);
				} else {
					eventList('main');
				}
			} else {
				cmmShowMsg(data.msg);
			}
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: imgDelete()
*	기능: 행사 상세내용에서 썸네일 파일삭제 및 디비 업데이트
******************************************************************/
function imgDelete(type, idx, ref="save"){
	
	$.ajax({
		type: "POST",
		url: "/admin/img_delete",
		data: {type:type, idx:idx},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(ref=="delete"){
				return(true);	
			} else {
				if(type=="event"){
					eventOpen(idx);
				}	
			}			
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}



/******************************************************************
*	함수명: copyLink()
*	기능: 행사 상세보기에서 공유주소 값 복사하기 기능
******************************************************************/
function copyLink(e){
	$("#"+e).select(); 
	document.execCommand('copy');
	
	cmmShowMsg("Copy Complete");
	
//	setTimeout(function(){
//		$("#"+e+"Msg").show();	
//	}, 0);
//	setTimeout(function(){
//		$("#"+e+"Msg").hide();	
//	}, 1000);
}

/******************************************************************
*	함수명: saveSearch()
*	기능: 데이터 상세보기 들어 갈 때 검색했던 조건을 메인화면에 복사해두기
******************************************************************/
function saveSearch() {
	$("#mainSearch #page").val($("#page").val());
	$("#mainSearch #sch_1").val($("#sch_1").val());
	$("#mainSearch #sch_2").val($("#sch_2").val());
	$("#mainSearch #sch_3").val($("#sch_3").val());
	$("#mainSearch #sch_4").val($("#sch_4").val());
}

/******************************************************************
*	함수명: eventLogPick()
*	기능: 행사 참여현황 리스트 - 행사선택 시 행사일자로 검색조건의 시작날짜 변경하기
******************************************************************/
function eventLogPick(){
	$("#sch_1").val($("#sch_4 > option:selected").attr("data-sub"));
}
	
/******************************************************************
*	함수명: eventLogList()
*	기능: 행사 참여현황 리스트
******************************************************************/
function eventLogList(type){	

	if(type=="self"){
		$("#page").val(1);
	}
	var postData = $("#frmSearch").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/event_log_list/",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: eventLogZipge()
*	기능: 행사 참여현황 집계리스트
******************************************************************/
function eventLogZipge(type){

	if(type=="self"){
		$("#page").val(1);
	}
	var postData = $("#frmSearch").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/event_log_zipge/1",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: eventLogOnline()
*	기능: 행사 참여현황 온라인 리스트
******************************************************************/
function eventLogOnline(type){

	if(type=="self"){
		$("#page").val(1);
	}
	var postData = $("#frmSearch").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/event_log_zipge/2",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function eventLogExcel(report_type="1") {
	//report_type-0:현황, 1:집계
	$("#frmSearch").attr("action", "/admin/event_log_excel/"+report_type).submit();
}


/******************************************************************
*	함수명: eventQnaList()
*	기능: 질문내역 리스트
******************************************************************/
function eventQnaList(type){

	if(type=="self"){
		$("#page").val(1);
	}
	
	var postData = $("#frmSearch").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/event_qna_list/",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: eventQnaList()
*	기능: 질문내역 리스트
******************************************************************/
function popQnaList(){
	
	var postData = $("#frmSearch").attr("action", "/admin/event_qna_pop/").submit();

}

function openQnaPop(){
	var winUrl = "/admin/event_qna_pop?sch_1="+$("#sch_1").val();
	window.open(winUrl, '');
}

/******************************************************************
*	함수명: eventSaveQuestion()
*	기능: 질문등록
******************************************************************/
function eventUpdateQna(editMode, idx, event_idx){
	
	var show_yn = "N";
	var reply_ok = "N";
	var answer = '';
	
	if(editMode == "show"){
		show_yn="Y";
	}
	if(editMode == "reply"){
		reply_ok = "Y";
	}
	
	$.ajax({
		type: "POST",
		url: "/admin/update_event_qna/",
		data: {editMode:editMode, idx:idx, event_idx:event_idx, show_yn:show_yn, reply_ok:reply_ok, answer:answer},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			  
			cmmShowMsg(data.msg);
			eventQnaList();
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: joinWebinar()
*	기능: 웨비나 참여하기
******************************************************************/
function eventJoinTest(type="stream"){
	
	if(type != "zoom"){
		var actUtl = "/webinar/stream";	
	} else {
		var actUtl = "/webinar/video";	
	}
	
	var newTab = window.open("about:blank", "winVideo");
	$("#videoFrm").attr("action", actUtl).attr("target", "winVideo").submit();
	
}

/******************************************************************
*	함수명: faqList()
*	기능: 문의사항 리스트
******************************************************************/
function faqList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 goPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/admin/faq_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function faqOpen(idxNo=-1){
	
//	var postData = $("#poFrm1").serialize();	
//	var postData = new FormData($("#frm1")[0]);
//	검색조건을 메인페이지에 저장
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/admin/faq_open",
		data: {idxNo:idxNo},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: cmmSaveFaq()
*	기능: 대기실-문의사항 등록
******************************************************************/
function faqSave(){
	var reqArr = ["txtAnswer"];
	var chkReq = false;
	
	$.each(reqArr, function(idx, item){
		if($.trim($("#"+item).val()).length == 0){
			cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
			$("#"+item).focus();
			chkReq = true;
			return false;
		}
	});
	if(chkReq){
		console.log('필수입력 누락');
		return;
	}
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/webinar/customer_update_faq/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			cmmShowMsg(data.msg, 2500);
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: applicationList()
*	기능: 질문내역 리스트
******************************************************************/
function applicationList(type){

	if(type=="self"){
		$("#page").val(1);
	}
	
	var postData = $("#frmSearch").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/application_list/",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function applicationEditOpen(idxNo){
	let rawData = $("#raw_"+idxNo).val();
	let arrData = rawData.split("|");
	
	$("#frm_info")[0].reset();
	
	$("#txt_idx").val(arrData[0]);
	$("#txt_user_nm").val(arrData[1]);
	$("#txt_biz_nm").val(arrData[2]);
	$("#txt_biz_dept").val(arrData[3]);
	$("#txt_email").val(arrData[4]);
	$("#txt_mobile").val(arrData[5]);
	
	openPopup('#popupInfo');
}

function applicationEditSave(){	
	
	var postData = $("#frm_info").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/application_edit_save/",
		data: postData,
		dataType: "json",
		success: function(data){
			
			setTimeout(function(){
				cmmShowMsg(data.msg, 1000);
			}, 0);
			setTimeout(function(){
				closePopup();
				applicationList();
			}, 1200);
			
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: applicationList()
*	기능: 질문내역 리스트
******************************************************************/
function auth_application_list(){
	$("#frmSearch").attr("action", "/webinar/appication_auth_list").submit();
}

function auth_applicationExcel(){	
	$("#frmSearch").attr("action", "/webinar/excel_appication_auth_list").submit();
}

function applicationUpload(){
	
	var reqArr = ["fileExcel"];
	var chkReq = false;
	
	$("#uploadEventIdx").val($("#sch_1 option:selected").val());
	
	$.each(reqArr, function(idx, item){
		if($.trim($("#"+item).val()).length == 0){
			cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
			$("#"+item).focus();
			chkReq = true;
			return false;
		}
	});
	if(chkReq){
		console.log('필수입력 누락');
		return;
	}
	
	if($("#uploadEventIdx").val() == -1){
		alert('행사를 선택 한 후 업로드를 진행해주세요.');
		return;
	}
	
	var postData = new FormData($("#frmUpload")[0]);
	
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		contentType : false,
		processData : false,
		url: "/admin/application_upload",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg);
			applicationList('self');
			closePopup();
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function applicationDelete(uploadNum=""){	
	
	if(!confirm(uploadNum+'의 업로드 내역을 일괄 삭제하시겠습니까?')){
		return false;
	}
		
	var postData = {editMode: "D", uploadNum: uploadNum, eventIdx: $("#sch_1").val()};

	$.ajax({
		type: "POST",
		url: "/webinar/save_application",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg);
			applicationList('self');
			closePopup();
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function chkAll(obj){
	var chkStat = $("#id_"+obj).attr("alt");
	if(chkStat == ""){
		$("input:checkbox[name="+obj+"]").prop("checked", true);
		$("#id_"+obj).attr("alt", "all_chk");
	} else {
		$("input:checkbox[name="+obj+"]").prop("checked", false);
		$("#id_"+obj).attr("alt", "");
	}
	
}

function applicationChkDelete(editMode="delete"){
	/*
	if(!confirm('선택한 신청내역을 삭제하시겠습니까?')){
		return false;
	}
	*/
	arrIdx = new Array();
	$("input:checkbox[name='chkIdx']:checked").each(function(e,val){		
		arrIdx.push($(this).val());		
	});
	
	$.ajax({
		type: "POST",
		url: "/webinar/delete_chkecked_application",
		data: {chkIdx:arrIdx, editMode:editMode},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg);
			applicationList('self');
			closePopup();
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function applicationExcel(){	
	$("#frmSearch").attr("action", "/admin/application_excel/").submit();	
}

function sendMassEmail(){
	
	var event_idx = $("#sch_1 > option:selected").val();
	if(event_idx < 0){
		alert ('행사를 선택해주십시오.');
		$("#sch_1").focus();
		return;
	}
	var postData = {event_idx:event_idx};

	$.ajax({
		type: "POST",
		url: "/webinar/admin_mass_email",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg, 2000);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function sendEmailInfo(email, event_idx){
	
	if(email.length==0 || event_idx.length==0){
		alert('필수정보가 누락 된 사전등록 내역입니다.');
		return false;	
	}
	var postData = {email:email, event_idx:event_idx};

	$.ajax({
		type: "POST",
		url: "/webinar/admin_send_email",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg);
			console.log(data.msg);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function sendMassSms(){
	
	var event_idx = $("#sch_1 > option:selected").val();
	if(event_idx < 0){
		alert ('행사를 선택해주십시오.');
		$("#sch_1").focus();
		return;
	}
	var postData = {event_idx:event_idx};
	
	$.ajax({
		type: "POST",
		url: "/webinar/admin_mass_sms",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg, 2000);
			$("#hdrSmsCnt").text(data.sms_count);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function sendSmsInfo(email, mobile, event_idx, sms_gb=1){
	
	if(email.length==0 || event_idx.length==0){
		alert('필수정보가 누락 된 사전등록 내역입니다.');
		return false;	
	}
	
	var postData = {email:email, mobile:mobile, event_idx:event_idx, sms_gb:sms_gb};

	$.ajax({
		type: "POST",
		url: "/webinar/admin_send_sms",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.message == "Success"){
				cmmShowMsg(data.message+' 잔여확인:'+data.data["AFTER_SMS_QTY"]+"건", 2500);
				$("#hdrSmsCnt").text(data.data["AFTER_SMS_QTY"]);
			} else {
				cmmShowMsg(data.message, 3000);
			}
			
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: visitList()
*	기능: 행사 참여현황 리스트
******************************************************************/
function visitList(type){	

	if(type=="self"){
		$("#page").val(1);
	}
	var postData = $("#frmSearch").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/visit_list/",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function visitExcel() {
	$("#frmSearch").attr("action", "/admin/visit_excel/").submit();
}



/******************************************************************
*	함수명: userList()
*	기능: 사용자 리스트
******************************************************************/
function userList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/admin/user_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: userSave()
*	기능: 사용자 저장
******************************************************************/
function userSave(editMode){
	var reqArr = ["userId", "userPw", "userNm"];
	var chkReq = false;
	
	if(editMode=="N"){
		$.each(reqArr, function(idx, item){
			if($.trim($("#"+item).val()).length == 0){
				cmmShowMsg ($("#"+item).prop("placeholder")+' 필수입력 누락입니다.');
				$("#"+item).focus();
				chkReq = true;
				return false;
			}			
		});
		
		if(chkReq){
			console.log('필수입력 누락');
			return;
		}
		if($.trim($("#userPw").val()) != $.trim($("#userPw_2").val())){
			cmmShowMsg('비밀번호가 일치하지 않습니다.');
			return;
		}
	}
	
	if(editMode=="U"){
		if($(".userPw").css("display")!="none"){
			if($.trim($("#userPw").val()).length == 0){
				cmmShowMsg('비밀번호를 입력하세요.');
				$("#userPw").focus();
				return;
			}
			if($.trim($("#userPw").val()) != $.trim($("#userPw_2").val())){
				cmmShowMsg('비밀번호가 일치하지 않습니다.');
				$("#userPw").focus();
				return;
			}
		}
		
		for(i=2; i<reqArr.length; i++){
			if($.trim($("#"+reqArr[i]).val()).length == 0){
				cmmShowMsg ($("#"+reqArr[i]).prop("placeholder")+' 필수입력 누락입니다.');
				$("#"+reqArr[i]).focus();
				return;
			}
		}
	}
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/admin/user_save/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			cmmShowMsg(data.msg, 1000);
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: userOpen()
*	기능: 사용자 상세보기
******************************************************************/
function userOpen(idxNo=-1){
	
//	var postData = $("#poFrm1").serialize();	
//	var postData = new FormData($("#frm1")[0]);
//	검색조건을 메인페이지에 저장
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/admin/user_open",
		data: {idxNo:idxNo},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: userList()
*	기능: 사용자 리스트
******************************************************************/
function memberList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/member/member_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: userOpen()
*	기능: 사용자 상세보기
******************************************************************/
function memberOpen(member_id=-1){
	
//	var postData = $("#poFrm1").serialize();	
//	var postData = new FormData($("#frm1")[0]);
//	검색조건을 메인페이지에 저장
	saveSearch();

	
	$.ajax({
		type: "POST",
		url: "/member/member_open",
		data: {member_id:member_id},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: userSave()
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
		url: "/member/member_save/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			memberOpen(data.member_id);
			if(data.template_code.length > 1){
				pushSystemMsg(data.member_id, data.template_code);
			}
			cmmShowMsg(data.msg, 1000);
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function pushSystemMsg(member_id, template_code){
	$.ajax({
		type: "POST",
		url: "/bizmsg/push_system_msg/",
		data: {member_id:member_id, template_code:template_code},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			console.log(data);
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: admChkUserId()
*	기능: 사용자 아이디 중복여부 확인
******************************************************************/
function admChkUserId(){
		
	if($.trim($("#userId").val()).length == 0) {
		alert("아이디를 입력하세요.");
		return;
	}
	
	var userId = $("#userId").val();
	
	$.ajax({	
		  type: "POST",
		  url: "/user/chk_user_duple",
		  data: {user_id:userId},
		  dataType: "json",
		  success: function(data){
			cmmShowMsg(data.msg);
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
function admChgUserPw(){
	var chgMod = $(".userPw").css("display");
	//암호변경 모드가 아님
	if(chgMod == "none"){
		$(".userPw").show();
		$("#btnChgPw").text('변경취소');
	} else {			
		$(".userPw").hide();
		$("#btnChgPw").text('암호변경');
	}
}

/******************************************************************
*	함수명: templateList()
*	기능: 템플릿 리스트
******************************************************************/
function templateList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/message/template_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function templateOpen(idx=-1){
	
//	var postData = $("#poFrm1").serialize();	
//	var postData = new FormData($("#frm1")[0]);
//	검색조건을 메인페이지에 저장
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/message/template_open",
		data: {idx:idx},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}



/******************************************************************
*	함수명: templateSave()
*	기능: 템플릿 저장
******************************************************************/
function templateSave(editMode){
	
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
		enctype: 'multipart/form-data',
		contentType : false,
		processData : false,
		url: "/message/template_save",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg);
			
			if(editMode != "D"){											
				templateOpen(data.rtn_idx);
			} else {
				templateList('main');
			}
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function biztalkLog(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/message/biztalk_log",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}


/******************************************************************
*	함수명: qLinkList()
*	기능: q링크 리스트
******************************************************************/
function qLinkList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/qlink/link_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: qLinkOepn()
*	기능: q링크 편집모드 전환
******************************************************************/
function qLinkOepn(idx){
	
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/qlink/link_open",
		data: {idx:idx},
		dataType: "json",
		success: function(data){
			$("#editMode").val("U");
			$("#idx").val(idx);
			$("#txt_title").val(data["title"]);
			$("#txt_target").val(data["target_url"]);
			$("#date_expire").val(data["expire_dt"]);
			$("input[name=rdo_useyn][value="+data["use_yn"]+"]").prop("checked", true);
			openPopup('#popInfo');
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function qLinkPopupReset(){
	$("#frm1")[0].reset();
}

/******************************************************************
*	함수명: qLinkSave()
*	기능: q링 저장
******************************************************************/
function qLinkSave(){
	
	var editMode = $("#editMode").val();
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/qlink/link_save/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			cmmShowMsg(data.msg, 1000);
			if(editMode=="U"){
				qLinkList("main");
			} else {
				qLinkList("self");
			}
			closePopup();
		},
		error: function(request, status, err){
			console.log(request+'/'+status+'/'+err);
			return;
		}
	});
}

/******************************************************************
*	함수명: massEmailList()
*	기능: q링크 리스트
******************************************************************/
function massEmailList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/massemail/mass_email_list",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function massEmailOpen(idxNo){
	
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/massemail/mass_email_open",
		data: {idxNo:idxNo},
		dataType: "html",
		success: function(data){			
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function massEmailSave(editGb){
	

	if(editGb=="D"){
		if(!confirm('템플릿을 삭제하시겠습니까?')){
			return;
		}
	}
	
	$("#editMode").val(editGb);
	
	if(editGb=="U"){
		$("#mailBody").val(CKEDITOR.instances.mailBody.getData());
	}
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/massemail/mass_email_save",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			cmmShowMsg(data.msg, 1000);
			if(editGb=="U"){
//				massEmailOpen($("#idxNo").val());
			} else {
				massEmailList("self");
			}
			closePopup();
		},
		error: function(request, status, err){
			console.log(request+'/'+status+'/'+err);
			return;
		}
	});
}

function massEmailSend(){
	
	$("#mailBody").val(CKEDITOR.instances.mailBody.getData());
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/massemail/mass_email_send",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			
			cmmShowMsg(data.msg, 1000);
			
		},
		error: function(request, status, err){
			console.log(request+'/'+status+'/'+err);
			return;
		}
	});
}

function massEmailReport(idxNo){
	
	saveSearch();
	
	$.ajax({
		type: "POST",
		url: "/massemail/mass_email_report",
		data: {idxNo:idxNo},
		dataType: "html",
		success: function(data){
			$('#popUtmList').html(data);
			openPopup("#popReport")
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function massEmailExcel(idxNo) {
	$("#idxNo").val(idxNo);
	$("#excelFrm").attr("action", "/massemail/excel_mass_email/").submit();
}

var previewPop;

function massPreview() {
	
	if ( !previewPop || previewPop.closed ) {
		previewPop = window.open('','preView','width=960, height=768, scrollbars=yes');
		previewPop.document.write($("#mailBody").val());
	} else {
		previewPop.close();		
		previewPop = window.open('','preView','width=960, height=768, scrollbars=yes');
		previewPop.document.write($("#mailBody").val());
	}
}

function utmList(type){
	
	//컨텐츠 상세화면에서 리스트로 전환 할 때, 메인에 저장 된 검색 값으로 리스트 복귀
	if(type == "main"){
		var postData = $("#mainSearch").serialize();
	} else {
		//리스트 화면에서 검색을 시도하면 페이지 값을 1로 설정하고 검색. 
		//페이지 이동 시엔 type 변수를 null로 처리. 검색 조건은 유지하고 페이지 값은 gpPage를 이용하여 변경 
		if(type=="self"){
			$("#page").val(1);
		}
		var postData = $("#frmSearch").serialize();
	}
	
	$.ajax({
		type: "POST",
		url: "/admin/utm_report",
		data: postData,
		dataType: "html",
		success: function(data){
			$('#contents').html(data);
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function utmDashboard(){
	
	let dashboadWin = window.open('', 'dashboard');
	let frm = document.getElementById("frmSearch");
	frm.action = "/admin/utm_dashboard";
	frm.target = "dashboard";
	frm.submit();
//	$("#frmSearch").action("/admin/utm_dashboard").target("dashboard").submit();
	
	
}


function openPopup(obj) {
	$(".blind").fadeIn(250);
	$(".popup").hide();
	$(obj).show();
}

function closePopup(obj=''){
	if(obj == ''){
		$(".popup").hide();	
	} else {
		$(obj).hide();
	}
	
	$(".blind").hide();
}