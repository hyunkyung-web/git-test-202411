$(function () {
    // 모바일 메뉴
    mobileMenu();

    // article
    // Article 페이지로 돌아가기
    $(".return_list").click(function () {
        callData(2);
    });

    // 댓글 버튼 눌렀을때 입력창 활성화
    $(".icon_comment").click(function () {
        $("#c_box").focus();
    });
    // 댓글 더보기
    showMore(".btn_more", ".comment_box");
    // 좋아요 버튼
    $(".icon_heart").click(function () {
        const img_src = $(".icon_heart").attr("src");
        const icon_like = "/public/images/icon/icon_heart.png";
        const icon_full = "/public/images/icon/icon_heart_full.png";

        if (img_src == icon_like) {
            $(".icon_heart").attr("src", icon_full);
        } else if (img_src == icon_full) {
            $(".icon_heart").attr("src", icon_like);
        }
    });

    // 댓글 달기 + 삭제
    $(".btn_chat").click(function () {
        // 댓글 입력값 가져오기
        var commentText = $("#c_box").val();

        // 댓글 내용이 비어 있으면 입력을 막고 알림
        if (commentText === "") {
            alert("댓글을 입력해주세요!");
            return;
        }

        // 댓글 항목 추가
        addComment(commentText);

        // 댓글 입력창 초기화
        $("#c_box").val("");
        $("#c_box").css("height", "auto"); // 입력창 크기 초기화
    });

    $(".comments_area").on("click", ".delete", function () {
        $(this).parent(".comment_box").remove();
    });

    // support

    // 담당자 검색 - 닫기
    $(".select_contact").click(function () {
        getAssignee();
    });
    $(".close").click(function () {
        $(".blind, .assigneeList").hide();
    });

    // 담당자 검색 - 검색 버튼
    // Enter 키 입력 시 검색 버튼 클릭
    $("#searchInput").on("keypress", function (event) {
        if (event.key === "Enter") {
            $(".searchButton").click();
        }
    });

    // 검색 버튼 클릭 시 검색 수행
    $(".searchButton").click(function () {
        var query = $("#searchInput").val();
        console.log("검색어: " + query);
        // 실제 검색 로직을 추가할 수 있습니다.
    });

    // 담당자 검색 -> 다음
    $(".btn_select").click(function () {
        selectAssignee();
    });

    // 요청 타입 선택
    $("input[name=type]").click(function () {
        toggleFields();
    });

    // 요청하기 버튼 클릭
    $(".requestButton").click(function () {
        validateRequest();
    });
});

// 모바일 메뉴
function mobileMenu() {
    const hamburgerMenu = $(".hamburger-menu");
    const signupLink = $(".signup");
    const navLinks = $(".menu-toggle");

    navLinks.click(function () {
        hamburgerMenu.toggleClass("active");
        signupLink.toggleClass("active");
        navLinks.toggleClass("active");
    });
}

// 페이지 이동
function callData(pageNum) {
    var callUrl;

    switch (pageNum) {
        // main
        case 1:
            callUrl = "/";
            break;
        //member
        case 11:
            callUrl = "/member/verify";
            break;
        case 12:
            callUrl = "/member/signup";
            break;
        // article
        case 2:
            callUrl = "/article/list";
            break;
        case 21:
            callUrl = "/article/node";
            break;
        //support
        case 3:
            callUrl = "/support/call";
            break;
    }

    window.location.href = callUrl;
}

// 댓글 더보기
function showMore(button, contentBox) {
    // 댓글 갯수 5이하 더보기 버튼 안보이기
    if ($(contentBox).length <= 5) {
        $(button).hide(); // 더보기 버튼 숨기기
        $(contentBox).addClass("show"); // 모든 댓글 표시
    } else {
        // 댓글 갯수 5개 이상일 때, 처음 5개만 표시
        $(contentBox).slice(0, 5).addClass("show");

        // 더보기 버튼 클릭 시 동작
        $(button).click(function (e) {
            e.preventDefault();
            // 숨겨진 댓글 중 5개를 표시
            $(contentBox + ":hidden'")
                .slice(0, 5)
                .addClass("show");

            // 더 이상 숨겨진 댓글이 없으면 더보기 버튼 숨기기
            if ($(contentBox + ":hidden'").length === 0) {
                $(button).hide(); // 더보기 버튼 숨김
                $(".btn_fold").show(); // 댓글 접기 버튼 활성화
            }
        });
    }

    // 댓글 접기 버튼
    $(".btn_fold").click(function () {
        $(contentBox).removeClass("show");
        $(contentBox).slice(0, 5).addClass("show");
        $(this).hide(); // 댓글 접기 버튼 사라짐
        $(button).show(); // 더보기 버튼 활성화
    });
}

