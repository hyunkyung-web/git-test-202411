

function adjustHeight(obj) {
  var textEle = $(obj);
  $(obj)[0].style.height = 'auto';
  var textEleHeight = textEle.prop('scrollHeight');
  textEle.css('height', textEleHeight);
};

/******************************************************************
*	함수명: cmmOpenPop()
*	기능: 팝업 열기
******************************************************************/
function cmmOpenPop(obj){
	$('.blind').css('display', 'block');
	$(obj).css("display", "block");
	//$('html').scrollTop(0);
//	$(obj).css({
//        top: ($(window).height() - $(obj).outerHeight()) / 2 + $(window).scrollTop() + "px",
//     });
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

function cmmOnNumber(obj){
	$(obj).val( $(obj).val().replace( /[^0-9]/g, '' ));
}

function cmmOnComma(obj){
	$(obj).val( $(obj).val().replace( /[^0-9\,]/g, '' ));
}

function cmmOnEmail(obj){
	var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;	
	if(!regex.test($(obj).val())){
		alert('이메일 주소 형식이 잘못되었습니다. 확인 후 다시 입력해주세요.');
		return;
	}
}

function cmmValidEmail(objValue){
	
	var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

	return(regex.test(objValue));
}

function cmmValidHandPhone(phone){
	let regex = new RegExp("01[016789]-[^0][0-9]{3,4}-[0-9]{4}");
	return(regex.test(phone));
}


/******************************************************************
*	함수명: setCookie()
*	기능: 쿠키저장(쿠키명, 쿠키값, 보존기간)
******************************************************************/
function setCookie(name, value, expiredays) {
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays )
	document.cookie = name+"=" + encodeURIComponent(value) + "; expires=" + todayDate.toGMTString() + ";"
//	alert ('쿠키저장 완료');
}


/******************************************************************
*	함수명: unSetCookie()
*	기능: 쿠키해제
******************************************************************/
function unSetCookie(name) {

	document.cookie =  name+"=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
//	document.cookie =  "sampleId=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
//	document.cookie =  "sampleName=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
//	alert ('쿠키해제 완료');
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

function cmmShowMsg(msgStr, runTime=1000){

	$(".system_msg > span").text(msgStr).show();
	
	setTimeout(function(){
		$(".system_msg").show();	
	}, 0);
	setTimeout(function(){
		$(".system_msg").hide();	
	}, runTime);
	
}

//텍스트를 클립보드에 복사하기
function copyToClipboard(e) {
	
	var copy_text =  $(e).data("copy");
		
    navigator.clipboard.writeText(copy_text) // 복사하기
        .then(() => {
        	cmmShowMsg('클립보드에 복사되었습니다.');
//            console.log('클립보드에 복사되었습니다.');
        })
        .catch(err => {
            console.error('클립보드 복사에 실패했습니다:', err);
        });
}


