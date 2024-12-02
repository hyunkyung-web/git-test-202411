$(function(){
	
	//	메세지 전송
	$(document).on("click", "#btnSelectImg", function(){
		$(".blind").show();
		$(".pop_img").show();			
	});
	
	$(document).on("click", "#btnPopClose", function(){	
		$(".pop_img").hide();
		$(".blind").hide();					
	});
	
	$(document).on("click", "#btnImgClose", function(){	
		imgUrlView('');
	});
	
	$(document).on("click", ".pop_img div > img", function(){	
		imgUrlView(this.src);
//		cmmShowMsg("이미지를 불러왔습니다.", 500);
		$(".pop_img").hide();
		$(".blind").hide();	
	});
	
	$(document).on("click", "input[name=msg_type]", function(){
		msgPushOpen();
	});
	
	$(document).on("change", "#msg_profile_type", function(){
		msgPushOpen();
	});
	
	//	템플릿관리
	$(document).on("change", "#profile_key", function(){
		$("#profile_type").val($("#"+this.id+" option:selected").text());
	});
	
});

function getTest(){
	
	fetch("https://jsonplaceholder.typicode.com/posts", {		
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({
			title: "Test",
			body: "I am testing!",
		    userId: 1,
		}),
	})
	.then((response) => response.json())
	.then((data)=>console.log(data));
	
}

function getTest_2(){
	
	var setData;
	
	
	$.ajax({
		type: "POST",
		url: "https://jsonplaceholder.typicode.com/posts",		
		dataType: "json",
		data: {
			title: "Test",
			body: "I am testing!",
		    userId: 1,
		},
		beforeSend:function(){			
		},
		success: function(data){
			console.log(data);
		},
		error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		}
	});
}

function testSms(){
	
	var restUrl = "https://rest.surem.com/sms/v1/json";
	var postData = {usercode:"dwave2014", deptcode:"R4-N2Z-56", messages:[{to:"01029942313"}], text: "안녕하세요. 닥터웨이브 테스트 문자입니다.", from: "025402256"};
	
	$.ajax({
		type: "POST",
		url: restUrl,		
		dataType: "json",
		data: postData,
		beforeSend:function(){			
		},
		success: function(data){
			console.log(data);
		},
		error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		}
	});
}

function testSms_2(){
	
	fetch("https://rest.surem.com/sms/v1/json", {		
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		data: JSON.stringify({
			usercode: "dwave2014",
			deptcode: "R4-N2Z-56",
			messages:[
				{to:"01029942313"}
			],
			text: "안녕하세요. 닥터웨이브 테스트 문자입니다.",
			from: "025402256"
		}),
	})	
	.then((response) => response.json())
	.then((data)=>console.log(data));
//	.then((response) => console.log(response));
	
}

function sureBizMsg(){
	
	let postData = $("#frm_talk").serialize();
	
	$.ajax({
		type: "POST",
		url: "/message/send_kakao",		
		dataType: "json",
		data: postData,
		beforeSend:function(){			
		},
		success: function(data){
			alert(data.msg);
		},
		error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		}
	});
}

function msgPushOpen(){
	
	let msgType= $("input[name=msg_type]:checked").val();
	let profile_type = $("#msg_profile_type option:selected").val();	
	
	$.ajax({
		type: "POST",
		url: "/message/biztalk_sender",
		data: {profile_type:profile_type, msg_type:msgType},
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

function dauBizMsg(){
	
	let postData = new FormData($("#frm_talk")[0]);
	
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		contentType : false,
		processData : false,
		url: "/bizmsg/push_contents_msg",		
		dataType: "json",
		data: postData,
		beforeSend:function(){			
		},
		success: function(data){
			alert(data.msg);
		},
		error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		}
	});
}


function msgBtnAdd(){
	
	let btnStr='';
	let btnCnt = $("#ftButton tr").length/2;
	
	if(btnCnt == 5){		
		cmmShowMsg("버튼은 최대 5개까지만 생성 할 수 있습니다.");
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


function imgUrlView(imgUrl) {

	$('#imgPreview img').remove();
	$(".btn_img_close").hide();
	$("#img_url").val("");
	
	let parentWidth = $("#imgPreview").width();
	
	if(imgUrl != ""){
		let prevImg = '<img src="'+imgUrl+'" style="width: '+parentWidth+'px" />';
		$("#imgPreview").append(prevImg);
		$(".btn_img_close").show();
		$("#img_url").val(imgUrl);
	}
}

function imgPreview(upFile) {
	
	let imgWidth = 0;
	let imgHeight = 0;
	let fileSize = 0;
	let fileExt = $("#"+upFile.id).val().split(".").pop();
	
	const widthRule = 800;
	const heightRule = 400;
	const sizeRule = 500;
	const ruleMsg = "가로*세로("+widthRule+"px * "+heightRule+"px), 파일크기: "+sizeRule+"KB 이하만 업로드 가능합니다.";
	const extRule = ["png", "jpg"];
	
	if(upFile.files && upFile.files[0]) {
		
		if($.inArray(fileExt, extRule)!=1){
			$('#imgPreview img').remove();
			$("#file_img").val("");
			alert('PNG, JPG 타입의 파일만 업로드가 가능합니다.');		
			return;
		}
		
		var reader = new FileReader();
		reader.onload = function(e){
			
			let prevImg = '<img src="'+e.target.result+'" style="width:100%;" />';
			if ( $('#imgPreview img').length > 0 )  {
				$('#imgPreview img').remove();
			}
			$("#imgPreview").append(prevImg);
			
			fileSize = Math.round(e.total/1024);
			
			//선택 한 이미지 파일의 가로*세로 길이 구하기
			let tmpImg = new Image();
			tmpImg.src = e.target.result;			
			tmpImg.onload = function(){
				imgWidth = this.width;
				imgHeight = this.height;
				
				if(imgWidth>widthRule || imgHeight>imgHeight || fileSize>sizeRule){
					alert(ruleMsg);
				}
			}						
		}
		
		reader.readAsDataURL(upFile.files[0]);
	} else {
		$('#imgPreview img').remove();
	}
}

var checkedType = "at";

function setMessenger(type){
	
	$(".item").hide();
	$("tfoot tr").remove();
	$(".item."+type).show();
	
	if(type=="ft"){
		$("#talk_msg").val("");
		$("#btn_type").val("");
		$("#btn_name").val("");
		$("#btn_link").val("");		
	} else {
//		$('#imgPreview img').remove();		
		if(checkedType!=type){
			$("#template_code").val("");	
		}
	}
	
	checkedType = type;
}

function getTemplateMsg(idx){
	
	if(idx==""){
		return;
	}
	
	$.ajax({
		type: "POST",
		url: "/message/get_message",		
		dataType: "json",
		data: {idx:idx},
		beforeSend:function(){			
		},
		success: function(data){
			
			$("#ftButton tr").remove();
			
			$("#talk_msg").val(data.msg);
			$("#img_url").val(data.img_url);
			$("#img_link").val(data.img_link);
			if(data.btn_data!=""){
				$("#ftButton").append(data.btn_data);
			}
		},
		error: function(request, status, err){
			alert("Server Error Occured:"+ err);
			return;
		}
	});
}

function commonShowMsg(msg, runtime=2000){	
	$(".common_msg").text(msg).show();
	setTimeout(function(){		
		$(".common_msg").text("").hide();
	}, runtime)
} 