// 댓글 textarea 자동 높이 조절 + 입력 버튼 활성화
function resize(obj) {
    obj.style.height = "auto"; // 기존 높이 값을 제거하고
    obj.style.height = obj.scrollHeight + "px"; // 자동 크기 조정

    // 버튼 활성화/비활성화
    if (obj.value.length > 0) {
        $(".btn_chat").addClass("on");
    } else {
        $(".btn_chat").removeClass("on");
    }
}

// 댓글 달기
var commentCount = 0; // 댓글 개수를 추적하는 변수
function addComment(text) {
    // 기존 댓글 개수 추적
    commentCount = $(".comment_box").length;
    // 댓글 HTML 생성
    var newComment = $('<div class="comment_box show"></div>');

    // 댓글 작성자 이름, 텍스트 및 삭제 버튼 추가
    var name = $('<span class="c_name"></span>').text("홍길동"); // 작성자 이름 임의 설정함.
    var deleteButton = $('<span class="delete"><i class="fa-solid fa-minus"></i></span>');
    var commentText = $('<span class="c_text"></span>').text(text);

    // 댓글 요소에 name, deleteButton, text 추가
    newComment.append(name).append(deleteButton).append(commentText);

    console.log(commentCount);
    // 댓글 목록에 추가
    $(".comments_area").prepend(newComment);
    commentCount++; // 댓글 개수 증가
    console.log(commentCount);

    // 댓글이 5개 이상이면 더보기 버튼 보이기
    if (commentCount > 5) {
        $(".btn_more").show();
        $(".comment_box").slice(5).removeClass("show"); // 6번째 댓글부터 숨기기
    }
}

// 고객지원 페이지 탭 메뉴
function swithchTab(e) {
    $(".index, .container").removeClass("active");
    $(e).addClass("active");

    if ($(e).hasClass("index_1")) {
        $(".request-container").addClass("active");
    } else if ($(e).hasClass("index_2")) {
        $(".request-history").addClass("active");

        // 요청 내역 유무에 따른 박스 구성
        const hasRequest = $(".tableBody.user .rowItem").length;
        if (hasRequest > 0) {
            $(".requestNone").hide();
            $(".tableWrapper.user").show();
            // showMore(".btn_more", ".requestItem");
        } else {
            $(".tableWrapper.user").hide();
            $(".requestNone").show();
        }
    }
}

// 담당자 검색
function getAssignee() {
    // 담당자 목록 보여지기
    $(".blind, .assigneeList").show();

    // check all
    $("#chk_all").click(function () {
        if ($("#chk_all").prop("checked") == true) {
            $("input[name=chk_p]").prop("checked", true);
        } else {
            $("input[name=chk_p]").prop("checked", false);
        }
    });
    // 체크 해제 시 check all 해제
    $("input[name=chk_p]").click(function () {
        let checkbox = $("input[name=chk_p]");
        let total = checkbox.length;
        let checked = $("input[name=chk_p]:checked").length;

        if (total != checked) {
            $("#chk_all").prop("checked", false);
        } else {
            $("#chk_all").prop("checked", true);
        }

        // 체크박스 하나씩만 선택되게 하기
        if ($(this).prop("checked")) {
            checkbox.prop("checked", false);
            $(this).prop("checked", true);
        }
    });
}

