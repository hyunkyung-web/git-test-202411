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
    showMore(".btn_more");
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

    // support
    // 고객지원 - 탭 메뉴
    // swithchTab();

    // 담당자 검색 - 닫기
    $(".select_contact").click(function () {
        getAssignee();
    });
    $(".close").click(function () {
        $(".blind, .assigneeList").hide();
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
    $(".btn_request").click(function () {
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

// 댓글 textarea 자동 높이 조절 + 입력 버튼 활성화
function resize(obj) {
    if (obj.style.height == "0px" || obj.scrollHeight == 0) {
        obj.style.height = "auto";
    } else {
        obj.style.height = "auto";
        obj.style.height = obj.scrollHeight + "px";
    }

    if (obj.value.length > 0) {
        $(".btn_chat").addClass("on");
    } else {
        $(".btn_chat").removeClass("on");
    }
}

// 댓글 더보기
function showMore(obj) {
    // 댓글 갯수 5이하 더보기 버튼 안보이기
    if ($(".comment_box").length <= 5) {
        $(obj).hide();
        $(".comment_box").addClass("show");
    } else {
        // 댓글 갯수 5이상 더보기 버튼 보이기
        $(".comment_box").slice(0, 5).addClass("show");
        $(obj).click(function (e) {
            e.preventDefault();
            $(".comment_box:hidden").slice(0, 5).addClass("show"); // 클릭시 more 갯수 지정
            if ($(".comment_box:hidden").length == 0) {
                // 컨텐츠 남아있는지 확인
                $(obj).hide(); // 컨텐츠 없을 시 더보기 버튼 사라짐
                $(".btn_fold").show(); // 댓글 접기 버튼 활성화
            }
        });
    }

    // 댓글 접기 버튼
    $(".btn_fold").click(function () {
        $(".comment_box").removeClass("show");
        $(".comment_box").slice(0, 5).addClass("show");
        $(this).hide(); // 댓글 접기 버튼 사라짐
        $(obj).show(); // 더보기 버튼 활성화
    });
}

// member 높이 조정
// function member_height(obj) {
//     const wrap_h = $(".member-wrap").height();
//     const container_h = $(".container").height();
//     const window_h = $(window).height();
//     const wrap_h_re = window_h - 240;
//     const wrap_h_half = (wrap_h_re - container_h) / 2.5;
//     console.log(container_h);

//     if (wrap_h < wrap_h_re) {
//         $(obj).addClass("fix");

//         $(".member-wrap").height(wrap_h_re);
//         $(".member-wrap").css("padding-top", wrap_h_half);

//         if ($(".member-wrap").hasClass("support-wrap")) {
//             $(obj).removeClass("fix");
//             $(".member-wrap").addClass("scroll");
//             $(".member-wrap").css("padding", "60px 0");
//         }
//     } else if (wrap_h > wrap_h_re) {
//         $(".member-wrap").height(wrap_h_re);
//         $(".member-wrap").addClass("scroll");
//         $(".member-wrap").css("padding", "20px 0");
//     }
// }

// 고객지원 페이지 탭 메뉴
function swithchTab(e) {
    $(".index, .container").removeClass("active");
    $(e).addClass("active");

    if ($(e).hasClass("index_1")) {
        $(".request-container").addClass("active");
    } else if ($(e).hasClass("index_2")) {
        $(".request-history").addClass("active");

        // 요청 내역 유무에 따른 박스 구성
        if (hasRequest()) {
            $(".requestNone").hide();
            $(".tableWrapper.user").show();
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
        $("input[type=radio], input[type=checkbox]").prop("checked", false);
        $(".inform_box").hide();
    }
}

// 고객지원 페이지 요청내역 유무
function hasRequest() {
    // 요청 내역이 존재하는지 판별하는 로직
    return $(".tableBody.user .rowItem").length > 0;
}
