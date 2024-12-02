$(function () {
	
//	window.onresize = function(event){
//		location.reload();
//	}
	
    $("li").click(function(){
    	
    	var pNum = $(this).prop("title");
    	var pClass = $(this).prop("class");
    	var questionType = $("#question_type_"+pNum).val();
    	var chkVal = [];
    	
    	if(questionType=="radio"){
    		$("."+pClass).removeClass("click");
    		$("#answer_idx_"+pNum).val('');
    		
    		$("#answer_idx_"+pNum).val($(this).val());
    		$(this).addClass("click");
    	}else if(questionType=="check"){    		
    		if(pClass.indexOf("click")>-1){
    			$(this).removeClass("click");
    		}else{
    			$(this).addClass("click");
    		}
    		
        	$("li.click").each(function(e, item){
        		chkVal.push($(this).val());
        	});
        	
        	$("#answer_idx").val(chkVal);
    	} 
    });
    
    $(".menu_2 div").click(function(){
        var video_id = $(this).attr("class");
        fncOpenPop('#'+video_id);        
    });
    $(".menu_qna").click(function(){
        fncOpenPop('#qna');        
    });
    $("#btn_save").click(function(){
    	fncSave();
    });
    
    $("#btn_save_single").click(function(){
    	fncSaveSingle();
    });
    
});

function fncSave(){
	
	var reqArr = ["txt_name", "txt_biznm", "txt_telno", "txt_email_1", "txt_email_2"];
	var chkReq = false;
	var alertMsg;
	
//	$.each(reqArr, function(idx, item){
//		if($.trim($("#"+item).val()).length == 0){
//			alertMsg = '['+$("#"+item).prop("title")+'] 필수입력 누락입니다.';
//			$("#"+item).focus();
//			chkReq = true;
//			return false;
//		}
//	});
//	
//	if(chkReq){
//		alert(alertMsg);
//		return;
//	}
//	
//	if($("#txt_email_2").val()=="direct"){
//		if($.trim($("#txt_email_etc").val()).length == 0){
//			alert('나머지 이메일 주소를 입력하세요');
//			$("#txt_email_etc").focus();
//			return;
//		}
//	}
//	
//	if(!$("#chk_agree").is(":checked")){
//		alert("개인정보 활용동의에 동의가 필요합니다.")
//		return;
//	}
	
//	var postData = $("#frm1").serialize();
//	
//	$.ajax({
//		type: "POST",
//		url: "/survey/data_save",
//		data: postData,
//		dataType: "json",
//		beforeSend:function(){
//		},
//		success: function(data){
//		},
//		error: function(request, status, err){
//		}
//	});
	
	
	var postData = new FormData($("#frm1")[0]);
	 
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		contentType : false,
        processData : false,
		url: "/survey/data_save",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.result=="ok"){
				alert('응답해주셔서 감사합니다.')
				location.href="/survey/result";
			} else {
				alert('오류가 발생했습니다.\n\n'+data.msg);
			}
		},
		error: function(request, status, err){
			alert('질문에 대한 답변이 누락되었습니다.');
		}
	});
}

function fncSaveSingle(){
	
	var reqArr = ["txt_name", "txt_biznm", "txt_telno", "txt_email_1", "txt_email_2"];
	var chkReq = false;
	var alertMsg;
	
//	$.each(reqArr, function(idx, item){
//		if($.trim($("#"+item).val()).length == 0){
//			alertMsg = '['+$("#"+item).prop("title")+'] 필수입력 누락입니다.';
//			$("#"+item).focus();
//			chkReq = true;
//			return false;
//		}
//	});
//	
//	if(chkReq){
//		alert(alertMsg);
//		return;
//	}
//	
//	if($("#txt_email_2").val()=="direct"){
//		if($.trim($("#txt_email_etc").val()).length == 0){
//			alert('나머지 이메일 주소를 입력하세요');
//			$("#txt_email_etc").focus();
//			return;
//		}
//	}
//	
//	if(!$("#chk_agree").is(":checked")){
//		alert("개인정보 활용동의에 동의가 필요합니다.")
//		return;
//	}
	
//	var postData = $("#frm1").serialize();
//	
//	$.ajax({
//		type: "POST",
//		url: "/survey/data_save",
//		data: postData,
//		dataType: "json",
//		beforeSend:function(){
//		},
//		success: function(data){
//		},
//		error: function(request, status, err){
//		}
//	});
	
	
	var postData = new FormData($("#frm1")[0]);
	 
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		contentType : false,
        processData : false,
		url: "/survey/data_save",
		data: postData,
		dataType: "json",
		beforeSend:function(){
		},
		success: function(data){
			if(data.result=="ok"){
				if($("#next_seq").val()==-1){
					alert('설문에 참여해주셔서 감사합니다.');
					return;
				}else {
					location.href="/survey/single/"+$("#survey_idx").val()+"/"+$("#next_seq").val();	
				}				
			} else {
				alert('오류가 발생했습니다.\n\n'+data.msg);
			}
		},
		error: function(request, status, err){
		}
	});
}


function chkEmail(chkVal){	
	var rtnVal = chkVal.replace(/[^A-Z|\.\_\-|a-z|0-9]/gi, "");
	$("#txt_email_1").val(rtnVal);
}

function chkTel(chkVal){
	var rtnVal = chkVal.replace(/[^0-9|\-]/gi, "");
	$("#txt_telno").val(rtnVal);
}

function chkDomain(chkVal){
	if(chkVal == "direct"){
		$("#etc_domain").css("display", "block");
	} else {
		$("#etc_domain").css("display", "none");
	}
}


