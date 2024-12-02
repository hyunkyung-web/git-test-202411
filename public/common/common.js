function cmmLogin(target, type){
	
	if(type=="login"){		
		if ( $.trim($("#txtUserId").val()).length == 0 ) {
			alert ('아이디를 입력하세요');
			$("#txtUserId").focus();
			return;					
		}
		if ( $.trim($("#txtUserPw").val()).length == 0 ) {
			alert ('비밀번호를 입력하세요');
			$("#txtUserPw").focus();
			return;					
		}				
	}

	postUrl = "/user/login/"+target+"/"+type;
		
	switch(target){
		case "admin":
			targetUrl = "/admin";
			rootUrl = "/admin/login"; 
			break;
		default:
			targetUrl = "/";
			rootUrl = "/";
			break;
	}
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: postUrl,
		data: postData,
		dataType: "json",
		beforeSend:function(){			
		},
		success: function(data){
			console.log(data);			
			if(data.result=="OK_MATCH"){
				location.href=targetUrl;				
			} else if(data.result=="OK_LOGOUT"){
				location.href=rootUrl;
			} else {
				alert(data.msg);
				return;
			}
		},
		error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		}
	});
}

/******************************************************************
*	함수명: cmmShowMsg()
*	기능: 데이터처리 결과 보여주기
******************************************************************/
function cmmShowMsg(str, runTime=1000){
	
	$(".system_msg > span").text(str).show();
	
	setTimeout(function(){
		$(".system_msg").show();	
	}, 0);
	setTimeout(function(){
		$(".system_msg").hide();	
	}, runTime);
}

/******************************************************************
*	함수명: joinWebinar()
*	기능: 웨비나 참여하기
******************************************************************/
function joinWebinar(type="zoom"){
	
	if(type != "zoom"){
		var actUtl = "/webinar/stream";	
	} else {
		var actUtl = "/webinar/video";	
	}
	
	if($("#event_access").val()=="pass"){
		$("#videoFrm").attr("action", actUtl).submit();	
	} else{
		if($("#ref_1").val() != ""){
			$("#videoFrm").attr("action", actUtl).submit();	
		} else {
			cmmOpenPop('#popup_email');	
		}
	}
	
/*	
	var newTab = window.open("about:blank", "winVideo");
	$("#videoFrm").attr("action", actUtl).attr("target", "winVideo").submit();
*/	
	
}

/******************************************************************
*	함수명: goPage()
*	기능: 리스트 페이징에서 페이지값만 검색폼으로 넘기기
******************************************************************/
function goPage(page){
	$("#page").val(page);
}

