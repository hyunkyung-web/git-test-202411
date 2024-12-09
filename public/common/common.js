

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
