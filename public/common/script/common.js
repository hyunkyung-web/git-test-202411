

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