/******************************************************************
*	함수명: cmmRecordExit()
*	기능: 1분 단위로 퇴장로그 저장
******************************************************************/
function cmmRecordExit(eventGb="stream"){
	
//	console.log(eventGb);
	
	var postData = $("#videoFrm").serialize();
	//eventStatus -> 0: 행사상태, 1: 행사URL 
	var eventStatus = cmmGetEventStatus_2();
	
	if(eventGb=="stream"){
		var videoSrc = $("#ifrVideo").attr("src");	
	} 		
	
	if(eventStatus[0] != "action"){		
		if(eventStatus[0] == "close"){
			setTimeout(function(){
				cmmShowMsg('행사가 종료되었습니다. 감사합니다.', 3000);	
			}, 500);		
		} else {
			setTimeout(function(){
				cmmShowMsg('행사가 준비 중입니다. 잠시 후에 다시 시도해주세요.', 3000);	
			}, 500);
		}
		setTimeout(function(){
			var rtnUrl = "/webinar/info?event_idx="+$("#event_idx").val()+"&inflow_cd="+$("#inflow_cd").val()+"&ref_1="+$("#ref_1").val()+"&ref_2="+$("#ref_2").val();
			if($("#ref_1").val() != ""){
				rtnUrl += "&pass_key="+$("#pass_key").val();
			}
			location.href = rtnUrl
			return false;
		}, 5000);
	}
	if(eventGb=="stream"){
		if(eventStatus[0] == "action" && videoSrc != eventStatus[1]){				
			$("#ifrVideo").attr("src", eventStatus[1]);
			location.reload();
			return;		
		}
	}
	
	$.ajax({
		type: "POST",
		url: "/webinar/save_exit_log/",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			return;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

/******************************************************************
*	함수명: cmmSaveQuestion()
*	기능: 질문등록
******************************************************************/
function cmmSaveQuestion(inputGb=''){
	
	var event_idx = inputGb=='admin' ? $("#sch_1").val() : $("#event_idx").val();
	var question = $("#txtQuestion").val();
	var ref_1 = $("#ref_1").val();
	
	console.log(ref_1);
	
	
	if(inputGb == "admin" && (event_idx.length==0 || event_idx < 0)){
		$("#sch_1").focus();
		cmmShowMsg('질문을 등록 할 행사를 선택하세요.');				
		cmmClosePop();
		return;
	}
	
	if($.trim(question).length == 0){
		$("#txtQuestion").focus();
		cmmShowMsg('질문을 등록해주세요');		
		return;
	}
	
	$.ajax({
		type: "POST",
		url: "/webinar/save_qna",
		data: {event_idx:event_idx, question:question, ref_1:ref_1},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			cmmShowMsg(data.msg);
			$("#txtQuestion").val('');
			if(inputGb=="admin"){
				cmmClosePop();
				eventQnaList('self');
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
*	함수명: cmmGetQna()
*	기능: 노츨 질문 가져오기
******************************************************************/
function cmmGetQna(){
	
	var eventIdx = $("#event_idx").val();
	
	$.ajax({
		type: "POST",
		url: "/webinar/get_qna",
		data: {event_idx:eventIdx},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.result=='ok_data'){
				$(".video_text").fadeIn();
				$("#videoText").text('Q: '+data.question);	
			} else {
				$(".video_text").fadeOut();
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
*	함수명: cmmChkRequire()
*	기능: 문의사항, 사전등록 필수입력 확인하여 버튼색상 변경
******************************************************************/
function cmmChkRequire(frmType){
	//frmType(1:사전등록, 2:문의사항)
	
	$(".btnCmm.preReg_submit").removeClass("enable_btn");
	let chkSaveTel = $("#chkSaveTel").val();
	
	var reqArr = [];
	
	if(frmType==1){
		reqArr = ["txtName", "txtBizNm", "txtDept", "txtEmail"];
		if(chkSaveTel=="Y"){
			reqArr.push("txtMob");
		}
	} else if(frmType==2){
		reqArr = ["cstName", "cstEmail", "cstQuestion"];		
	} else if(frmType==3){
		reqArr = ["chkEmail"];
	} else {
		return;
	}
	var chkReq = false;
	
	$.each(reqArr, function(idx, item){
		if($.trim($("#"+item).val()).length == 0){
			chkReq = true;
			return false;
		}
	});
	
	if(!chkReq){		
		//필수입력 모두 입력
		$(".btnCmm.preReg_submit").addClass("enable_btn");
		return;
	}
}


/******************************************************************
*	함수명: cmmSaveApplication()
*	기능: 사전등록 저장
******************************************************************/
function cmmSaveApplication(){
	let chkSaveTel = $("#chkSaveTel").val();
	var reqArr = ["txtName", "txtBizNm", "txtDept", "txtEmail"];
	var chkReq = false;
	var eventStat = $("#event_status").val();
	var meetingType = $("#meeting_type").val();
	let chkEmail = cmmValidEmail($("#txtEmail").val());
	
	if(chkSaveTel=="Y"){
		reqArr.push("txtMob");
	}
	
	$.each(reqArr, function(idx, item){
		if($.trim($("#"+item).val()).length == 0){
			alert ('필수입력 누락입니다.');
			$("#"+item).focus();
			chkReq = true;
			return false;
		}
	});
	if(chkReq){
		console.log('필수입력 누락');
		return;
	}

	if(!chkEmail){
		alert('올바른 이메일주소가 아닙니다.');
		return;
	}
	
	if(!$("#chkOptin").is(":checked")){
		alert ('개인정보 활용동의에 확인이 필요합니다.');
		return;
	}
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/webinar/save_application",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){			  
			cmmShowMsg(data.msg, 2500);	
			cmmSendEmailToMember();
			
			if(eventStat=="action"){
				$("#ref_1").val($("#txtEmail").val());
				joinWebinar(meetingType);
			} else {
				if($("#txtMob").val().length >= 10){
					cmmSendMmsToMember();
				} else{
					$("#frm1")[0].reset();	
				}
				cmmClosePop();
			}
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function cmmSendEmailToMember(){
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/webinar/send_email_to_member",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			console.log(data.msg);
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}


function cmmSendMmsToMember(){
	
	var postData = $("#frm1").serialize();
	
	$.ajax({
		type: "POST",
		url: "/webinar/send_mms_to_member",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			$("#frm1")[0].reset();
//			cmmClosePop();
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
function cmmSaveFaq(){
	var reqArr = ["cstName", "cstEmail", "cstQuestion"];
	var chkReq = false;

	$.each(reqArr, function(idx, item){
		if($.trim($("#"+item).val()).length == 0){
			alert ('필수입력 누락입니다.');
			$("#"+item).focus();
			chkReq = true;
			return false;
		}
	});
	
	if(chkReq){
		console.log('필수입력 누락');
		return;
	}
	
	var postData = $("#frm2").serialize();
	
	$.ajax({
		type: "POST",
		url: "/webinar/customer_save_faq",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
//			alert(data.msg);
//			console.log(data);
			cmmShowMsg(data.msg, 2500);
			$("#frm2")[0].reset();
			cmmClosePop();			
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}
/******************************************************************
*	함수명: cmmChkReg()
*	기능:  사전등록 여부 확인
******************************************************************/
function cmmChkReg(){
	
	var eventIdx = $("#event_idx").val();
	var chkEmail = $("#chkEmail").val();
	var meetingType = $("#meeting_type").val();
	let validEmail = cmmValidEmail(chkEmail);
	
	if($.trim($("#chkEmail").val()).length == 0){
		alert('이메일을 입력해주세요.')
		$("#chkEmail").focus();
		return;
	}
	
	if(!validEmail){
		alert('올바른 이메일 주소가 아닙니다.');
		return;
	}
	
	$.ajax({
		type: "POST",
		url: "/webinar/chk_application/",
		data: {event_idx:eventIdx, email:chkEmail},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.result=='ok_data'){
				$("#ref_1").val(chkEmail);
				joinWebinar(meetingType);
			} else {
				cmmClosePop();
				cmmOpenPop("#popup_prereg");
				$("#txtEmail").val(chkEmail);
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
*	함수명: cmmGetEventStatus()
*	기능: 대기실에서 행사의 상태값을 1분 간격으로 체크하여 상태값 변경 시 새로고침 동작
******************************************************************/
function cmmGetEventStatus(){
	
	var eventIdx = $("#event_idx").val();
	var onStatus = $("#event_status").val();
	
	$.ajax({
		type: "POST",
		url: "/webinar/get_event_status/",
		data: {event_idx:eventIdx},
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.result=='ok_data'){
				//웨비나 대기실 입장시의 상태값과 실시간 상태값이 다를 경우 화면 새로고침 발생시킴
				if(onStatus != data.status){
					location.reload();
				}
			} else {
				console.log('not_data');
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
*	함수명: cmmGetEventStatus_2()
*	기능: 강의화면에서 이벤트 상태를 확인하여 상태가 종료이면 페이지 이탈시키기
******************************************************************/
function cmmGetEventStatus_2(){
	
	var eventIdx = $("#event_idx").val();
	var eventStatus = [];
	
	$.ajax({
		type: "POST",
		url: "/webinar/get_event_status/",
		data: {event_idx:eventIdx},
		dataType: "json",
		async: false,
		beforeSend:function(){
		},
		success: function(data){
			eventStatus[0] = data.status;
			eventStatus[1] = data.meeting_url;
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
	
	return eventStatus;
}

function cmmValidAuthKey(){	
	
	let event_idx = $("#event_idx").val();
	let auth_phone = $("#auth_phone").val();
	let auth_key = $("#auth_key").val();
	
	$.ajax({
		type: "POST",
		url: "/webinar/valid_authkey/",
		data: {event_idx:event_idx, auth_phone:auth_phone, auth_key:auth_key},
		dataType: "json",
		async: false,
		beforeSend:function(){
		},
		success: function(data){
			if(data.result!="ok"){
				cmmShowMsg(data.msg);	
			} else {
				document.write(data.msg);
			}
			
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function cmmAuthSms(smsGb){	
	
	let event_idx = $("#event_idx").val();
	let auth_phone = $("#auth_phone").val();
	
	$.ajax({
		type: "POST",
		url: "/webinar/send_authkey/",
		data: {event_idx:event_idx, auth_phone:auth_phone},
		dataType: "json",
		async: false,
		beforeSend:function(){
		},
		success: function(data){
			if(data.result == "ok"){
				cmmShowMsg(data.msg);
				readyInput = setInterval(killTime, 1000);	
			} else {
				cmmShowMsg(data.msg);
				console.log(data.msg);
			}
		},
		error: function(request, status, err){
			console.log(err);
			return;
		}
	});
}

function killTime(){
	let maxTime = 300;
	let remain_time = $("#time_val").text();
	$("#time_msg").css("display", "inline-block");
	$("#btn_callauth").css("display", "none");
	if(remain_time==""){
		$("#time_val").text(maxTime);
	} else {
		if(remain_time>1){
			$("#time_val").text(remain_time-1);	
		} else {			
			$("#time_msg").css("display", "none");
			$("#btn_callauth").css("display", "inline-block");
			$("#time_val").text(maxTime);
			clearInterval(readyInput);
		}
	}
	
}



/******************************************************************
*	함수명: cmmOpenPop()
*	기능: 팝업 열기
******************************************************************/
function cmmOpenPop(obj){
	$('.blind').css('display', 'block');
	$(obj).css("display", "block");
	//$('html').scrollTop(0);
	$(obj).css({
        top: ($(window).height() - $(obj).outerHeight()) / 2 + $(window).scrollTop() + "px",
     });
}
/******************************************************************
*	함수명: cmmClosePop()
*	기능: 팝업 닫기
******************************************************************/
function cmmClosePop(obj=''){	
	if(obj == ''){
		$(".pop").css("display", "none");
		$(".popup").css("display", "none");
	} else {
		$(obj).css("display", "none");
	}
	$(".blind").css("display", "none");
}

function cmmOnlyNumber(obj){
	$("#"+obj).val( $("#"+obj).val().replace( /[^0-9]/g, '' ));
}

function cmmNumberComma(obj){
	$("#"+obj).val( $("#"+obj).val().replace( /[^0-9\,]/g, '' ));
}

function cmmValidEmail(email){
	let regex = new RegExp("([!#-'*+/-9=?A-Z^-~-]+(\.[!#-'*+/-9=?A-Z^-~-]+)*|\"\(\[\]!#-[^-~ \t]|(\\[\t -~]))+\")@([!#-'*+/-9=?A-Z^-~-]+(\.[!#-'*+/-9=?A-Z^-~-]+)*|\[[\t -Z^-~]*])");
	return(regex.test(email));
}

function cmmValidHandPhone(phone){
	let regex = new RegExp("01[016789]-[^0][0-9]{3,4}-[0-9]{4}");
	return(regex.test(phone));
}

function chkCookie() {
	
	let userCookie = document.cookie;

	var arrCookie = new Array();
	var cashId = "";
	var cashPassword = "";	

	arrCookie = userCookie.split("; ");

	for (i=0; i<=arrCookie.length-1; i++){		
		var chkVal = arrCookie[i].split("=");

		if (chkVal[0] == "user_id"){
			cashId = chkVal[1];
		}
		if (chkVal[0] == "user_pw"){
			cashPassword = chkVal[1];
		}
	}

	if (cashId.length > 0) {		
		$("#txtUserId").val(cashId);
	}
	if (cashPassword.length > 0) {		
		$("#txtUserPw").val(cashPassword);
	}
	
}
