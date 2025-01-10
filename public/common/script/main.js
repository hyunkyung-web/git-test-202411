$(function () {
    //
    member_height(".member-wrap + footer");

    // 모바일 메뉴
    mobileMenu();

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
    $("input[name=type]").click(function () {
        supportCall();
    });
    chkData();
});

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
// document.addEventListener("DOMContentLoaded", function () {});

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
            $(".comment_box:hidden").slice(0, 5).addClass("show"); // 클릭시 more 갯수 지저정
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
function member_height(obj) {
    const wrap_h = $(".member-wrap").height();
    const container_h = $(".container").height();
    const window_h = $(window).height();
    const wrap_h_re = window_h - 240;
    const wrap_h_half = (wrap_h_re - container_h) / 2.5;
    console.log(container_h);

    if (wrap_h < wrap_h_re) {
        $(obj).addClass("fix");

        $(".member-wrap").height(wrap_h_re);
        $(".member-wrap").css("padding-top", wrap_h_half);

        if ($(".member-wrap").hasClass("support-wrap")) {
            $(obj).removeClass("fix");
            $(".member-wrap").addClass("scroll");
            $(".member-wrap").css("padding", "60px 0");
        }

        // $("body").css("background-color", "#fff");
    } else if (wrap_h > wrap_h_re) {
        $(".member-wrap").height(wrap_h_re);
        $(".member-wrap").addClass("scroll");
        $(".member-wrap").css("padding", "20px 0");
    }
}

// support call

function supportCall() {
    const chkVisit = $("#call_visit").prop("checked");
    const chkDoc = $("#call_doc").prop("checked");
    const chkEtc = $("#call_etc").prop("checked");

    $(".inform_box").hide();
    if (chkVisit == true) {
        $("#partner").removeClass("warn");
        $(".visit_box").show();
    } else if (chkDoc == true || chkEtc == true) {
        $("#type").removeClass("warn");
        $(".doc_box").show();
    }
}

function chkData() {
    const valPartner = $("#partner").val();
    const valCall = $(".call_box input").prop("checked");
    const valDate = $("#visit").val();
    const valDocText = $("#doc_detail").val();
    // const valCall = $("#")
    console.log(valPartner);
    // 요청하기 버튼 클릭시 필수 입력값 강조
    $(".btn_request").click(function () {
        if (valPartner == "") {
            $("#partner").addClass("warn");
        } else if (valCall == false) {
            $("#type").addClass("warn");
        } else if (valDate == "") {
            $("#date").addClass("warn");
        } else if (valCall == true && valDocText == "") {
            $("#doc_detail").addClass("warn");
        }
    });
}
