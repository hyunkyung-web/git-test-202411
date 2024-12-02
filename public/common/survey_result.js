$(function () {
	
	window.onresize = function(event){
		location.reload();
	}
	
	$("li").click(function(){    	
    	var survey_idx = $("#survey_idx").val();
    	var question_idx = $(this).val();
    	
    	location.href="/survey/result/"+survey_idx+"/"+question_idx;
	});
	
});