// 담당자 검색 -> 다음
function selectAssignee() {
    // 다음 클릭 시 data check & $("#partner")에 data 입력
    var assigneeList = "";
    // var emailList = "";

    const checkbox = $("input[name=chk_p]:checked");

    if (checkbox.length == 0) {
        alert("담당자를 선택해 주세요.");
    } else if (checkbox.length > 1) {
        alert("담당자는 한 명만 선택할 수 있습니다.");
    } else {
        checkbox.each(function (i) {
            var tr = checkbox.parent().parent().eq(i);
            var td = tr.children();

            var p_name = td.eq(1).text();
            var p_email = td.eq(2).text();

            // assigneeList += p_name + " / ";
            assigneeList += p_name + "(" + p_email + ") / ";
        });

        // 마지막 "/ " 제거
        assigneeList = assigneeList.substring(0, assigneeList.length - 2);
        // assigneeList = assigneeList.substring(0, assigneeList.length - 3);
        $(".blind, .assigneeList").hide();
        $("#partner").val(assigneeList);
    }
}

// 요청 타입 선택에 따른 상세 입력 박스 show-hide
function toggleFields() {
    // 요청 type 선택 여부
    const chkVisit = $("#call_visit").prop("checked");
    const chkDoc = $("#call_doc").prop("checked");
    const chkEtc = $("#call_etc").prop("checked");

    // 상세 정보 입력 박스 hide
    $(".inform_box").hide();
    // radio 버튼 클릭 시 빨간 강조 효과 삭제
    $("#call_type, .inform_box input, .inform_box textarea").removeClass("warn");

    if (chkVisit == true) {
        // 요청 type - 방문요청 선택 시 해당 상세 정보 입력 박스 show
        $(".visit_box").show();
    } else if (chkDoc == true || chkEtc == true) {
        // 자료요청, 기타 선택 시 해당 박스 show
        $(".doc_box").show();
    }
}

// 요청하기 버튼 클릭 시 입력사항 체크
function validateRequest() {
    /* ******* 값 구하기 ******* */
    // 담당자 선택 여부
    const valPartner = $("#partner").val();
    // 요청 type 선택 여부
    const chkVisit = $("#call_visit").prop("checked");
    const chkDoc = $("#call_doc").prop("checked");
    const chkEtc = $("#call_etc").prop("checked");
    // 방문요청 - 날짜 선택 여부
    const valDate = $("#date").val();
    // 방문요청 - 요청 내용 입력 여부
    const valCallText = $("#call_detail").val();
    // 자료요청, 기타 - 요청 내용 입력 여부
    const valDocText = $("#doc_detail").val();

    /* ******* data check ******* */
    // true : 날짜 or 내용 입력 X / false: 날짜 or 내용 입력 O
    let chkPartner = valPartner == "";

    let chkDate = chkVisit == true && (valDate == "" || valDate == null || valDate == undefined);
    let chkCallDetail = chkVisit == true && valCallText == "";
    let chkDocDetail = (chkDoc == true || chkEtc == true) && valDocText == "";

    // true : type 선택 / false: type 선택 X
    let chkType = chkVisit == true || chkDoc == true || chkEtc == true;

    /* ******* data check -> 값이 없을 경우 warn class 추가 ******* */
    // 담당자
    if (chkPartner) {
        $("#partner").addClass("warn");
    }

    // 요청 타입
    if (chkType) {
        $("#call_type").removeClass("warn");
    } else {
        $("#call_type").addClass("warn");
    }

    // 방문요청 - 날짜
    if (chkDate) {
        $("#date").addClass("warn");
    } else if (chkCallDetail) {
        $("#call_detail").addClass("warn");
    }
    $("#date").focus(function () {
        $("#date").removeClass("warn");
    });

    // 자료요청/기타 - 요청 내용 입력
    if (chkDocDetail) {
        $("#doc_detail").addClass("warn");
    }
    $("textarea").focus(function () {
        $("textarea").removeClass("warn");
    });

    // 모든 입력값 입력 완료 -> alert창 띄우기 + 원래 상태로 돌아가기
    if (chkPartner == false && chkType == true && chkDate == false && chkCallDetail == false && chkDocDetail == false) {
        alert("요청 완료되었습니다.");
        $("input, textarea").val("");
        $("input, textarea").removeClass("warn");
        $("input[type=radio], input[type=checkbox]").prop("checked", false);
        $(".inform_box").hide();
    }
}

// 고객지원 페이지 요청내역 유무
function hasRequest() {
    // 요청 내역이 존재하는지 판별하는 로직
    return $(".tableBody.user .rowItem").length > 0;
}
