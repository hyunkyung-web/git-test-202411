$(function() {
    //header
    $(".menu_ham").click(function () {
        $(".menu").slideToggle();
        $(".search").slideToggle();
        $(".menu_ham").toggleClass("active");
    });
    $(".menu_item2 >a").click(function () {
        $(".dropdown").slideToggle();
    });
    $(window).resize(function () {
//        location.reload();
    });
    //btn search
    $(".btn_search").click(function () {
        schWebinar();
        return;
    });
    $("#input1").keydown(function (e) {
        if (e.keyCode == 13) {
            schWebinar();
            return;
        }
    });
    
    $(".btn_slide").click(function(e){    	
    	var btnGb = $(this).attr("class").replace("btn_slide ", "");
    	var slideTotalCnt = getSlideCount();
    	
    	if(btnGb=="right"){
    		if(slideNum+1 <= slideTotalCnt) {
    			slideNum++; 
    		} else {
    			//마지막 슬라이드에서 1번 슬라이드로 되돌리기
    			moveSlideEnd(1);
    			slideNum = 1;
    		}
    	} else {
    		if(slideNum > 1) {
    			slideNum--; 
    		} else {
    			//첫번째 슬라이드에서 마지막 슬라이드로 이동
    			moveSlideEnd(slideTotalCnt);
    			slideNum = slideTotalCnt;
    		}
    	}
    	moveSlide(slideNum);
    });
    
    $(".event_main").swipe({    	
        //Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
        	
        	var slideTotalCnt = getSlideCount();
        	
        	if(direction=="left"){
        		
        		if(slideNum+1 <= slideTotalCnt) {
        			slideNum++; 
        		} else {
        			//마지막 슬라이드에서 1번 슬라이드로 되돌리기
        			moveSlideEnd(1);
        			slideNum = 1;
        		}
            }
            else if(direction=="right"){
            	if(slideNum > 1) {
        			slideNum--; 
        		} else {
        			//첫번째 슬라이드에서 마지막 슬라이드로 이동
        			moveSlideEnd(slideTotalCnt);
        			slideNum = slideTotalCnt;
        		}
            }
        	moveSlide(slideNum);
        }
    });
    
//    $(".event_slide").draggable();
	
});


let slideNum = 1;

function getSlideCount(){	
	return($(".event_slide div").length);
}

function moveSlide(slideNum){
	var slideWidth = $(".event_slide > div").width();
	var moveWidth = slideWidth*(slideNum-1)*-1;
	$(".event_slide").stop().animate({"left": moveWidth}, 1000);
}
function moveSlideEnd(goSlide){
	var posType = goSlide==1 ? 1 : -1;
	var slideWidth = $(".event_slide > div").width();	
	var moveWidth = slideWidth*goSlide*posType;
	$(".event_slide").stop().animate({"left": moveWidth}, 0);
}

function schWebinar() {
    alert("웨비나 검색");
}
