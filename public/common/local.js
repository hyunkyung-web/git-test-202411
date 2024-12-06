$(function () {
	$(window).resize(function () {
		//        location.reload();
	});
	//btn search

	$(".btn_slide").click(function (e) {
		var btnGb = $(this).attr("class").replace("btn_slide ", "");
		var slideTotalCnt = getSlideCount();

		if (btnGb == "right") {
			if (slideNum + 1 <= slideTotalCnt) {
				slideNum++;
			} else {
				//마지막 슬라이드에서 1번 슬라이드로 되돌리기
				moveSlideEnd(1);
				slideNum = 1;
			}
		} else {
			if (slideNum > 1) {
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
		swipe: function (
			event,
			direction,
			distance,
			duration,
			fingerCount,
			fingerData
		) {
			var slideTotalCnt = getSlideCount();

			if (direction == "left") {
				if (slideNum + 1 <= slideTotalCnt) {
					slideNum++;
				} else {
					//마지막 슬라이드에서 1번 슬라이드로 되돌리기
					moveSlideEnd(1);
					slideNum = 1;
				}
			} else if (direction == "right") {
				if (slideNum > 1) {
					slideNum--;
				} else {
					//첫번째 슬라이드에서 마지막 슬라이드로 이동
					moveSlideEnd(slideTotalCnt);
					slideNum = slideTotalCnt;
				}
			}
			moveSlide(slideNum);
		},
	});

	if ($("#pagination").length) {
		usePagination();
	}
	if ($("#editor").length) {
		initializeFroalaEditor();
	}

	$(".sub-list-toggle").on("click", function () {
		const subList = $(this).next("ul");
		subList.toggle();

		const icon = $(this).find("i");
		if (subList.is(":visible")) {
			icon.removeClass("fa-chevron-down").addClass("fa-chevron-up");
		} else {
			icon.removeClass("fa-chevron-up").addClass("fa-chevron-down");
		}
	});

	$(".sidebar-toggle").on("click", function () {
		const sidebar = $(".sidebar");
		sidebar.toggleClass("collapsed");
		// const icon = $(this).find("i");

		if (sidebar.hasClass("collapsed")) {
			// icon.removeClass("fa-chevron-left").addClass("fa-chevron-right");
			$(this).addClass("move");
		} else {
			// icon.removeClass("fa-chevron-right").addClass("fa-chevron-left");
			$(this).removeClass("move");
		}
	});
});

let slideNum = 1;

function getSlideCount() {
	return $(".event_slide div").length;
}

function moveSlide(slideNum) {
	var slideWidth = $(".event_slide > div").width();
	var moveWidth = slideWidth * (slideNum - 1) * -1;
	$(".event_slide").stop().animate({ left: moveWidth }, 1000);
}
function moveSlideEnd(goSlide) {
	var posType = goSlide == 1 ? 1 : -1;
	var slideWidth = $(".event_slide > div").width();
	var moveWidth = slideWidth * goSlide * posType;
	$(".event_slide").stop().animate({ left: moveWidth }, 0);
}

function schWebinar() {
	alert("웨비나 검색");
}

function initializeFroalaEditor() {
	new FroalaEditor("#editor", {
		toolbarInline: false,
		charCounterCount: false,
		quickInsert: false,
		placeholderText: "내용을 입력하세요...",
	});
}

function usePagination() {
	const itemsPerPage = 10;
	const totalItems = $("#item-list tr").length;

	$("#pagination").twbsPagination({
		totalPages: Math.ceil(totalItems / itemsPerPage),
		visiblePages: 10,
		onPageClick: function (event, page) {
			const start = (page - 1) * itemsPerPage;
			const end = start + itemsPerPage;

			// 현재 페이지 행
			$("#item-list tr").hide().slice(start, end).show();
		},
	});

	$("#item-list tr").hide().slice(0, itemsPerPage).show();
}
